@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul class="nav nav-pills">
                        <li role="presentation" id="nav_bar_1"><a href="{{ url('/') }}">Главная страница</a></li>
                        <li role="presentation" id="nav_bar_2"><a href="{{route('dash_users')}}">Пользователи админпанели</a></li>
                        <li role="presentation" id="nav_bar_3"><a href="{{ route('dash_investors') }}">Инвесторы</a></li>
                        <li role="presentation" id="nav_bar_4"><a href="{{route('dash_invates')}}">Рассылка приглашений</a></li>
                        <li role="presentation" id="nav_bar_5"><a href="{{ route('dash_parametrs') }}">Настройка параметров</a></li> 
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection