<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Auth::routes();
Route::get('/', 'UserController@showUserMenu');

Route::group(['middleware' => ['auth', 'user_confirmed']], function () {
  
    Route::get('/generator', 'HomeController@generator')->name('generator');

    /* trainer */
    Route::resource('trainers', 'TrainerController');

    /* trainer categories */
    Route::resource('trainers.categories', 'TrainerTaskCategoryController');

    /* trainer exercises */
    Route::resource('trainers.categories.exercises', 'ExerciseController');

    /* trainer tasks */
    Route::get('trainers/{trainer_id}/categories/{category_id}/exercises/{exercise_id}/update/{task_id}', 'TrainerTaskController@updateByExercise');
    Route::get('trainers/{trainer_id}/categories/{category_id}/exercises/{exercise_id}/create', 'TrainerTaskController@createByExercise');
    Route::get('trainers/{trainer_id}/categories/{category_id}/exercises/{exercise_id}/trainer_task/{task_id}/next', 'TrainerTaskController@goToNextTask');
    Route::get('trainers/{trainer_id}/categories/{category_id}/exercises/{exercise_id}/trainer_task/{task_id}/details', 'TrainerTaskController@getDetails');
    Route::post('trainers/{trainer_id}/categories/{category_id}/exercises/{exercise_id}/trainer_task/{task_id}/stats', 'TrainerTaskController@updateStats');

    Route::resource('trainers.categories.exercises.trainer_task', 'TrainerTaskController');

    /* task pages */
    Route::post('/task/{id}/complete', 'TaskController@setCompleteStatus');
    Route::post('/task/{id}/close', 'TaskController@setCloseStatus');
    Route::post('/task/{id}/start', 'TaskController@setStartStatus');
    Route::get('/task/create', 'TaskController@createForm');
    Route::get('/task/{id}', 'TaskController@detailPage');
    Route::post('/task/create', 'TaskController@storeTask');
    Route::post('/task/{id}/create_comment', 'TaskController@createComment');
    Route::post('/task/{id}/edit', 'TaskController@updateTask');
    Route::post('/task/{id}/delete', 'TaskController@delete');
    Route::get('/task/{id}/edit', 'TaskController@updateForm');

    /* user pages */

    Route::get('/user/create', 'UserController@createUserForm');
    Route::post('/user/create', 'UserController@create');
    Route::post('/user/profile', 'UserController@profileUpdate');
    Route::get('/user/{id}/delete', 'UserController@deleteUser');
    Route::get('/user/profile', 'UserController@userProfile')->name('user.profile');
    Route::post('/user/{id}', 'UserController@editUser');
    Route::get('/user/{id}', 'UserController@detailPage');
    Route::get('/user/{id}/create_task', 'UserController@createTask');
    Route::post('/user/{id}/create_task', 'TaskController@storeTask');
    Route::get('/user/{user}/stats', 'UserController@showStats')->name('user.stats');

    Route::post('/user/{id}/change_status', 'UserController@changeStatus')->name('user.change_status');

    Route::get('/student/{student}', 'UserController@studentShow')->name('student.show');
    Route::get('student/{student}/tasks', 'StudentController@showTasks')->name('student.tasks');
    Route::get('student/{student}/tasks/student_task/{task}', 'StudentController@playStudentTask')->name('student.tasks.student_task');
    Route::get('student/{student}/tasks/group_task/{task}', 'StudentController@playGroupTask')->name('student.tasks.group_task');

    Route::resource('student', 'StudentController');

    Route::group(['middleware' => ['creator']], function () {

      Route::get('/teacher/groups', 'UserController@getGroups')->name('teacher.groups');
      Route::get('/teacher/create_group', 'UserController@createGroup')->name('teacher.create_group');
      Route::get('/teacher/create_group_params', 'UserController@createGroupParams')->name('teacher.create_group_params');

      Route::post('/teacher/create_group', 'UserController@storeGroup')->name('teacher.store_group');
      Route::get('/teacher/add_student', 'UserController@addStudent')->name('teacher.add_student');
      Route::post('/teacher/add_student', 'UserController@storeStudent')->name('teacher.store_student');
      Route::get('/teacher/students/{student}', 'UserController@getStudent')->name('teacher.student');
      Route::post('/teacher/students/{student}/update', 'UserController@updateStudent')->name('teacher.update_student');
      Route::post('/teacher/students/{student}/remove', 'UserController@removeStudent')->name('teacher.remove_student');
      Route::post('/teacher/groups/{group}/update', 'UserController@updateGroup')->name('teacher.update_group');
      Route::post('/teacher/groups/{group}/delete', 'UserController@deleteGroup')->name('teacher.delete_group');

      Route::get('/teacher/groups/{group_id}/tasks', 'UserController@getTasks')->name('group.tasks');
      Route::get('/teacher/groups/{group}/tasks/group_task/{task}', 'UserController@getTaskStatistics')->name('group.task.statistics');
    });

    /* groups */

    // Route::resource('groups', 'GroupController');


    /* tasks lists */

    Route::get('/tasks', 'TasksController@showList');

    /* users list */
    Route::post('/users', 'UsersController@updateList')->name('users.list.update');
    Route::get('/users', 'UsersController@showList')->name('users.list');
    Route::get('/users/stats', 'UsersController@showStats')->name('users.stats');


    /* payment */
    Route::get('/payment', 'PaymentController@index');
    Route::get('/payment/tariffs', 'PaymentController@tariffsList')->name('tariffs');
    Route::get('/payment/tariffs/new', 'PaymentController@tariffNew');
    Route::post('/payment/tariffs/add', 'PaymentController@tariffAdd');
    Route::post('/payment/tariffs/{id}', 'PaymentController@tariffUpdate');
    Route::get('/payment/tariffs/{id}', 'PaymentController@tariffDetail');
    Route::get('/payment/tariffs/{id}/delete', 'PaymentController@tariffDelete');
    Route::get('/payment/{id}/process', 'PaymentController@paymentProcess');
    Route::get('/payment/check', 'PaymentController@paymentCheck');

    Route::get('/payment/success', 'PaymentController@paymentSuccess');
    Route::get('/payment/fail', 'PaymentController@paymentFail');
    Route::get('/payment/stat', 'PaymentController@paymentStatisctic');
    Route::get('/payment/transaction/{id}/delete', 'PaymentController@transactionDelete');

    /* messages */

    Route::get('/dialogs', 'DialogsController@dialogsList');
    Route::get('/dialog/{id}', 'DialogController@detail');
    Route::get('/message/send', 'DialogController@send');

    /* task categories */

    Route::post('categories/deleteMany', 'TaskCategoryController@destroyMany')->name('categories.destroyMany');
    Route::resource('categories', 'TaskCategoryController');
  });

Route::post('/payment/notice', 'PaymentController@paymentCheck');