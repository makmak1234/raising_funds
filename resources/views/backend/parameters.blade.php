@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Параметры</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('dash_store_param') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('yan_money') ? ' has-error' : '' }}">
                            <label for="yan_money" class="col-md-4 control-label">Яндекс кошелек для получения инвестиций</label>

                            <div class="col-md-6">
                                <input id="yan_money" type="text" class="form-control" name="yan_money" value="{{ $yan_money }}" required autofocus>

                                @if ($errors->has('yan_money'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('yan_money') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('yan_secret') ? ' has-error' : '' }}">
                            <label for="yan_secret" class="col-md-4 control-label">Яндекс секрет</label>

                            <div class="col-md-6">
                                <input id="yan_secret" type="text" class="form-control" name="yan_secret" value="{{ $yan_secret }}" required autofocus>

                                @if ($errors->has('yan_secret'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('yan_secret') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Обновить
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

{{-- @section('myjs')
    <script type="text/javascript">
      $('#password').attr('value', "false1");
      // $('#password').attr('value', "");

      $(function(){
          //2. Получить элемент, к которому необходимо добавить маску
          $("#phone").mask("7(999) 999-9999");
        });
    </script>
@endsection --}}
