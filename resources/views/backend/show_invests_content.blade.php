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
            Удалить инвестицию 
            <label class="alert-link" id="invest_amount">...</label> руб.?
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <a href="/dashboard/del_invest/id" id="del_invest" class="btn btn-danger">Удалить</a>
        {{-- <div class="alert alert-success" id="erralert{{ $subcat->id }}" role="alert" hidden=""></div> --}}
      </div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            {{-- <div class="panel panel-default"> --}}
                {{-- <div class="panel-heading">Панель управления</div> --}}

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>

                <a href="{{ url("/dashboard/add_invest/$investor->id") }}" class="btn btn-primary">Добавить инвестицию</a>
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="list-group-item list-group-item-success">
                        <h3 class="panel-title ">Данные инвестора {{$investor->name}}</h3>
                    </div>
                    {{-- <div class="panel-body">
                        <p>...</p>
                    </div> --}}
                    <div class="panel-body bg-info">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Яндекс кошелек</th>
                                    <th>Телефон</th>
                                    <th>email</th>
                                    <th>Добавлен</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$investor->name}}</td>
                                    <td>{{$investor->yan_money}}</td>
                                    <td>{{$investor->phone}}</td>
                                    <td>{{$investor->email}}</td>
                                    <td>{{$investor->created_at}}</td>
                                </tr>
                            </tbody>   
                        </table>
                    </div>

                    <!-- Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Сумма инвестиции, руб</th>
                                <th>Срок</th>
                                <th>Дата внесения инвестиции</th>
                                <th>Применить</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invests as $invest)
                                <tr>
                                    <td>{{$invest->amount}}</td>
                                    <td>{{$invest->term}}</td>
                                    <td>{{$invest->created_at}}</td>
                                    <td>
                                        @php
                                            $a_href0 = "href=/dashboard/update_solve/$invest->id/0";
                                            $a_href1 = "href=/dashboard/update_solve/$invest->id/1";
                                            $a_href2 = "href=/dashboard/update_solve/$invest->id/2";
                                            if ($invest->accept == 0){
                                                $inf_cls = "btn-danger";
                                                $a_href0 = "";
                                            }elseif($invest->accept == 1){
                                                $inf_cls = "btn-success";
                                                $a_href1 = "";
                                            }elseif($invest->accept == 2){
                                                $inf_cls = "btn-default";
                                                $a_href2 = "";
                                            }
                                        @endphp
                                        <!-- Single button -->
                                        <div class="btn-group">
                                          <button type="button" class="btn {{$inf_cls}} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{$accept[$invest->accept]}} <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu">
                                            <li><a {{$a_href1}} class="bg-success">{{$accept[1]}}</a></li>
                                            <li><a {{$a_href0}} class="bg-danger">{{$accept[0]}}</a></li>
                                            <li><a {{$a_href2}} class="bg-default">{{$accept[2]}}</a></li>
                                          </ul>
                                        </div>
                                    </td>
                                    <td><a href="/dashboard/update_invest/{{ $invest->id }}" class="btn btn-default" type="button">Редактировать</a></td>
                                    <td><button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal" id="{{ $invest->id }}deleteRecord" curid="{{ $invest->id }}" invest_amount="{{$invest->amount}}">Удалить</button></td>
                                </tr>
                            @endforeach
                        </tbody>   
                    </table>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>
@endsection

@section('myjs')
    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        invest_amount = $(this).attr('invest_amount');
        $('#del_invest').attr('href', '/dashboard/del_invest/' + id);
        $('#invest_amount').text( invest_amount );
      })
    </script>
@endsection


