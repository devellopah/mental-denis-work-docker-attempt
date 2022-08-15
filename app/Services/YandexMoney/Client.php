<?php

namespace App\Services\YandexMoney;

require_once __DIR__ . "/Base.php";

use YandexMoney\YandexBaseAPI;

class Client extends YandexBaseAPI {

    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    public function createPayment() {
        $url = $this->moneyUrl . 'payments';
        $options = array(
            'amount' =>  array(
                'value' => '100.00',
                'currency' => 'RUB'
            ),
            'capture' => true,
            "confirmation" => array(
                'type' => 'redirect',
                'return_url' => 'https://mental.bespalov.digital/success'
            )
        );
        $result = $this->sendRequest($url, $options, $this->access_token);
        return $result;
    }

}

?>