<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('tasks/generate', 'API\TasksController@generate');
Route::post('tasks/remove_task', 'API\TasksController@removeTask');

Route::post('tasks/group_task/details', 'API\TasksController@getGroupTaskDetails');

Route::post('tasks/results', 'API\TasksController@handleTaskResult');

Route::post('tasks/', 'API\TasksController@getGroupTasks');

Route::post('payment/', 'API\TasksController@getGroupTasks');


// Route::apiResource('tasks', 'API\TasksController');
