<?php
/** @var array $err */

$action='';
?>



<body>
<form id="orderForm" class="orderCardForm" method="post" >
	<div class="orderCardFormHeadline line">Введите свои контактные данные</div>

	<label class="orderFormLabel line">Имя</label>
	<input class="orderCardInput" type="text" name="order_name" placeholder="Имя">
	<div class="orderFormError"><?= $err['order_name'] ?></div>

	<label class="orderFormLabel line">Номер телефона</label>
	<input class="orderCardInput" type="number" name="order_phone" placeholder="Номер телефона">
	<div class="orderFormError"><?= $err['order_phone'] ?></div>

	<label class="orderFormLabel line">Электронная почта</label>
	<input class="orderCardInput" type="text" name="order_email" placeholder="Электронная почта">
	<div class="orderFormError"><?= $err['order_email'] ?></div>

	<label class="orderFormLabel line">Комментарий к заказу</label>
	<textarea class="orderFormTextarea orderCardInput" type="text" name="order_comment" placeholder="Коммантарий к заказу"></textarea>
	<div class="orderFormError"><?= $err['order_comment'] ?></div>

	<button class="buttons line">Оформить заказ</button>
</form>
</body>