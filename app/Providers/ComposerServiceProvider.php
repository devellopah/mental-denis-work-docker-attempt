<?php namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    public function boot()
    {
        View::composer('layouts.app', function($view) {

            $user = auth()->user();

            if(!$user) return $view;

            $rang = $user->rang;
            
            if( $rang == config('rang.admin') ) {
                $navMenu = [
                    [
                        'name' => 'generator',
                        'title' => 'Генератор',
                        'route' => route('generator')
                    ],

                    [
                        'name' => 'users.stats',
                        'title' => 'Статистика',
                        'route' => route('users.stats')
                    ],

                    [
                        'name' => 'trainers.index',
                        'title' => 'Тренажёры',
                        'route' => route('trainers.index')
                    ]
                ];
            }
            elseif ( $rang == config('rang.creator') ) {
                $navMenu = [
                    [
                        'name' => 'generator',
                        'title' => 'Генератор',
                        'route' => route('generator')
                    ],

                    [
                        'name' => 'users.stats',
                        'title' => 'Статистика',
                        'route' => route('users.stats')
                    ],

                    [
                        'name' => 'trainers.index',
                        'title' => 'Тренажёры',
                        'route' => route('trainers.index')
                    ]
                ];
            }
            elseif ( $rang == config('rang.executor') ) {
                $navMenu = [
                    [
                        'name' => 'student.tasks',
                        'title' => 'Задания',
                        'route' => route('student.tasks', ['student_id' => auth()->user()->student->id]),
                    ],

                    [
                        'name' => 'user.stats',
                        'title' => 'Статистика',
                        'route' => route('user.stats', ['user_id' => auth()->user()->id]),
                    ],

                    [
                        'name' => 'trainers.index',
                        'title' => 'Тренажёры',
                        'route' => route('trainers.index')
                    ],
                ];
            } else {

                $navMenu = [];
            }

            return $view->with(['navMenu' => $navMenu]);
        });
    }

    public function register()
    {
        //
    }
}
