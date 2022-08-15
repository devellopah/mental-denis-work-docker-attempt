<?php

namespace App;

use \App\Tasks;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;
  protected $countUnreadedMessages;


  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'rang',
      'actual_rang',
    'avatar',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];


  /**
   * User constructor.
   *
   * @param $countUnreadedMessages
   */
  public function __construct()
  {
    $this->countUnreadedMessages = $this->getUnreadedMessages();
  }


  /**
   * User have many tasks
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function tasks()
  {
    $foreignKey = 'executor_id';
    switch (\Auth::user()['rang']) {

      case  config('rang.executor'):
        $foreignKey = 'executor_id';
        break;
      case  config('rang.creator'):
        $foreignKey = 'creator_id';
        break;
      case 'A':
        $foreignKey = 'creator_id';
        break;
    }


    return $this->hasMany(Tasks::class, $foreignKey);
  }


  public function scopeExecutors($query)
  {
    $query->where('rang', '=', 'E');
  }

  public function scopeCreators($query)
  {
    $query->where('rang', '=', 'C');
  }

  /**
   * user have many dialogs
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function owner()
  {
    return $this->hasMany('\App\Dialog', 'owner_id', 'id')->orderBy('updated_at', 'desc');
  }

  public function respondent()
  {
    return $this->hasMany('\App\Dialog', 'respondent_id', 'id')->orderBy('updated_at', 'desc');
  }

  public function dialogsAll()
  {
    return $this->respondent->merge($this->owner);
  }

  public function canEditTasks()
  {
    switch (\Auth::user()->rang) {
      case config('rang.admin'):
        return true;
        break;
      case config('rang.creator'):
        return true;
        break;
      default:
        return false;
        break;
    }

  }

  public function isAdmin()
  {
    if (\Auth::user()->rang === config('rang.admin')) {
      return true;
    }

    return false;
  }

  public function getUnreadedMessages()
  {
    return $this->hasMany('\App\Message', 'respondent_id', 'id')->where('status', '=', null)->count();
  }

  public function stats() {
    return $this->hasMany(Stats::class);
  }

  public function getRating($num) {
      if ($num > 80) return 5;
      if ($num > 60) return 4;
      if ($num > 40) return 3;
      if ($num > 20) return 2;
      if ($num > 0) return 1;     
      
      return 0;
  }

  public function getAllStats() {
    $numbers_answers_total = $this->stats->first()->answers_total;
    $rombs_answers_total = $this->stats->last()->answers_total;

    $numbers_points = $this->stats->first()->points;
    $rombs_points = $this->stats->last()->points;

    $answers_accuracy = null;

    if($numbers_answers_total > 0 && $rombs_answers_total > 0) {
      $answers_accuracy = round( ( intval($this->stats->first()->answers_accuracy) + intval($this->stats->last()->answers_accuracy) ) / 2 ) . '%';
    }

    else {

      if($numbers_answers_total === 0) {
        $answers_accuracy = $this->stats->last()->answers_accuracy;
      }
  
      if($rombs_answers_total === 0) {
        $answers_accuracy = $this->stats->first()->answers_accuracy;
      }
    }

    $all = collect([
      'answers_total' => $numbers_answers_total +  $rombs_answers_total,
      'answers_correct' => $this->stats->first()->answers_correct +  $this->stats->last()->answers_correct,
      'answers_wrong' => $this->stats->first()->answers_wrong +  $this->stats->last()->answers_wrong,
      'answers_accuracy' => $answers_accuracy,
      'points' => $numbers_points + $rombs_points
    ]);

    return $all;
  }

  public function student() {
    return $this->hasOne(Student::class);
  }

  public function groups() {
    return $this->hasMany(Group::class);
  }

  public function getStudents($groups) {
    $students = collect();

    if ($groups->count()) {
      $students = $groups->reduce(function($carry, $item) {
        return $carry->merge($item->students);
      }, collect());
    }

    return $students;
  }

  static function getUserMenu()
  {
    $user = auth()->user();

    $rang = $user->rang;

    $userMenu = [
        [
            'name' => 'user.profile',
            'title' => 'Профиль',
            'class' => 'icon-idea',
            'route' => route('user.profile'),
        ],
        [
            'name' => 'generator',
            'title' => 'Генератор',
            'class' => 'icon-idea',
            'route' => route('generator')
        ],
        [
            'name' => 'users.stats',
            'title' => 'Статистика',
            'class' => 'icon-barchart',
            'route' => route('users.stats'),
        ],
        [
            'name' => 'trainers.categories.index',
            'title' => 'Ментальный счёт',
            'class' => 'icon-remember',
            'route' => route('trainers.categories.index', ['trainer_id' => 1]),
        ],
        [
            'name' => 'trainers.categories.index',
            'title' => 'Флеш-карты',
            'class' => 'icon-success',
            'route' => route('trainers.categories.index', ['trainer_id' => 2]),
        ],
           [
              'name' => 'tariffs',
              'title' => 'Платежи и тарифы',
              'class' => 'icon-idea',
              'route' => route('tariffs'),
          ]
    ];
    if( $rang == config('rang.admin') ) {
      array_splice($userMenu, 1, 0, [
        [
            'name' => 'users.list',
            'title' => 'Пользователи',
            'class' => 'icon-idea',
            'route' => route('users.list'),
        ],
      ]);
    }
    elseif ( $rang == config('rang.creator') ) {
      array_splice($userMenu, 1, 0, [
        [
            'name' => 'users.list',
            'title' => 'Пользователи',
            'class' => 'icon-idea',
            'route' => route('users.list'),
        ],
        [
          'name' => 'teacher.groups',
          'title' => 'Мои группы',
            'class' => 'icon-idea',
          'route' => route('teacher.groups'),
        ]
      ]);
    }
    elseif ( $rang == config('rang.executor') ) {
      array_splice($userMenu, 1, 0, [
        [
          'name' => 'student.show',
          'title' => 'Мои сообщения',
            'class' => 'icon-idea',
          'route' => route('student.show', ['student_id' => auth()->user()->student->id]),
        ],
        [
          'name' => 'student.tasks',
          'title' => 'Мои задания',
            'class' => 'icon-idea',
          'route' => route('student.tasks', ['student_id' => auth()->user()->student->id]),
        ]
      ]);
    }

    return $userMenu;
  }
}
