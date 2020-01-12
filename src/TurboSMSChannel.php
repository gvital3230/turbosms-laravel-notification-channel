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

    public function __construct(array $config)
    {
        $this->login = $config['login'];
        $this->password = $config['password'];
        $this->wsdl_endpoint = $config['wsdl_endpoint'];
        $this->sender = $config['sender'];
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     *
     * @param Notification $notification
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
            'text' => $message->body
        ];
        Log::info('TurboSMS sending sms - ' . print_r($sms, true));

//        try {
//            $client = new SoapClient($this->wsdl_endpoint);
//        } catch (\Exception $exception) {
//            throw CouldNotSendNotification::couldNotCommunicateWithEndPoint($exception);
//        }
//
//        $auth = [
//            'login' => $this->login,
//            'password' => $this->password
//        ];
//
//        try {
//            $client->Auth($auth);
//        } catch (\Exception $exception) {
//            throw CouldNotSendNotification::couldNotAuthorize($exception);
//        }
//
//        $result = $client->SendSMS($sms);
//
//        Log::info('TurboSMS send result - ' . print_r($result->SendSMSResult->ResultArray, true));
    }
}
