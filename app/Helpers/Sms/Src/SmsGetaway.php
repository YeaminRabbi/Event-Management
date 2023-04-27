<?php

namespace App\Helpers\Sms\Src;

class SmsGetaway
{

    protected $config = [];


    public function get_config(): array
    {
        return $this->config;
    }


    public function __set($name, $value)
    {
        $this->config[$name] = $value;
    }

    public function __get($name)
    {
        return $this->config[$name];
    }
}
