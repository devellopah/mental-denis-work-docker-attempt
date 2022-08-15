<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tasks extends Model
{
    protected $fillable = [
        'name',
        'status',
        'description_short',
        'description_detail',
        'purpose',
        'result',
        'category_id',
        'starting_at',
        'expires_at',
        'creator_id',
        'executor_id',
        'image_id',
    ];
    protected $dates = ['created_at', 'updated_at'];

    protected $dateFormat = 'd.m.Y';

    /**
     * Set the starting_at attribute
     *
     * @param $date
     */
    public function setStartingAtAttribute($date)
    {
        $this->attributes['starting_at'] = Carbon::parse($date);
    }


    /**
     * Set the expires_at attribute
     *
     * @param $date
     */

    public function setExpiresAtAttribute($date)
    {
        $this->attributes['expires_at'] = Carbon::parse($date);
    }

    public function getStartingAtAttribute($date)
    {
        return Carbon::parse($date)->format($this->dateFormat);
    }

    public function getExpiresAtAttribute($date)
    {
        return Carbon::parse($date)->format($this->dateFormat);
    }

    /**
     * owner of task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * task have many files
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function files()
    {
        return $this->belongsToMany('App\Files');
    }

    /**
     * task have avatar
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function avatar()
    {
        return $this->hasOne('\App\Files', 'id', 'image_id');
    }

    public function filesByType()
    {
        return $this->belongsToMany('App\Files')->get()->groupBy('type');

    }

    public function comments()
    {
        return $this->belongsTo('App\TaskComments', 'id', 'tasks_id');
    }

    public function commentsSorted()
    {
        return $this->belongsTo('App\TaskComments', 'id', 'tasks_id')->orderBy('created_at', 'desc')->get();
    }

    public function category()
    {
        return $this->belongsTo(TaskCategory::class);
    }
}
