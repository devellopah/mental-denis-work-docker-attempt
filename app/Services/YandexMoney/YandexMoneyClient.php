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
        $result = '<strong>?????????????????? ???????????? ??????????????: </strong>';
        switch($party) {
            case 'merchant' : $result .= '???????????????? ?????????????? ?? ??????????'; break;
            case 'yandex_checkout' : $result .= '????????????.??????????'; break;
            case 'payment_network' : $result .= '?????????????????? ?????????????????? ???????????????????? ????????????????'; break;
        }
        $result .= '<br> ';
        $result .= '<strong>?????????????? ???????????? ??????????????: </strong> ';

        switch($reason) {
            case '3d_secure_failed' : $result .= '???? ???????????????? ???????????????????????????? ???? 3-D Secure'; break;
            case 'call_issuer' : $result .= '???????????? ???????????? ?????????????????? ?????????????????? ?????????????????? ???? ?????????????????????? ????????????????'; break;
            case 'card_expired' : $result .= '?????????? ???????? ???????????????? ???????????????????? ??????????'; break;
            case 'country_forbidden' : $result .= '???????????? ?????????????????? ???????????????????? ????????????, ???????????????????? ?? ???????? ????????????'; break;
            case 'fraud_suspected' : $result .= '???????????? ???????????????????????? ????-???? ???????????????????? ?? ??????????????????????????'; break;
            case 'general_decline' : $result .= '?????????????? ???? ????????????????????????????'; break;
            case 'identification_required' : $result .= '?????????????????? ?????????????????????? ???? ?????????????? ?????? ???????????????? ?? ????????????.??????????????'; break;
            case 'insufficient_funds' : $result .= '???? ?????????????? ?????????? ?????? ????????????'; break;
            case 'invalid_card_number' : $result .= '?????????????????????? ???????????? ?????????? ??????????'; break;
            case 'invalid_csc' : $result .= '?????????????????????? ???????????? ?????? CVV2 (CVC2, CID)'; break;
            case 'issuer_unavailable' : $result .= '??????????????????????, ?????????????????????? ?????????????????? ????????????????, ????????????????????'; break;
            case 'payment_method_limit_exceeded' : $result .= '???????????????? ?????????? ???????????????? ?????? ?????????????? ???????????????????? ???????????????? ?????? ???????????? ????????????????'; break;
            case 'payment_method_restricted' : $result .= '?????????????????? ???????????????? ???????????? ?????????????????? ??????????????????'; break;
            case 'permission_revoked' : $result .= '???????????? ???????????????? ???????????????????????? ????????????????: ???????????????????????? ?????????????? ???????????????????? ???? ??????????????????????'; break;
        }

        return $result;

    }

}

?>