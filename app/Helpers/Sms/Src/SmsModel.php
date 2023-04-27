<?php


namespace App\Helpers\Sms\Src;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Http;
use ReflectionClass;

abstract class SmsModel
{
    protected $response = null;

    protected $configuration = [];
    protected $url    = null;
    protected $phone    = null;
    protected $message     = null;
    protected $sender   = null;

    protected $query_params = [];

    protected $sending_method = 'post';

    /**
     * @param $configuration
     */
    public function __construct($configuration = [])
    {
        $this->setConfiguration($configuration);
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text = "")
    {
        $this->message = $text;
        return $this;
    }

    /**
     * @param $recipient
     * @return $this
     */
    public function setRecipient($recipient = "")
    {
        $this->phone = $recipient;
        return $this;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function send($phone = null)
    {

        $this->phone = $this->phone ?? $phone;

        $this->phone = preg_match("/^88/", $this->phone)
            ? $this->phone
            : "88" . $this->phone;

        $params = $this->params($this, $this->phone);


        if (!empty($this->url) && isset($params['message'])) {

            //            $params['message'] = $params['message'];

            $this->response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->withOptions([
                'query' => $params
            ])->{$this->sending_method}($this->url);
        }

        return $this;
    }


    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    protected function get_query_params_value($identifier)
    {

        if (preg_match("/^([a-z_]+)\.([a-z_]+)$/i", $identifier, $matches)) {
            return $this->{$matches[1]}[$matches[2]] ?? null;
        } else {
            return $this->{$identifier} ?? '';
        }
    }

    protected function params(SmsModel $sms, $phone): array
    {

        $params = [];
        foreach ($this->query_params as $key => $identifier) {
            $params[$key] = $this->get_query_params_value($identifier);
        }

        if ($sms->sender) {
            $params['sender'] = $sms->sender;
        }

        return $params;
    }
}
