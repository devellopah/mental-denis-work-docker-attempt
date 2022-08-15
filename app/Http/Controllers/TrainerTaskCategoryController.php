<?php

namespace App\Http\Controllers;

use App\TrainerTaskCategory;
use Illuminate\Http\Request;

class TrainerTaskCategoryController extends Controller
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
  public function index($trainer_id)
  {
    $categories = TrainerTaskCategory::where('trainer_id', $trainer_id)->get();

    return view('trainer_task.list_category')->with(['categories' => $categories, 'trainer_id' => $trainer_id]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($trainer_id)
  {
    return view('trainer_task.create_category')->with(['trainer_id' => $trainer_id]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'trainer_id' => 'required',
    ]);
    $trainer_id = $data['trainer_id'];
    $category = new TrainerTaskCategory($data);
    $category->save();

    return redirect("/trainers/$trainer_id/categories");
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\TrainerTaskCategory $trainerTaskCategory
   * @return \Illuminate\Http\Response
   */
  public function show($trainer_id, TrainerTaskCategory $trainerTaskCategory)
  {
    return view('trainer_task.index')->with(['trainerTaskCategory' => $trainerTaskCategory, 'trainer_id' => $trainer_id]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\TrainerTaskCategory $trainerTaskCategory
   * @return \Illuminate\Http\Response
   */
  public function edit($trainer_id, $category_id)
  {
    $category = TrainerTaskCategory::find($category_id);
    return view('trainer_task.edit_category', compact('category', 'trainer_id'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \App\TrainerTaskCategory $trainerTaskCategory
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $trainer_id, $category_id)
  {
    $trainerTaskCategory = TrainerTaskCategory::find($category_id);
    $data = $request->validate(['name' => 'required']);
    $trainerTaskCategory->update($data);
    $trainerTaskCategory->save();

    return redirect("/trainers/$trainer_id/categories");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\TrainerTaskCategory $trainerTaskCategory
   * @return \Illuminate\Http\Response
   */
  public function destroy($trainer_id, $id)
  {
    // dd($trainerTaskCategory);

    TrainerTaskCategory::destroy($id);

    return redirect("/trainers/$trainer_id/categories");
  }
}
