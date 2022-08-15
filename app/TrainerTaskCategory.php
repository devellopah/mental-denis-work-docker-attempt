<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerTaskCategory extends Model
{
    protected $fillable = [
        'name',
        'trainer_id',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'category_id', 'id');
    }

    public function trainer() {
        return $this->belongsTo(Trainer::class);
    }
}
