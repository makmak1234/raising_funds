<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Raising_Funds</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        
    </head>
    <body>
        <div class="flex-center position-ref full-height">
                <div class="top-center links">
                    <div class="content">
                        <div class="center-block m-b-md">
                            <h1 class="text-center">Raising_Funds</h1>
                        </div>
                        <div class="center-block m-b-md">
                            <h2 class="text-center">Привлечение инвестиций</h2>
                        </div>
                        
                    </div>
                </div>
        </div>
    
        <div class="container">
          <div class="row ">
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <h3 class="form-signin-heading text-center">Авторизация</h3>
                <div class="panel panel-default">
                    <form class="form-signin" action="/private/check_investor" method="post">
                      {{ csrf_field() }}
                      @if(isset($message))
                        <div class="alert alert-danger">
                         {{ $message }}
                        </div>
                      @endif
                      <input type="text" name="phone" class="form-control input-block-level" placeholder="Телефон">
                      <input type="password" name="password" class="form-control input-block-level " placeholder="Пароль">
                      <br>
                      <div class="text-center">
                        <button class="btn btn-large btn-primary" type="submit" name="auth">Войти</button>
                        <a href="/private/register_investor" class="btn btn-large btn-default" type="button" name="auth">Зарегистрироваться</a>
                      </div>
                    </form>
                </div>
              </div>
              <div class="col-md-4"></div>
          </div>
        </div>
        
    </body>
</html>