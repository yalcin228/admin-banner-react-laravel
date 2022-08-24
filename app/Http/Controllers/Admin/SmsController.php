<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public static function SendSms($msisdn, $text)
    {
        $login = 'apagroup';
        $sender = 'Vesti.az';
        $password = 'apa2019eg';
        $key = md5(md5($password) . $login . $text . $msisdn . $sender);
        $text = rawurlencode($text);
        $sendSms = "http://apps.lsim.az/quicksms/v1/send?login={$login}&msisdn={$msisdn}&text={$text}&sender={$sender}&key=$key";
        try {
            return self::SendRequestWithCurl($sendSms);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public static function SendRequestWithCurl($request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $request,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
}
