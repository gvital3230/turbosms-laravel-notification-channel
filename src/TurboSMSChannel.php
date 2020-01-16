<?php

namespace NotificationChannels\TurboSMS;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\TurboSMS\Exceptions\CouldNotSendNotification;

class TurboSMSChannel
{
    protected $login;
    protected $password;
    protected $wsdl_endpoint;
    protected $sender;
    protected $debug;

    /**
     * @return mixed
     */
    public function getWsdlEndpoint()
    {
        return $this->wsdl_endpoint;
    }

    public function __construct(array $config = [])
    {
        $this->login = $config['login'];
        $this->password = $config['password'];
        $this->wsdl_endpoint = $config['wsdl_endpoint'];
        $this->sender = $config['sender'];
        $this->debug = $config['debug'];
    }

    /**
     * @return \SoapClient
     * @throws CouldNotSendNotification
     */
    protected function getClient()
    {
        try {
            return new \SoapClient($this->wsdl_endpoint);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithEndPoint($exception);
        }
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     *
     * @param Notification $notification
     * @return array
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var TurboSMSMessage $message */
        $message = $notification->toTurboSMS($notifiable);
        $message->to = $notifiable->routeNotificationFor('turbosms');
        $sms = [
            'sender' => $this->sender,
            'destination' => $message->to,
            'text' => $message->body,
        ];
        if ($this->debug) {
            Log::info('TurboSMS sending sms - '.print_r($sms, true));
        }

        $auth = [
            'login' => $this->login,
            'password' => $this->password,
        ];

        $client = $this->getClient();
        $client->Auth($auth);
        $result = $client->SendSMS($sms);

        if ($this->debug) {
            Log::info('TurboSMS send result - '.print_r($result->SendSMSResult->ResultArray, true));
        }

        return $result;
    }
}
