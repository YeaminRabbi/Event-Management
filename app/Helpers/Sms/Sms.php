<?php


namespace App\Helpers\Sms;

use App\Helpers\Sms\Getaways\BanglalinkSmsGetaway;
use App\Helpers\Sms\Src\SmsModel;
use App\Models\Branch;
use App\Providers\BranchServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class Sms
{

    protected static $response = null;


    public static function send($phone, $message)
    {
        $smsGetaway = new BanglalinkSmsGetaway();


        $smsGetaway->setConfiguration([
            'user' => 'GOU',
            'pass' => 'R09VQFJoczE3MQ==',
        ]);

        $smsGetaway->setText($message);
        $smsGetaway->send($phone);
    }
}
