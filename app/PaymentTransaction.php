<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    public function getName()
    {
        return $this->name;
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tariff() {
        return $this->belongsTo('App\PaymentTariffs', 'tariff_id');
    }
}
