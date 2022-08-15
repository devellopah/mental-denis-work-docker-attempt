<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'theme',
    'level',
    'note',
    'message',
    'user_id',
    'group_id',
  ];

    protected $appends = ['username', 'points', 'numbers', 'rombs', 'all'];

    public function getUsernameAttribute()
    {
        return $this->user->name;
    }

    public function getPointsAttribute()
    {
        return $this->user->stats->first()->points + $this->user->stats->last()->points;
    }

    public function getNumbersAttribute()
    {
        return $this->user->stats->first();
    }
    public function getRombsAttribute()
    {
        return $this->user->stats->last();
    }

    public function getAllAttribute()
    {
        $numbers_answers_total = $this->user->stats->first()->answers_total;
        $rombs_answers_total = $this->user->stats->last()->answers_total;

        $numbers_points = $this->user->stats->first()->points;
        $rombs_points = $this->user->stats->last()->points;

        $answers_accuracy = null;

        if($numbers_answers_total > 0 && $rombs_answers_total > 0) {
        $answers_accuracy = round( ( intval($this->user->stats->first()->answers_accuracy) + intval($this->user->stats->last()->answers_accuracy) ) / 2 ) . '%';
        }

        else {

        if($numbers_answers_total === 0) {
            $answers_accuracy = $this->user->stats->last()->answers_accuracy;
        }
    
        if($rombs_answers_total === 0) {
            $answers_accuracy = $this->user->stats->first()->answers_accuracy;
        }
        }

        $all = collect([
        'answers_total' => $numbers_answers_total +  $rombs_answers_total,
        'answers_correct' => $this->user->stats->first()->answers_correct +  $this->user->stats->last()->answers_correct,
        'answers_wrong' => $this->user->stats->first()->answers_wrong +  $this->user->stats->last()->answers_wrong,
        'answers_accuracy' => $answers_accuracy,
        'answers_rating' => $this->user->getRating($answers_accuracy),
        'points' => $numbers_points + $rombs_points
        ]);

        return $all;
    }

  public function user() 
  {
      return $this->belongsTo(User::class);
  }

  public function group() 
  {
    return $this->belongsTo(Group::class);
  }

  public function tasks() 
  {
    return $this->hasMany(StudentTask::class);
  }

  public function activeGroupTasks() 
  {
    return $this->groupTasks()->wherePivot('is_finished', 0);
  }

  public function finishedGroupTasks() 
  {
    return $this->groupTasks()->wherePivot('is_finished', 1);    
  }

  public function groupTasks() 
  {
    return $this
      ->belongsToMany(GroupTask::class)
      ->using(GroupTaskStudent::class)
      ->withPivot('started_time', 'lead_time', 'points', 'accuracy', 'is_finished');
  }
}
