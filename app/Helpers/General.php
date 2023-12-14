<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use File;
use App\Models\{Product,Order};

class General extends Controller
{
    // use for website notification
    public static function sendWebNotification($notification, $data, $FcmTokens)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
          
        $serverKey = env('FIREBASE_SERVER_KEY');
        // return $FcmTokens;
        $data = [
            "registration_ids" => $FcmTokens,
            "notification" => $notification,
            "data" => $data,
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            return 'Curl failed: ' . curl_error($ch);
            \Log::info('Curl failed: ' . curl_error($ch));
        }        
        
        // Close connection
        curl_close($ch);
        // FCM response
        \Log::info('Curl failed: ' . $result);
        return $result;
        dd($result);        
    }
}