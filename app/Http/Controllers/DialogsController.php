<?php

namespace App\Http\Controllers;

use App\Dialog;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class DialogsController extends Controller
{
    public function dialogsList()
    {
        $dialogs = \Auth::user()->dialogsAll();

        return view('dialogs.list', compact(['dialogs']));
    }
}
