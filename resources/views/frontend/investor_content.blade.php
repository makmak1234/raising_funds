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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{-- <div class="panel panel-default"> --}}
                {{-- <div class="panel-heading">Панель управления</div> --}}

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>

                <a href="{{ url("/private/add_invest/$investor->id") }}" class="btn btn-primary">Добавить инвестицию</a>
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="list-group-item list-group-item-success">
                        <h3 class="panel-title ">Данные инвестора {{$investor->name}}</h3>
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

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Сумма инвестиции, руб</th>
                                    <th>Срок</th>
                                    <th>Дата внесения инвестиции</th>
                                    <th>Решение</th>
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
                                                // $a_href0 = "href=/dashboard/update_solve/$invest->id/0";
                                                // $a_href1 = "href=/dashboard/update_solve/$invest->id/1";
                                                // $a_href2 = "href=/dashboard/update_solve/$invest->id/2";
                                                if ($invest->accept == 0){
                                                    $inf_cls = "alert-danger";
                                                    // $a_href0 = "";
                                                }elseif($invest->accept == 1){
                                                    $inf_cls = "alert-success";
                                                    // $a_href1 = "";
                                                }elseif($invest->accept == 2){
                                                    $inf_cls = "alert-default";
                                                    // $a_href2 = "";
                                                }
                                            @endphp
                                            <!-- Single button -->
                                            <div class="alert {{$inf_cls}}" role="alert">{{$accept[$invest->accept]}}</div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>   
                        </table>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>

    <form method="POST" hidden="true" target="_blank" id="{{$id_form}}" action="https://money.yandex.ru/quickpay/confirm.xml">
        <input type="hidden" name="receiver" value="410013775631887">
        <input type="hidden" name="formcomment" value="Инвестиции для Миллитарихолдинг">
        <input type="hidden" name="short-dest" value="Инвестиции для Миллитарихолдинг">
        <input type="hidden" name="label" value="$order_id">
        <input type="hidden" name="quickpay-form" value="donate">
        <input type="hidden" name="targets" value="транзакция {order_id}">
        <input type="hidden" name="sum" value="48.25" data-type="number">
        <input type="hidden" name="comment" value="Инвестиции для Миллитарихолдинг">
        <input type="hidden" name="need-fio" value="false">
        <input type="hidden" name="need-email" value="false">
        <input type="hidden" name="need-phone" value="false">
        <input type="hidden" name="need-address" value="false">
        <label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label>
        <label><input type="radio" name="paymentType" value="AC">Банковской картой</label>
        <input type="submit" value="Перевести">
    </form>
    <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
        <div class="quickpay-constructor-preview__widget quickpay-constructor-preview__widget_type_shop"><div class="widget-shop i-bem widget-shop_js_inited" data-bem="{&quot;widget-shop&quot;:{}}" data-content-block="this"><div class="data-unit widget-shop__data-unit"><div class="data-unit__label"><label class="label2 label2_size_s">Назначение перевода</label></div><div class="data-unit__base"><span class="label2 label2_size_s widget-shop__targets-seller"></span>
        <label class="label2 label2_size_m">Инвестиции для Миллитарихолдинг</label>
        <input class="native-input native-input_type_hidden" name="targets" value="" type="hidden"></div></div><div class="widget-shop__comment"></div><div class="data-unit widget-shop__data-unit"><div class="data-unit__label"><label class="label2 label2_size_s">Сумма</label></div><div class="data-unit__base"><span class="input input_size_s input_width_sm input_filter_yes input_theme_normal widget-shop__sum-input validation i-bem validation_js_inited input_js_inited" data-bem="{&quot;input&quot;:{&quot;filter&quot;:&quot;float&quot;,&quot;live&quot;:false},&quot;validation&quot;:{&quot;validationRules&quot;:[{&quot;type&quot;:&quot;required&quot;,&quot;errors&quot;:{&quot;empty&quot;:&quot;Пожалуйста, заполните это поле&quot;}},{&quot;type&quot;:&quot;sum&quot;,&quot;errors&quot;:{&quot;wrongFormat&quot;:&quot;Неверный формат суммы&quot;,&quot;tooSmall&quot;:&quot;Это слишком мало (минимум&nbsp;— 2&nbsp;рубля)&quot;,&quot;tooBig&quot;:&quot;Через форму можно отправить максимум 15&nbsp;000&nbsp;рублей&quot;},&quot;params&quot;:{&quot;min&quot;:2,&quot;max&quot;:15000,&quot;maxFractionLength&quot;:2}}]}}"><span class="input__box"><span class="input__clear" unselectable="on">&nbsp;</span><input class="input__control" id="uniq15142854205012" name="sum" aria-labelledby="labeluniq15142854205012 hintuniq15142854205012" value="" maxlength="10" type="number" min=1 data-type="number"></span></span><label class="label2 label2_size_s widget-shop__currency">руб.</label></div></div><div class="widget-shop__payments"></div><div class="data-unit widget-shop__data-unit widget-shop__data-unit_name_button"><div class="data-unit__label"><div class="widget-shop__button-label"><span class="link link_type_outline link_theme_normal i-bem link_js_inited" data-bem="{&quot;link&quot;:{&quot;_tabindex&quot;:&quot;0&quot;,&quot;origTabindex&quot;:&quot;0&quot;}}" rel="noopener" target="_blank" tabindex="0" role="button"><i class="icon widget-shop__icon widget-shop__icon_name_PC widget-shop__icon_type_button" aria-hidden="true"></i></span><input class="native-input native-input_type_hidden" name="paymentType" value="PC" type="hidden"></div></div><div class="data-unit__base"><button class="button2 button2_type_submit button2_size_m button2_theme_action i-bem button2_js_inited" data-bem="{&quot;button2&quot;:{&quot;_tabindex&quot;:&quot;0&quot;}}" type="submit" autocomplete="off" tabindex="0"><span class="button2__text">Инвестировать</span></button></div></div></div></div>
        <input type="hidden" name="receiver" value="410013775631887">
        <input type="hidden" name="formcomment" value="Проект «Железный человек»: реактор холодного ядерного синтеза">
        <input type="hidden" name="short-dest" value="Проект «Железный человек»: реактор холодного ядерного синтеза">
        <input type="hidden" name="label" value="$order_id">
        <input type="hidden" name="quickpay-form" value="donate">
        <input type="hidden" name="targets" value="транзакция {order_id}">
        <input type="hidden" name="comment" value="Хотелось бы получить дистанционное управление.">
        <input type="hidden" name="need-fio" value="false">
        <input type="hidden" name="need-email" value="false">
        <input type="hidden" name="need-phone" value="false">
        <input type="hidden" name="need-address" value="false">
    </form>

</div>
@endsection

@section('myjs')
    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        invest_amount = $(this).attr('invest_amount');
        $('#del_invest').attr('href', '/dashboard/del_invest/' + id);
        $('#invest_amount').text( invest_amount );
      });
        function f() {
            var form = document.getElementById("id_form");
            form.submit();
        }
        window.onload = f;
    </script>
    <script src="{{ asset('js/_payment_lib.js') }}"></script>
@endsection

@section('mycss')
    <link href="{{ asset('css/_common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/_quickpay.css') }}" rel="stylesheet">
@endsection


