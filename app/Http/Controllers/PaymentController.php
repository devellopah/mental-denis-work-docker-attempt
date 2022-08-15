<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\RedirectResponse;
use App\PaymentTariffs;
use App\PaymentTransaction;
use \Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
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
        if (\Auth::user()->rang === 'A') {
            return view('payment.tariff_new');
        }
        else {
            return redirect()->to('/');
        }

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
        if (\Auth::user()->rang === 'A') {
            $tariff = PaymentTariffs::find($id);
            $messages = ['code' => '', 'text' => ''];
            return view('payment.tariff_detail', compact('tariff', 'messages'));
        }
        else {
            return redirect()->to('/');
        }
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
        $yaMoney = new YandexMoneyClient;
        $yaMoney->paymentCheck($request);
    }

    public function paymentSuccess()
    {
        return view('payment.success');
    }
    public function paymentFail()
    {
        return view('payment.fail');
    }

    public function paymentStatisctic()
    {
        if (\Auth::user()->rang === 'A') {
            $payments = PaymentTransaction::orderBy('created_at', 'desc')->with(['user', 'tariff'])->get();
            return view('payment.stat', compact('payments'))->render();
        }
        else {
            return redirect()->to('/');
        }
    }

    public function transactionDelete(Request $request, $id)
    {
        if (\Auth::user()->rang === 'A') {
            PaymentTransaction::findOrFail($id)->delete();
        }
        return redirect('payment/stat');
    }
}


?>