<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTariffs extends Model
{
    public function getName()
    {
        return $this->name;
    }

}
