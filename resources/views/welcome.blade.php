<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Привлечение инвестиций</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
        
    </head>
    <body >
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="flex-center position-ref full-height" style="background: url( {{ asset('storage/email/moneytree.jpg') }} ) no-repeat; background-size: cover;">
                        @if (Route::has('login'))
                            <div class="top-right links">
                                @if (Auth::check())
                                    <a href="{{ url('/home') }}">Админ</a>
                                @else
                                    <a href="{{ url('/login') }}">Войти админу</a>
                                    {{-- <a href="{{ url('/register') }}">Register</a> --}}
                                @endif
                            </div>
                        @endif

                        <div class="content">
                            <div class="title m-b-md">
                                Привлечение инвестиций
                            </div>
                            <div class=" m-b-md">
                                <h2><a href="/private/auth_investor">Хочу инвестировать</a></h2>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </body>
</html>
