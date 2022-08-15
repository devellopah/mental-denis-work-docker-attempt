<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'id',
        'name',
        'category_id',
    ];

    public $rules = [
        'name' => 'required',
        'category_id' => 'required',
    ];

    public function tasks()
    {
        return $this->hasMany(TrainerTask::class, 'exercise_id', 'id');
    }
}
