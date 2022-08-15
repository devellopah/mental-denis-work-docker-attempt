<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\TrainerTaskCategory;
use Illuminate\Http\Request;
use function returnArgument;
use function view;

class ExerciseController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($trainer_id, $category_id)
    {
        $exercises = Exercise::where('category_id', $category_id)->get();

        return view('exercise.index', compact('exercises', 'trainer_id', 'category_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($trainer_id, $category_id)
    {
        // $categories = TrainerTaskCategory::all()->keyBy('id')->map(function ($item) {
        //     return $item->name;
        // });


        // return view('exercise.create')->with([
        //     'categories' => $categories,
        // ]);

        return view('exercise.create', compact('trainer_id', 'category_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $trainer_id, $category_id)
    {
        $exercise = new Exercise();
        $data = $request->validate($exercise->rules);
        $exercise->fill($data);
        $exercise->save();

        return redirect("/trainers/$trainer_id/categories/$category_id/exercises");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($trainer_id, $category_id, $exercise_id)
    {
        $exercise = Exercise::with(['tasks'])->find($exercise_id);
        return view('exercise.show')->with(['exercise' => $exercise]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($trainer_id, $category_id, $exercise_id)
    {
        // $categories = TrainerTaskCategory::all()->keyBy('id')->map(function ($item) {
        //     return $item->name;
        // });
        $exercise = Exercise::find($exercise_id);

        // return view('exercise.edit')->with([
        //     'categories' => $categories,
        //     'exercise' => $exercise,
        // ]);

        return view('exercise.edit', compact('exercise', 'trainer_id', 'category_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $trainer_id, $category_id, $exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        // $data = $request->validate($exercise->rules);
        $data = $request->validate(['name' => 'required']);
        $exercise->update($data);

        return redirect("/trainers/$trainer_id/categories/$category_id/exercises");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($trainer_id, $category_id, $exercise_id)
    {
        Exercise::destroy($exercise_id);

        return redirect("/trainers/$trainer_id/categories/$category_id/exercises");
    }
}
