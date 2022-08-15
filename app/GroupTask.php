<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupTask extends Model
{
    //

       /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'trainer_id',
    'trainer_name',
    'level',
    'req_formulas',
    'minmax',
    'quantity',
    'nums',
    'subtraction',
    'group_id',
    'speed',
  ];

  public function group() {
    return $this->belongsTo(Group::class);
  }

  public function students() {
    return $this
      ->belongsToMany(Student::class)
      ->using(GroupTaskStudent::class)
      ->withPivot('started_time', 'lead_time', 'points', 'accuracy', 'is_finished');
  }
}
