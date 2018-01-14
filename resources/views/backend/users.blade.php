@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
            <div class="alert alert-danger" role="alert">Удаление</div>
        </h4>
      </div>
      <div class="modal-body" >
        <div class="alert alert-danger" role="alert">
            Удалить пользователя
            <label class="alert-link" id="user_name">...</label> ?
        </div>
        {{-- Удалить пользователя <b id="user_name" class="btn-danger">...</b> ? --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <a href="/dashboard/del_user/id" id="del_user" class="btn btn-danger">Удалить</a>
        {{-- <div class="alert alert-success" id="erralert{{ $subcat->id }}" role="alert" hidden=""></div> --}}
      </div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">Панель управления</div> --}}

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/dashboard/register_user') }}" class="btn btn-primary">Добавить пользователя</a>

                </div>
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>Имя Фамилия</th>
                                <th>Логин</th>
                                <th>Телефон</th>
                                <th>email</th>
                                <th>Добавлен</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->login}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->created_at}}</td>
                                    <td><a href="update_user/{{ $user->id }}" class="btn btn-default btn-sm" type="button">Редактировать</a></td>
                                    <td><button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#myModal" id="{{ $user->id }}deleteRecord" curid="{{ $user->id }}" user_name="{{$user->name}}">Удалить</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('myjs')
    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        user_name = $(this).attr('user_name');
        $('#del_user').attr('href', '/dashboard/del_user/' + id);
        $('#user_name').text( user_name );
      })
      $('#nav_bar_2').addClass('active');
    </script>
@endsection
