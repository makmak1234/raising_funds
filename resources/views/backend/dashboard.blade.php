@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">Панель управления</div> --}}

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{route('dash_users')}}" class="btn btn-primary">Пользователи админпанели</a>

                    <a href="{{ route('dash_investors') }}" class="btn btn-primary" role="button">Редактировать инвесторов</a> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection