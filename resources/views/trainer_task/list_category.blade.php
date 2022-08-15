@extends('layouts.app')
@section('content')

    <div class="View">
        <div class="View__head">

            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">
                            Список категорий
                        </h2>
                    </div>

                    @if(\Auth::user()['rang'] == config('rang.admin'))
                        <div class="col-sm-7 text-sm-right">
                            <div class="View__headActions">
                            <a class="View__createCat" href="{{ route('trainers.categories.create', $trainer_id) }}" class="">Добавить категорию</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>

        @include('common.messages')

        <div class="View__body">

            <div class="container">
                <div class="row">

                    @foreach($categories as $index => $category)

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="View__card" style="min-height: 325px">
                                <h4 class="View__cardTitle">
                                    <span>{{++$index}}</span>
                                    <span style="padding-bottom: 6px;">Уровень</span>
                                    <span>{{$category->name}}</span>
                                </h4>
                                <div class="View__cardActions">

                                    <a class="View__cardReview" href="{{url("/trainers/$trainer_id/categories/$category->id/exercises")}}">
                                        Просмотр
                                    </a>

                                    @if(\Auth::user()['rang'] == config('rang.admin'))
                                        <a class="View__cardEdit"
                                           href="{{url("/trainers/$trainer_id/categories/$category->id/edit")}}">
                                            Редактировать
                                        </a>
                                        <button
                                                data-action="/trainers/{{ $trainer_id }}/categories/{{$category->id}}"
                                                class="View__cardDelete delete-btn-modal-js">
                                            Удалить
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection