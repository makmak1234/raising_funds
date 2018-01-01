@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
            <div class="alert alert-default" role="alert">Рассылка приглашений инвесторам</div>
        </h4>
      </div>
      <div class="modal-body" >
        <div class="alert alert-danger" id="invates_class" role="alert"> 
            <label class="alert-link" id="invates_text">...</label> ?
        </div>
        {{-- Удалить инвестора <b id="investor_name" class="btn-danger">...</b> ? --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <button onclick="document.send_invates.submit();" id="invates_send" class="btn btn-danger">Разослать</button>
        {{-- <div class="alert alert-success" id="erralert{{ $subcat->id }}" role="alert" hidden=""></div> --}}
      </div>
    </div>
  </div>
</div>

@if (isset($message) && $message != null)
  <script type="text/javascript">
    message = "{{$message}}" + " отправлены";//" будут отправлены в течении нескольких минут"
    alert(message);
  </script>
@endif
{{-- {{isset($message) ? var_dump($message) : '' }} --}}
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="list-group-item list-group-item-success">
                        <h3 class="panel-title ">Рассылка приглашений инвесторам</h3>
                    </div>
                {{-- <div class="panel-title">Рассылка приглашений инвесторам</div> --}}
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" name="send_invates" action="{{ route('dash_send_invates') }}">
                        {{ csrf_field() }}

                        <span class="help-block">
                          $name - имя инвестра
                        </span>
                        <div class="form-group{{ $errors->has('text_email') ? ' has-error' : '' }}">
                            <label for="text_email" class="col-md-2 control-label">
                              Текст email
                              <a class="btn btn-default" role="button" id="email_view">View email</a>
                            </label>
                            <div class="col-md-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <span class="help-block">
                                    Отправить
                                  </span>
                                  <input type="checkbox" {{ isset($send_email) && $send_email == 'on' ? "checked='checked'" : ""}} name="send_email" id="send_email" aria-label="...">
                                </span>
                                <textarea id="text_email" class="form-control" name="text_email" value="
                                  " rows="3" required autofocus>{{ isset($text_email) ? $text_email : old('text_email') }}</textarea>
                              </div><!-- /input-group -->                               
                                @if ($errors->has('text_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('text_sms') ? ' has-error' : '' }}">
                            <label for="text_sms" class="col-md-2 control-label">Текст sms</label>

                            <div class="col-md-10">
                                <div class="input-group">
                                <span class="input-group-addon">
                                  <span class="help-block">
                                    Отправить
                                  </span>
                                  <input type="checkbox" {{ isset($send_sms) && $send_sms == 'on' ? "checked='checked'" : ""}} name="send_sms" id="send_sms" aria-label="...">
                                </span>
                                <textarea id="text_sms" class="form-control" name="text_sms" value="" rows="3" required autofocus>{{ isset($text_sms) ? $text_sms : old('text_sms') }}</textarea>
                              </div><!-- /input-group -->
                                @if ($errors->has('text_sms'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text_sms') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="send_invates">
                                    Разослать инвесторам
                                </button>
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
      $('#send_invates').on('click', function () {
        send_email = $('#send_email').prop("checked");
        // alert(send_email);
        send_sms = $('#send_sms').prop("checked");
        invates_class = $('#invates_class');
        invates_text = $('#invates_text');

        text = "Разослать";
        t_class = "alert alert-success";
        $('#invates_send').removeClass('disabled');
        // $('#invates_send').removeAttr('disabled');
        if(send_email){
          text += "  EMAIL ";
        }
        if(send_sms){
          text += "  SMS ";
        }
        if(!send_sms && !send_email){
          text = "Нечего отсылать"
          t_class = "alert alert-danger";
          $('#invates_send').addClass('disabled');
          // $('#invates_send').attr('disabled', 'disabled');
        }
        invates_text.text( text );
        // investor_name = $(this).attr('investor_name');
        invates_class.attr('class', t_class);
        // $('#invates_send').onclick().submit();
        
      });
      $('#email_view').on('click', function () {
        text_email = $('#text_email').val();
        var url = "/dashboard/invates/view/email/" + text_email;
        $(location).attr('href',url);
      });
      function message(message){
        alert(message + " будут отправлены в течении нескольких минут");
      }
      $('#nav_bar_4').addClass('active');
    </script>
@endsection




