<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\RedirectResponse;
use App\PaymentTariffs;
use \Illuminate\Http\Request;
use App\Http\Requests;

use App\Services\YandexMoney\YandexMoneyClient;



class PaymentController extends Controller
{
    private $config;

    public function _construct()
    {
        //
    }

    public function index()
    {
        return redirect('payment/tariffs');
    }

    public function tariffsList()
    {
        $tariffs = PaymentTariffs::orderBy('name', 'asc')->get();
        return view('payment.tariffs', compact('tariffs'));
    }

    public function tariffNew()
    {
        return view('payment.tariff_new');
    }

    public function tariffAdd(Request $request)
    {
        if (\Auth::user()->rang === 'A') {
            $messages = [
                'name.required' => 'Необходимо заполнить название тарифа',
                'duration.required' => 'Необходимо заполнить продолжительность тарифа',
                'cost.required' => 'Необходимо заполнить стоимость тарифа',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'duration' => 'required',
                'cost' => 'required'
            ], $messages);
            if ($validator->fails()) {
                return redirect('payment/tariffs/new')
                    ->withErrors($validator)
                    ->withInput();
            }
            $tariff = new PaymentTariffs;
            $tariff->name = $request->name;
            $tariff->description = $request->description;
            $tariff->duration = $request->duration;
            $tariff->cost = $request->cost;
            $tariff->save();
            return redirect('payment/tariffs');
        }
        else {
            return redirect()->to('/');
        }
    }

    public function tariffDetail($id)
    {
        $tariff = PaymentTariffs::find($id);
        $messages = ['code' => '', 'text' => ''];
        return view('payment.tariff_detail', compact('tariff', 'messages'));

    }

    public function tariffUpdate(Request $request, $id)
    {
        if (\Auth::user()->rang === 'A') {

            $tariff = PaymentTariffs::find($id);
            $tariff->name = $request->name;
            $tariff->description = $request->description;
            $tariff->duration = $request->duration;
            $tariff->cost = $request->cost;

            $result = $tariff->save();

            if ($result) {

                $messages = ['code' => 'success', 'text' => 'Тариф успешно измененён'];

            } else {
                $messages = ['code' => 'danger', 'text' => 'Ошибка при изменении тарифа'];
            }
        }
        return redirect('payment/tariffs');
    }

    public function tariffDelete(Request $request, $id) {
        if (\Auth::user()->rang === 'A') {
            PaymentTariffs::findOrFail($id)->delete();
        }
        return redirect('payment/tariffs');
    }

    public function paymentProcess(Request $request, $id) {
        $tariff = PaymentTariffs::find($id);
        $user_id = \Auth::user()->id;
        $yaMoney = new YandexMoneyClient;
        $response = $yaMoney->createPayment($id, $tariff->name, $tariff->cost, $user_id);
        if ($response['status'] == 'success') {
            return redirect($response['confirmation_url']);
        }
        else {
            return redirect('payment/fail');
        }
    }

    public function paymentCheck(Request $request) {
        Log::info('payment request', ['request_all' => $request->all()]);
        $yaMoney = new YandexMoneyClient;
        $yaMoney->paymentCheck();
    }
    public function paymentSuccess()
    {
        print_r($_POST);
    }

}


?>