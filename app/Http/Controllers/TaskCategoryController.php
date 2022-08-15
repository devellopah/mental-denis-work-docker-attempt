<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryTaskRequest;
use App\TaskCategory;
use Illuminate\Http\Request;

class TaskCategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskCategories = TaskCategory::all();

        return view('categories.index')->with(['taskCategories' => $taskCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryTaskRequest $request)
    {
        $taskCategory = new TaskCategory();
        $taskCategory->fill($request->all());
        $taskCategory->save();

        return redirect('/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->isAdmin()) {
            $taskCategory = TaskCategory::find($id);

            return view('categories.update')->with(
                [
                    'taskCategory' => $taskCategory,
                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->isAdmin()) {
            $taskCategory = TaskCategory::findOrFail($id);
            $taskCategory->fill($request->all());
            $taskCategory->save();

            return redirect('/categories')->with(
                [
                    'messages' => [
                        [

                            'code' => 'success',
                            'text' => 'Категория изменена успешно',
                        ],
                    ],
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! empty($id) && \Auth::user()->isAdmin()) {
            TaskCategory::destroy($id);
        }

        return redirect('/categories')->with(
            [
                'messages' => [
                    [
                        'code' => 'success',
                        'text' => 'Выбранные категории удалены успешно',
                    ],
                ],
            ]
        );
    }

    public function destroyMany(Request $request)
    {
        if ( ! empty($request->removeCategory) && \Auth::user()->isAdmin()) {
            TaskCategory::destroy($request->removeCategory);
        }

        return redirect('/categories')->with(
            [
                'messages' => [
                    [
                        'code' => 'success',
                        'text' => 'Выбранные категории удалены успешно',
                    ],
                ],
            ]
        );
    }
}
