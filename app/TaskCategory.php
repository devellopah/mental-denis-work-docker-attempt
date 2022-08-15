<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public static function allForSelect()
    {
        return self::all()->mapWithKeys(
            function ($el) {
                return [$el->id => $el->name];
            }
        );
    }
}
