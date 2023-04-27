<?php

namespace App\Helpers\Sms\Getaways;

use App\Helpers\Sms\Src\SmsModel;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class BanglalinkSmsGetaway extends SmsModel
{

    protected $url = 'https://vas.banglalink.net/sendSMS/sendSMS';


    protected $query_params = [
        'message' => 'message',
        'passwd' => 'configuration.pass',
        'userID' => 'configuration.user',
        'sender' => 'sender',
        'msisdn' => 'phone',
    ];

    protected function params(SmsModel $sms, $phone): array
    {
        $params = parent::params($sms, $phone);
        $params['passwd'] = base64_decode($params['passwd']);

        return $params;
    }
}
