<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller
{

  public function __construct()
  {
      $this->middleware('adult');
  }

  public function showList()
  {
    $users = User::orderBy('name', 'asc')->with(['stats'])->get();
    return view('users.list')->with(
      [
        'users' => $users,
      ]
    );
  }

  public function showStats() {
    $users = User::where('rang', 'E')->with(['student'])->get();

    return view('users.stats', compact('users'));
  }

  public function updateList(Request $request)
  {

    foreach ($request->changeRang as $key => $val) {
      $user = \App\User::find($key);
      if (trim($val) == 'noactive') {
        $user->rang = 'F';
      }
      else {
        $user->rang = $user->actual_rang;
      }
      $user->save();
    }

    if(is_null( $request->removeUser) ) return $this->showList();

    $users = \App\User::find($request->removeUser);

    if ($users != null) {
      $users->each(function ($user) {
        if ($user->rang !== 'A') {
          $user->delete();
        }
      });


      return $this->showList()->with(
        [
          'messages' => [
            [

              'code' => 'info',
              'text' => 'Изменения внесены',
            ],
          ],
        ]
      );
    }
  }
}
