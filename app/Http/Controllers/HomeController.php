<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Student;


class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('home.menu');
  }

  public function generator() 
  {
    return view('home.generator');
  }
}
