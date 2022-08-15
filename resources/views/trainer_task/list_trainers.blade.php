@extends('layouts.app')
@section('content')

    <div class="View">
        <div class="View__head">

            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">
                            Список тренажёров
                        </h2>
                    </div>

                </div>
            </div>

        </div>

        @include('common.messages')

        <div class="View__body">

            <div class="container">
                <div class="row">

                    @foreach($trainers as $trainer)

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="View__card" style="min-height: 325px">
                                <h4 class="View__cardTitle">                            
                                    <span>{{$trainer->name}}</span>
                                </h4>
                                <div class="View__cardActions">
                                    <a class="View__cardReview" href="{{url("/trainers/$trainer->id/categories")}}">
                                        Войти
                                    </a>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection