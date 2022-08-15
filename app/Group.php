<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\StudentTask;

class Group extends Model
{

    protected $fillable = [
        'name',
        'theme',
        'level',
        'message',
        'user_id',
    ];

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tasks() {
        return $this->hasMany(GroupTask::class);
    }

    public function getStudentsIds() {
        return $this->students->pluck('id');
    }

    public function getStudentsTasks() {
        $ids = $this->getStudentsIds();

        return StudentTask::whereIn('student_id', $ids)->get();
    }
}
