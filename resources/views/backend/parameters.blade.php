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
                        <li role="presentation" id="nav_bar_1"><a href="{{route('dash_param_yan')}}" disabled>Параметры Яндекс</a></li>
                        <li role="presentation" id="nav_bar_2"><a href="{{route('dash_param_qiwi')}}">Параметры Qiwi</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
