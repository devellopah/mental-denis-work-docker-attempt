<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use App\StudentTask;
use App\GroupTask;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $inGroup = !is_null($student->group_id);

        return view('student.show', compact('student', 'inGroup'));
    }

    /**
     * Display student tasks
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTasks(Student $student)
    {

        $student_tasks_active = $student->tasks->where('is_finished', '0');
        $student_tasks_finished = $student->tasks->where('is_finished', '1');

        $group_tasks_active = $student->activeGroupTasks;
        $group_tasks_finished = $student->finishedGroupTasks;

        return view('student.tasks', compact(
            'student',
            'student_tasks_active', 
            'student_tasks_finished',
            'group_tasks_active',
            'group_tasks_finished'
            )
        );
    }

    public function playStudentTask(Student $student, StudentTask $task) {
        $trainer_id = $task->trainer_id;
        $trainer_name = $task->trainer_name;
        $student_id = $student->id;
        $task_type = "student";
        

        if($task->is_finished) {
            return redirect()->route('student.tasks', ['student_id' => $student_id]);
        }

        return view('student.student_task', compact('task', 'trainer_id', 'student_id', 'trainer_name', 'task_type'));
    }

    public function playGroupTask(Student $student, GroupTask $task) {
        $trainer_id = $task->trainer_id;
        $trainer_name = $task->trainer_name;
        $student_id = $student->id;
        $task_type = "group";
        $groupTaskStats = \App\GroupTaskStudent::where(['student_id' => $student_id, 'group_task_id' => $task->id])->select('is_finished')->first();
        
        if($groupTaskStats->is_finished) {
            return redirect()->route('student.tasks', ['student_id' => $student_id]);
        }

        return view('student.group_task', compact('task', 'trainer_id', 'student_id', 'trainer_name', 'task_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
