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
            Удалить инвестора 
            <label class="alert-link" id="investor_name">...</label> ?
        </div>
        {{-- Удалить инвестора <b id="investor_name" class="btn-danger">...</b> ? --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <a href="/dashboard/del_investor/id" id="del_investor" class="btn btn-danger">Удалить</a>
        {{-- <div class="alert alert-success" id="erralert{{ $subcat->id }}" role="alert" hidden=""></div> --}}
      </div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">Панель управления</div> --}}

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <a href="{{ url('/dashboard/register_investor') }}" class="btn btn-primary">Добавить инвестора</a>

                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Яндекс кошелек</th>
                            <th>Телефон</th>
                            <th>email</th>
                            <th>Создан</th>
                            <th>Кло-во инвестиций</th>
                            <th>Сумма инвестиций</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($investors as $investor)
                            <tr>
                                <td>{{$investor->name}}</td>
                                <td>{{$investor->yan_money}}</td>
                                <td>{{$investor->phone}}</td>
                                <td>{{$investor->email}}</td>
                                <td>{{$investor->created_at}}</td>
                                <td><a href="show_invests/{{ $investor->id }}">{{$amount_count[$loop->index]}}</a></td>
                                <td>{{$amount_all[$loop->index]}}</td>
                                <td><a href="update_investor/{{ $investor->id }}" class="btn btn-default" type="button">Редактировать</a></td>
                                <td><button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal" id="{{ $investor->id }}deleteRecord" curid="{{ $investor->id }}" investor_name="{{$investor->name}}">Удалить</button></td>
                            </tr>
                        @endforeach
                    </tbody>   
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('myjs')
    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        investor_name = $(this).attr('investor_name');
        $('#del_investor').attr('href', '/dashboard/del_investor/' + id);
        $('#investor_name').text( investor_name );
      })
    </script>
@endsection
