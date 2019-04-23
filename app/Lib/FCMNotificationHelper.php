<?php

namespace App\Lib;

use Log as Log;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class FCMNotificationHelper
{
    public static function enviarNotificacion($receptores, $titulo, $notificacion) {
        if (count($receptores) == 0) return;
        
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        
        $notificationBuilder = new PayloadNotificationBuilder($titulo);
        $notificationBuilder->setBody($notificacion)->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = \App\Device::whereIn('user_id', $receptores)->pluck('token')->toArray();
   
        if($token != null)
            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }
}