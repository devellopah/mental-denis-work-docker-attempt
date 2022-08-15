<?php

namespace App\Http\Controllers\API;

use App\Generator;
use App\Exercise;

use App\Student;

use App\Group;
use App\GroupTask;
use App\StudentTask;
use App\GroupTaskStudent;

use App\User;
use App\Mail\CreateTask;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\Notifications\HometaskFinished;



class TasksController extends Controller
{
      /**
     * Get group tasks
     *
     * @return \Illuminate\Http\Response
     */

    public function getGroupTasks(Request $request)
    {

        $group = Group::find( $request->get('group_id') );

        return response()->json([
            'student_tasks' => $group->getStudentsTasks(), 
            'group_tasks' => $group->tasks,
            'students' => $group->students,
            'ids' => $group->getStudentsIds(),
        ], 
            Response::HTTP_OK
        );
    }

    public function removeTask(Request $request)
    {

        $group = Group::find( $request->get('group_id') );

        $request->get('task_type') == 'group' 
            ? GroupTask::destroy( $request->get('task_id') )
            : StudentTask::destroy( $request->get('task_id') );

        return response()->json([
            'student_tasks' => $group->getStudentsTasks(),
            'group_tasks' => $group->tasks,
        ], Response::HTTP_OK);
    }

    public function handleTaskResult(Request $request) {

        $student = Student::find($request->get('student_id'));

        $stats = \App\Stats::where(['user_id' => $student->user->id, 'trainer_id' => $request->get('trainer_id')])->first();

        $stats->points = $stats->points + $request->get('points');
        $stats->answers_total = $stats->answers_total + $request->get('answers_total');
        $stats->answers_correct = $stats->answers_correct + $request->get('answers_correct');
        $stats->answers_wrong = $stats->answers_wrong + $request->get('answers_wrong');
        $stats->answers_accuracy = strval( round( $stats->answers_correct / $stats->answers_total * 100 ) ) . '%';
        $stats->answers_rating = $stats->user->getRating(round( $stats->answers_correct / $stats->answers_total * 100 ));

        $stats->save();

        // $student->group->user->notify(new HomeTaskFinished($student, $request->get('task_type')));

        if( $request->get('task_type') == "group" ) {

            $updated = $student->groupTasks()->updateExistingPivot( $request->get('group_task_id'), $request->all() );

        } else {

            $updated = \App\StudentTask::find($request->get('student_task_id'))->update($request->all());
            
        }
        
        return response()->json(['updated' => $updated], Response::HTTP_OK); 
    }

    /**
     * Generate tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {

        $data = $request->all();
        $group = Group::find( $request->get('group_id') );
        $ids = $group->getStudentsIds();

        $isStudentTask = $request->has('student_id');


        $rules = [
            'quantity' =>     'required',
            'trainer_id' =>   'required',
            'trainer_name' => 'required',
            'minmax' =>       'required',
            'speed' =>        'required',
            'group_id' =>     'required'
        ];

        if( $data['trainer_id'] == 1 ) {
            $rules['level'] = 'required';
            $rules['req_formulas'] = 'required';
            $rules['nums'] = 'required';
            $rules['subtraction'] = 'required';
        }

        if( $isStudentTask ) {
            $rules['student_id'] = 'required';
            $rules['student'] = 'required';
        }

        if( $isStudentTask ) {

            StudentTask::create( $data );

            return response()->json(['student_tasks' => $group->getStudentsTasks($ids)], Response::HTTP_OK);
        }

        $groupTask = GroupTask::create( $data );

        foreach ($ids as $id) {

            $student = Student::find($id);
            $user = User::find($student->user_id);
            $user_id = mb_convert_encoding($student->user_id, 'UTF-8', 'UTF-8');
            $email = mb_convert_encoding($user->email, 'UTF-8', 'UTF-8');

            $mail_message = (new CreateTask($user_id, $data['trainer_name']));
            Mail::to($email)->queue($mail_message);

            GroupTaskStudent::create( ['student_id' => $id, 'group_task_id' => $groupTask->id] );
        }

        return response()->json(['group_tasks' => $group->tasks], 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getGroupTaskDetails(Request $request)
    {
        return response()->json(['request' => $request], Response::HTTP_OK);
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
     * @param  \App\Generator  $generator
     * @return \Illuminate\Http\Response
     */
    public function show(Generator $generator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Generator  $generator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Generator $generator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Generator  $generator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Generator $generator)
    {
        //
    }
}
