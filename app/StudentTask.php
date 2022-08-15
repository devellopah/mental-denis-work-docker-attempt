<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentTask extends Model
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
    'student',
    'level',
    'req_formulas',
    'minmax',
    'quantity',
    'nums',
    'speed',
    'subtraction',
    'started_time',
    'lead_time',
    'points',
    'accuracy',
    'student_id',
    'is_finished',
  ];

  // protected $appends = ['student'];

  // public function getStudentAttribute() {
  //   return \App\Trainer::find(1)->select('name')->get();
  // }

  public function student() {
    return $this->belongsTo(Student::class);
  }
}
