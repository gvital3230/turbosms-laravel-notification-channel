<?php

namespace NotificationChannels\TurboSMS;

use Illuminate\Support\ServiceProvider;

class TurboSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(TurboSMSChannel::class)
            ->give(function () {

                //config/services.php
//                ...
//                'turbosms' = [
//                    'wsdl_endpoint' => env('TURBOSMS_WSDLENDPOINT', 'http://turbosms.in.ua/api/wsdl.html'),
//                    'login' = env('TURBOSMS_LOGIN'),
//                    'password' = env('TURBOSMS_PASSWORD'),
//                    'sender' = env('TURBOSMS_SENDER')
//                ],
//                ...

                return new TurboSMSChannel(config('services.turbosms'));
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
