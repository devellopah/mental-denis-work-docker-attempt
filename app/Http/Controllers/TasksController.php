<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasks;
use App\User;
use App\Http\Requests;


class TasksController extends Controller
{
  public function showList()
  {
    $tasks = \Auth::user()->tasks()->orderBy('updated_at', 'desc')->paginate(10);
    return view('tasks.list', compact('tasks'));
  }
}
