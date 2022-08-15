<?php

namespace App\Http\Controllers;

use App\Mail\UserConfirmed;
use \App\User;
use \App\Group;
use \App\Student;
use \App\Stats;
use \App\GroupTask;
use \App\StudentTask;
use \App\TrainerTaskCategory;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{

  public function showStats(User $user) {

    return view('user.stats')->with(['student' => $user->student]);
  }

  public function detailPage($id)
  {
    $user = User::find($id);
    $isProfileOwner = auth()->user()->id == $id;
    $isAdmin = auth()->user()->rang === config('rang.admin');
    $isExecutor = $user->rang === config('rang.executor');

    // ученик смотрит свой профиль
    if ($isProfileOwner && $isExecutor) {
      $student = $user->student;
      $inGroup = !is_null($student->group_id);

      return view('user.edit', compact(['user', 'isProfileOwner', 'isExecutor', 'student']))
        ->with(['respondent_id' => $id, 'showStats' => false, 'inGroup' => $inGroup]);

    } elseif($isAdmin) { // админ смотрит чей-то профиль

      if($isExecutor) { // админ смотри профиль ученика
        $student = $user->student;
        $inGroup = !is_null($student->group_id);

        return view('user.edit', compact(['user', 'isProfileOwner', 'isExecutor', 'student']))
          ->with(['respondent_id' => $id, 'showStats' => true, 'inGroup' => $inGroup]);
      }

      return view('user.edit', compact(['user', 'isProfileOwner', 'isExecutor']))
        ->with(['respondent_id' => $id, 'showStats' => false, 'inGroup' => false]);
    }

    if($isExecutor) {
        $student = $user->student;
        $inGroup = !is_null($student->group_id);

        return view('user.detail_page', compact(['user', 'isProfileOwner', 'isExecutor', 'student']))
          ->with(['respondent_id' => $id, 'showStats' => true, 'inGroup' => $inGroup]);

    } elseif ($isProfileOwner) {
        return view('user.edit', compact(['user', 'isProfileOwner', 'isExecutor']))
        ->with(['respondent_id' => $id, 'showStats' => false, 'inGroup' => false]);
    }

    return view('user.detail_page', compact(['user', 'isProfileOwner', 'isExecutor']))
      ->with(['respondent_id' => $id, 'showStats' => false, 'inGroup' => false]);

  }

  public function userProfile()
  {
    return $this->detailPage(auth()->user()->id);
  }

  public function createUserForm()
  {
    return in_array(\Auth::user()->rang, [config('rang.admin'), config('rang.creator')])
      ? view('user.create')
      : view('errors.rang_exception');

  }

  protected function create(Requests\CreateUserRequest $request)
  {
    $user = new User();
    $user->fill($request->all());
    $user->password = bcrypt($request->password);
    $user->rang = empty($request->rang) ? 'F' : $request->rang;
    $user->actual_rang = empty($request->rang) ? 'F' : $request->rang;

    if($user->save()) {
      Stats::create(['user_id' => $user->id, 'trainer_id' => 1]);
      Stats::create(['user_id' => $user->id, 'trainer_id' => 2]);
      Student::create(['user_id' => $user->id]);

      $messages = [['code' => 'success', 'text' => 'Пользователь успешно добавлен']];
      // $mail_message = (new UserConfirmed($user, $request->password));
      // \Mail::to($request->email)->queue($mail_message);
    } else {
      $messages = [['code' => 'error', 'text' => 'Не удалось добавить пользователя']];

    }

    return $this->createUserForm()->with(['messages' => $messages]);
  }

  public function editUser(Requests\EditUserRequest $request)
  {
    $result = false;
    $isNewStudent = false;

    $user = User::firstOrNew(['id' => $request->id]);
    if (!empty($user)) {
      if ($user->rang === config('rang.not_confirmed')) {
        if (!empty($request->rang) && $request->rang != config('rang.not_confirmed')) {
          $isNewStudent = true;
          // $mail_message = (new UserConfirmed($user, null));
          // \Mail::to($request->email)->queue($mail_message);
        }
      }

      if ($request->rang == '' && $user->rang != 'F') {
        $user->actual_rang = $user->rang;
        $user->rang = 'F';
      }
      else {
        $user->rang = $user->actual_rang;
      }

      $user->name = $request->name;
      $user->email = $request->email;
      $user->rang = ($request->rang == 'on') ? $user->rang : 'F';

      if ($request->input('password')) {
        $user->password = bcrypt($request->input('password'));
      }
      $result = $user->save();
    }

    if ($result) {

      $messages[] = ['code' => 'success', 'text' => 'Пользователь успешно измененён'];

      if($isNewStudent) {
        Stats::create(['user_id' => $user->id, 'trainer_id' => 1]);
        Stats::create(['user_id' => $user->id, 'trainer_id' => 2]);
        Student::create(['user_id' => $user->id]);
      }

    } else {
      $messages[] = ['code' => 'danger', 'text' => 'Произошла ошибка'];
    }

    $isExecutor = $user->rang === config('rang.executor');
    $isProfileOwner = auth()->user()->id == $request->id;

    return view('user.edit')->with([
      'messages' => $messages,
      'user' => $user,
      'isProfileOwner' => $isProfileOwner,
      'isExecutor' => $isExecutor,
      'showStats' => $isExecutor ? $isProfileOwner ? false : true : false,
      'inGroup' => $isExecutor && !is_null($user->student->group_id) ? true : false,
      'student' => $isExecutor ? $user->student : false,
    ]);
  }

  public function profileUpdate(Requests\EditUserRequest $request)
  {

    $userId = auth()->user()->id;

    if($request->hasFile('avatar')) {
      $avatar = $request->file('avatar');
      $filename = time() . '.' . strtolower($avatar->getClientOriginalExtension());
      $user = User::find($userId);

      if($user->avatar !== 'default.png') {
        \Storage::disk('avatars')->delete($user->avatar);
      }
      
      \Storage::disk('avatars')->put($filename, file_get_contents($avatar));

      $user->avatar = $filename;

      $user->save();
    }

    $request->request->set('id', $userId);
    return $this->editUser($request);
  }

  public function createTask($executorId)
  {
    $user = User::find($executorId);
    if ($user->rang !== config('rang.executor')) {
      return view('errors.rang_exception');
    } else {
      $taskController = new TaskController;

      return $taskController->createForm()->with(['executorId' => $executorId]);

    }
  }

  public function createGroup()
  {
    return view('group.create');
  }

  public function createGroupParams()
  {
    $themes = TrainerTaskCategory::select('name')->get()->pluck('name');
    $exercises = TrainerTaskCategory::get()->map(function($item, $key) {
      return $item->exercises->pluck('name');
    });

    return [  
      'levels' => $themes->combine($exercises),
      'themes' => $themes->combine($themes),
    ];
  }

  public function storeGroup(Requests\GroupRequest $request) {
      $group = Group::create($request->all());
      $messages[] = [ 'code' => 'success', 'text' => 'Группа успешно добавлена'];

      return redirect()->route('teacher.groups')->with(['messages' => $messages]);
  }

  public function deleteGroup(Group $group) {

    if($group->delete()) {
      return back()->with([
        'messages' => [
          'code' => 'success', 
          'text' => 'Группа успешно удалена',
        ]
      ]);
    }

    return back()->with([
      'messages' => [
        'code' => 'danger', 
        'text' => 'Не удалось удалить группу',
      ]
    ]);
  }

  public function getGroups() {
    $user = auth()->user();
    $groups = $user->groups;
    
    $students = $user->getStudents($groups);

    // return $students;

    return view('user.groups', compact('groups', 'students'));
  }

  public function getStudent(Student $student) {

    $user = auth()->user();
    $groups = $user->groups->where('id', '!==', $student->group->id);

    return view('user.student', compact('student', 'groups'));
  }

  public function addStudent()
  {
    $user = auth()->user();

    if ($user->rang !== config('rang.creator')) {
      return view('errors.rang_exception');
    } else {

      $groups = $user->groups->pluck('name', 'id');
      $students = Student::whereNull('group_id')->with('user')->get()->toArray();

      $data = array_map(function($student) {
        return $student['user'];
      }, $students);

      $users = array_column($data, 'name', 'id');

      return view('user.add_student', compact('groups', 'users'));
    }
  }

  public function storeStudent(Request $request)
  {
    $data = $request->validate([
      'user_id' => 'required',
      'group_id' => 'required',
    ]);

    $user = User::find($data['user_id']);
    $user->student->update(['group_id' => $data['group_id']]);

    return redirect('/teacher/groups')->with([
      'messages' => [
        'code' => 'success',
        'text' => 'Ученик '. $user->name  . ' успешно добавлен в группу',
      ]
    ]); 
  }

  public function updateStudent(Student $student, Request $request)
  {
    $isUpdated = $student->update([
        'group_id' => $request->group_id,
        'note' => $request->note,
        'message' => $request->message
        ]);
    $isUpdated ? ['isUpdated' => true,  'message' => 'Заметка успешно обновлена'] : ['isUpdated' => false, 'message' => 'Не удалось обновить заметку'];
    return redirect('/teacher/students/' . $request->student_id);

  }

  public function updateGroup(Group $group, Request $request) 
  {
    $messages = [
      'success' => [
        'message' => 'Сообщение успешно обновлено',
      ],
      'failure' => [
        'message' => 'Не удалось обновить сообщение',
      ]
    ];

    $field = $request->get('field');

    $isUpdated = $group->update([$field => $request->get($field)]);

    return $isUpdated
      ? ['isUpdated' => true, 'message' => $messages['success'][$field], 'text' => $request->get($field)]
      : ['isUpdated' => false, 'message' => $messages['failure'][$field]];
  }

  public function removeStudent(Student $student, Request $request) 
  {
    $isUpdated = $student->update([
      'group_id' => NULL,
      'theme' => NULL,
      'level' => NULL,
      'note' => 'Заметка об ученике',
      'message' => NULL,
    ]);

    if($isUpdated) {
      return redirect('/teacher/groups')->with([
          'messages' => [
            'code' => 'success',
            'text' => 'Ученик успешно удалён из группы'
          ]
        ]);
    }

    return redirect('/teacher/groups')->with([
      'messages' => [
        'code' => 'danger',
        'text' => 'Не удалось удалить ученика из группы'
      ]
    ]);
  }

  public function createMessageForm($respondent_id)
  {
    return view('user.create_message', compact(['respondent_id']))->with(['user' => User::find($respondent_id)]);
  }

  public function deleteUser($id)
  {
    if (\Auth::user()->isAdmin() && User::find($id)->rang !== 'A') {
      User::find($id)->delete();
      return redirect('/users')->with([
        'messages' => [
          'code' => 'success',
          'text' => 'Пользователь успешно удалён '
        ]
      ]);
    } else {
      return redirect('/users')->with([
        'messages' => [
          'code' => 'danger',
          'text' => 'Пользователя удалить невозможно'
        ]
      ]);
    }
  }

  public function getTasks($group_id) 
  {
    return view('group.tasks', compact(['group_id']));
  }

  public function getTaskStatistics(Group $group, GroupTask $task) 
  {

    $students = $task->students;

    return view('group.task_statistics', compact('students'));
  }

  public function showUserMenu()
  {

    $user = auth()->user();

    if( $user ) {
      if( $user->rang == config('rang.not_confirmed') ) {
        return view('errors.wait_confirm');
      }
  
      $userMenu = User::getUserMenu();
      $isExecutor = $user->rang == config('rang.executor');
      return view('home.menu', compact(['userMenu', 'isExecutor']));
    }


    return redirect()->route('login');
  }

  public function changeStatus(Request $request, $id)
  {
    $answer = array();
    $answer['id'] = $id;
    echo json_encode($answer);
  }
}
