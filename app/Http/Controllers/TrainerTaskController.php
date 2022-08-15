<?php

namespace App\Http\Controllers;

use App\TrainerTask;
use App\TrainerTaskCategory;
use App\Exercise;
use Illuminate\Http\Request;
use function redirect;

class TrainerTaskController extends Controller
{
  public function getDetails($trainer_id, $category_id, $exercise_id, $task_id)
  {
    $task = TrainerTask::find($task_id);
    $latestSort = TrainerTask::where('exercise_id', $exercise_id)->latest('sort')->first()->sort;
    
    $added_data = ['trainer_id' => $trainer_id, 'category_id' => $category_id];

    if($task->sort == $latestSort) {
      return ['task' => array_merge($task->toArray(), $added_data), 'nextTask' => null, 'latestSort' => $latestSort];
    }

    $nextTask = TrainerTask::where([['sort', '>', $task->sort], ['exercise_id', '=', $exercise_id]])->orderBy('sort', 'asc')->first();

    return [
      'task' => array_merge($task->toArray(), $added_data), 
      'nextTask' => array_merge($nextTask->toArray(), $added_data), 
      'latestSort' => $latestSort,
      'rang' => auth()->user()->rang,
    ];
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index($trainer_id, $category_id, $exercise_id)
  {
      $tasks = TrainerTask::where('exercise_id', $exercise_id)->get();

      return view('trainer_task.index', compact('tasks', 'trainer_id', 'category_id', 'exercise_id'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($trainer_id, $category_id, $exercise_id)
  {
    // $categories = Exercise::all()->keyBy('id')->map(function ($item) {
    //   return $item->name;
    // });

    if( TrainerTask::where('exercise_id', $exercise_id)->exists() ) {
      $latestSort = TrainerTask::where('exercise_id', $exercise_id)->latest('sort')->first()->sort;
    } else {
      $latestSort = 0;
    }

    return view('trainer_task.create', compact('trainer_id', 'category_id', 'exercise_id', 'latestSort'));
  }

  public function createByExercise($trainer_id, $category_id, $exercise_id, $task_id)
  {
    $exercise = Exercise::find($exercise_id);
    $categories = [$exercise->id => $exercise->name];
    return view('trainer_task.create')->with(['categories' => $categories]);
  }

  public function updateByExercise($trainer_id, $category_id, $exercise_id, $task_id)
  {
    $categories = Exercise::all()->keyBy('id')->map(function ($item) { return $item->name; });
    $trainerTask = TrainerTask::find($task_id);

    return view('trainer_task.edit')->with(['task' => $trainerTask, 'categories' => $categories]);
  }

  public function goToNextTask ($trainer_id, $category_id, $exercise_id, $task_id) 
  {
    $sort = TrainerTask::find($task_id)->sort;
    $nextTask = TrainerTask::where([['sort', '>', $sort], ['exercise_id', '=', $exercise_id]])->orderBy('sort', 'asc')->first();
    $added_data = ['trainer_id' => $trainer_id, 'category_id' => $category_id];

    return array_merge($nextTask->toArray(), $added_data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $trainer_id, $category_id, $exercise_id)
  {
    $data = $request->validate([
      'name' => 'required',
      'count_examples' => '',
      'minimal_number' => '',
      'exercise_id' => 'required',
      'maximal_number' => '',
      'speed' => '',
      'numbers_examples' => '',
      'examples' => '',
      'operation' => '',
      'sort' => 'required'
    ]);

    $this->messages[] = ['code' => 'success', 'text' => 'Пример успешно добавлен'];

    $task = new TrainerTask($data);

    $task->save();

    return redirect("/trainers/$trainer_id/categories/$category_id/exercises/$exercise_id/trainer_task")->with(['messages' => $this->messages]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\TrainerTask $trainerTask
   * @return \Illuminate\Http\Response
   */
  public function show($trainer_id, $category_id, $exercise_id, TrainerTask $trainerTask)
  {
    return view('trainer_task.detail', compact('trainer_id'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\TrainerTask $trainerTask
   * @return \Illuminate\Http\Response
   */
  public function edit($trainer_id, $category_id, $exercise_id, $task_id)
  {

    $task = TrainerTask::find($task_id);
    // $categories = Exercise::all()->keyBy('id')->map(function ($item) {
    //   return $item->name;
    // });

    return view('trainer_task.edit', compact('task', 'trainer_id', 'category_id', 'exercise_id'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \App\TrainerTask $trainerTask
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $trainer_id, $category_id, $exercise_id,  $task_id)
  {
    $task = TrainerTask::find($task_id);
    $data = $request->validate([
      'name' => 'required',
      'count_examples' => '',
      'minimal_number' => '',
      'maximal_number' => '',
      'speed' => '',
      'numbers_examples' => 'string',
      'operations_examples' => '',
      'examples' => 'string',
    ]);

    $this->messages[] = ['code' => 'success', 'text' => 'Пример успешно добавлен'];

    $task->update($data);

    $task->save();

    return redirect("/trainers/$trainer_id/categories/$category_id/exercises/$exercise_id/trainer_task")->with(['messages' => $this->messages]);
  }

  public function updateStats(Request $request) {
    $stats = \App\Stats::where(['user_id' => $request->user()->id, 'trainer_id' => $request->get('trainer_id')])->first();

    $stats->answers_total = $stats->answers_total + 1;

    if( $request->get('isCorrectAnswer') ) {
      $stats->answers_correct = $stats->answers_correct + 1;
    } else {
      $stats->answers_wrong = $stats->answers_wrong + 1;
    }

    $stats->answers_accuracy = strval( round( $stats->answers_correct / $stats->answers_total * 100 ) ) . '%';
    $stats->answers_rating = $stats->user->getRating(round( $stats->answers_correct / $stats->answers_total * 100 ));

    $stats->save();

    return ['isCorrectAnswer' => $request->get('isCorrectAnswer'), 'stats' => $stats];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\TrainerTask $trainerTask
   * @return \Illuminate\Http\Response
   */
  public function destroy($trainer_id, $category_id, $exercise_id, TrainerTask $trainerTask)
  {
    $trainerTask->delete();

    return redirect("/trainers/$trainer_id/categories/$category_id/exercises/$exercise_id/trainer_task");
  }
}
