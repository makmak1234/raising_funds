@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="list-group-item list-group-item-success">
                        <h3 class="panel-title ">Редактировать инвестицию для инвестора {{$investor->name}}</h3>
                    </div>
                    {{-- <div class="panel-body">
                        <p>...</p>
                    </div> --}}
                    <div class="panel-body bg-info">
                        <div class="table-responsive">
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
                    </div>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('dash_store_invest') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="id_investor" value="{{ $investor->id }}">

                        <input type="hidden" name="id" value="{{ $invest->id }}">

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Сумма инвестиции, руб</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{$invest->amount}}" required autofocus>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="col-md-4 control-label">Срок</label>

                            <div class="col-md-6">
                                <input id="term" type="date" class="form-control" name="term" value="{{$invest->term}}" min="{{$date_now}}" required autofocus>

                                @if ($errors->has('term'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('term') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Решение</label>

                            <div class="col-md-6">
                                @php
                                    $inf_cls0 = "";
                                    $inf_cls1 = "";
                                    $inf_cls2 = "";
                                    // $myecho = old('accept');
                                    // `echo "old('accept'): " . $myecho >>/tmp/qaz`; 
                                    if ($invest->accept == '0'){
                                        $inf_cls0 = "selected";
                                    }elseif($invest->accept == '1'){
                                        $inf_cls1 = "selected";
                                    }elseif($invest->accept == '2'){
                                        $inf_cls2 = "selected";
                                    }
                                @endphp
                                <!-- Single button -->
                                <div class="btn-group">
                                  {{-- <button type="button" class="btn {{$inf_cls}} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="{{ old('accept') }}">
                                    {{$accept[1]}} <span class="caret"></span>
                                  </button> --}}
                                    <select class="form-control" name="accept">
                                        <option class="bg-success" {{$inf_cls1}} value="1">{{$accept[1]}}</option>
                                        <option class="bg-danger" {{$inf_cls0}} value="0">{{$accept[0]}}</option>
                                        <option class="bg-default" {{$inf_cls2}} value="2">{{$accept[2]}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Сохранить
                                </button>
                                <a href="{{ route('dash_show_invests', [$investor->id]) }}" type="button" class="btn btn-default">
                                    Отменить
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
