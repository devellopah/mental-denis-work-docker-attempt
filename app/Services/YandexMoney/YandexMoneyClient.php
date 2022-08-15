<?php

namespace App\Services\YandexMoney;
require_once('yandex-checkout-sdk-php-master/lib/autoload.php');

use \Illuminate\Support\Facades\Config;
use App\PaymentTransaction;
use YandexCheckout\Model\NotificationEventType;
use Illuminate\Support\Facades\Log;

class YandexMoneyClient {

    private $config;

    public function __construct()
    {
       $this->config = Config::get('payment');
    }

    public function createPayment($id, $name, $cost, $user_id) {
        $result = array();
        $client = new \YandexCheckout\Client();
        $client->setAuth($this->config['app_id'], $this->config['client_secret']);
        $description = str_replace('{name}', $name, $this->config['description']);
        $response = $client->createPayment(
            array(
                'capture' => true,
                'amount' => array(
                    'value' => $cost,
                    'currency' => 'RUB',
                ),
                'payment_method_data' => array(
                    "type" => "bank_card"
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => $this->config['redirect_success'],
                ),
                'description' => $description,
                'metadata' => array(
                    'user_id' => $user_id,
                    'tariff_id' => $id
                )
            ),
            uniqid('', true)
        );
        $confirmation_url = false;
        if(isset($response->status) and ($response->status != "canceled") and isset($response->confirmation->confirmation_url) and $response->confirmation->confirmation_url) {
            $result['status'] = 'success';
            $result['confirmation_url'] = $response->confirmation->confirmation_url;
        }
        else {

        }
        return $result;
    }

    protected function checkStatus($status)
    {
        switch($status) {

        }

    }

    public function paymentCheck($request)
    {
        /* $data = json_decode($request, true); */
        $object = $request->object;
        if ($request->type == 'notification' && $object['recipient']['account_id'] == $this->config['app_id']) {
            $this->addTransaction($object);
        }
        http_response_code(200);
        exit();
        /* $client = new \YandexCheckout\Client();
        $client->setAuth($this->config['app_id'], $this->config['client_secret']);
        $payment = json_decode(json_encode($client->getPaymentInfo('269e80c2-000f-5000-a000-19723506559d')), true); */

    }

    private function addTransaction($data)
    {
        $transaction = new PaymentTransaction;
        $transaction->user_id = $data['metadata']['user_id'];
        $transaction->order = $data['id'];
        $transaction->tariff_id = $data['metadata']['tariff_id'];
        $transaction->cost = $data['amount']['value'];
        $transaction->status = $data['status'];
        $detail = (!empty($data['cancellation_details']) &&
            count($data['cancellation_details']) > 0) ?
            $this->cancellationDetails($data['cancellation_details']['party'], $data['cancellation_details']['reason']) : '';
        $transaction->details = $detail;
        $transaction->save();
    }

    protected function cancellationDetails($party, $reason)
    {
        $result = '<strong>Инициатор отмены платежа: </strong>';
        switch($party) {
            case 'merchant' : $result .= 'Продавец товаров и услуг'; break;
            case 'yandex_checkout' : $result .= 'Яндекс.Касса'; break;
            case 'payment_network' : $result .= '«Внешние» участники платежного процесса'; break;
        }
        $result .= '<br> ';
        $result .= '<strong>Причина отмены платежа: </strong> ';

        switch($reason) {
            case '3d_secure_failed' : $result .= 'Не пройдена аутентификация по 3-D Secure'; break;
            case 'call_issuer' : $result .= 'Оплата данным платежным средством отклонена по неизвестным причинам'; break;
            case 'card_expired' : $result .= 'Истек срок действия банковской карты'; break;
            case 'country_forbidden' : $result .= 'Нельзя заплатить банковской картой, выпущенной в этой стране'; break;
            case 'fraud_suspected' : $result .= 'Платеж заблокирован из-за подозрения в мошенничестве'; break;
            case 'general_decline' : $result .= 'Причина не детализирована'; break;
            case 'identification_required' : $result .= 'Превышены ограничения на платежи для кошелька в Яндекс.Деньгах'; break;
            case 'insufficient_funds' : $result .= 'Не хватает денег для оплаты'; break;
            case 'invalid_card_number' : $result .= 'Неправильно указан номер карты'; break;
            case 'invalid_csc' : $result .= 'Неправильно указан код CVV2 (CVC2, CID)'; break;
            case 'issuer_unavailable' : $result .= 'Организация, выпустившая платежное средство, недоступна'; break;
            case 'payment_method_limit_exceeded' : $result .= 'Исчерпан лимит платежей для данного платежного средства или вашего магазина'; break;
            case 'payment_method_restricted' : $result .= 'Запрещены операции данным платежным средством'; break;
            case 'permission_revoked' : $result .= 'Нельзя провести безакцептное списание: пользователь отозвал разрешение на автоплатежи'; break;
        }

        return $result;

    }

}

?>