

<br><br>

<center><h2>Переход в Яндекс</h2></center>

<form method="POST" hidden="true" id="FormID" action="https://money.yandex.ru/quickpay/confirm.xml">
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

<script>
    function f() {
        var form = document.getElementById("FormID");
        form.submit();
    }
    window.onload = f;
</script>