@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Параметры Qiwi</div>

                <div class="panel-body">

                    <div class="alert alert-info" role="alert">
                        <div class="table-responsive">
                            В <a link="https://money.yandex.ru/myservices/online.xml">https://money.yandex.ru/myservices/online.xml</a><br>
                            вставить http://{ваш хост}/conf_trans
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('dash_store_param') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('qiwi_wallet') ? ' has-error' : '' }}">
                            <label for="qiwi_wallet" class="col-md-4 control-label">Qiwi кошелек для получения инвестиций</label>

                            <div class="col-md-6">
                                <input id="qiwi_wallet" type="text" class="form-control" name="qiwi_wallet" value="{{ $qiwi_wallet }}" required autofocus>

                                @if ($errors->has('qiwi_wallet'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qiwi_wallet') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('qiwi_token') ? ' has-error' : '' }}">
                            <label for="qiwi_token" class="col-md-4 control-label">Qiwi токен</label>

                            <div class="col-md-6">
                                <input id="qiwi_token" type="text" class="form-control" name="qiwi_token" value="{{ $qiwi_token }}" required autofocus>

                                @if ($errors->has('qiwi_token'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qiwi_token') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('qiwi_token_exp') ? ' has-error' : '' }}">
                            <label for="qiwi_token_exp" class="col-md-4 control-label">Конечный срок токена</label>

                            <div class="col-md-6">
                                <input id="qiwi_token_exp" type="date" class="form-control" name="qiwi_token_exp" value="{{ $qiwi_token_exp }}" min="{{$date_now}}" required autofocus>

                                @if ($errors->has('qiwi_token_exp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qiwi_token_exp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Обновить Qiwi
                                </button>
                                <a href="/home" type="submit" class="btn btn-default">
                                    Отмена
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

@section('myjs')
    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        investor_name = $(this).attr('investor_name');
        $('#del_investor').attr('href', '/dashboard/del_investor/' + id);
        $('#investor_name').text( investor_name );
      })
      $('#nav_bar_5').addClass('active');
    </script>
@endsection
