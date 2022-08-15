<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{

    protected $fillable = [
        'points',
        'answers_total',
        'answers_correct',
        'answers_wrong',
        'user_id',
        'trainer_id'
    ];

    public $timestamps = false;
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
