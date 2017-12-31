<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Привлечение инвестиций</title>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/emailAdmin.css') }}" rel="stylesheet"> --}}
</head>
<body>
    <center style="background-image: url({{ asset('storage/email/fone.jpg') }}); background-repeat: no-repeat; background-size: 400px auto; background-attachment: scroll; width: 400px; height: 800px;">
    	<div><h3>{{ $name }} <b>  </b><h3/><div>
        
        <a href="{{$path_redirect}}" target="_blank">Хочу инвестировать</a>
    </center>
{{-- <div><h3> Номер заказа: {{ $order }} <b><font color='red'>  </font></b></h3><div>
<div> Телефон:  <b> {{ $tel }} </b><div>
<div>  email:  <b> {{ $email }} </b> <div>
<div>  Город:  <b> {{ $city }} </b> <div></br>
<div><h3><b><font color='red'><i> Товар: </i></font></b></h3><div> --}}

   {{--  @foreach ($pricegoods as $pricegood)
        <div><font color='green'> {{ $loop->iteration }}) <b> {{ $title[$loop->index] }}, {{ $sizeTitle[$loop->index] }}, {{ $colorTitle[$loop->index] }}</font></b></div>
        <div> <b>  {{ $nid[$loop->index] }} шт * {{ $priceone[$loop->index] }} руб = {{ $pricegood }} руб</b> </div>
    @endforeach --}}

{{-- <div><h3><b><i> Всего к оплате: </i><font color='red'> {{ $priceall }}</font> </b> руб </h3></div>

<div>Коментарий: {{ $comment }}</div> --}}

</body>
</html>