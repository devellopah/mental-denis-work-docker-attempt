<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupTaskStudent extends Pivot
{
    protected $table = 'group_task_student';

      protected $fillable = [
        'started_time',
        'lead_time',
        'points',
        'accuracy',
        'student_id',
        'group_task_id',
        'is_finished',
    ];
}
