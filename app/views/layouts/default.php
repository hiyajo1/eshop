<?php
/** @var  $content */
?>
<!doctype html>
<html lang="en">
<head>
	<?= $this->getMeta(); ?>
	<link rel="stylesheet" href="/public/source/css/reset.css">
	<link rel="stylesheet" href="/public/css/bootstrap.css">
	<link rel="stylesheet" href="/public/source/css/layouts/layout.css">
	<link rel="stylesheet" href="/public/source/css/Main/main.css">
	<link rel="stylesheet" href="/public/source/css/details/details.css">
	<link rel="stylesheet" href="/public/source/css/order/order.css">
	<!-- Мега меню -->
	<link href="/public/megamenu/css/ionicons.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="/public/megamenu/css/style.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<div class="header">
	<div class="searchbar">
		<a class="headline" href="http://eshop/">между строк</a>
		<div class="usefullHeader">
			<div class="basket">
				<a href="/order/show" onclick="getCart(); return false;">
					<div class="basketLogo" style="
						background: url('/public/source/icons/basket.svg') no-repeat;
						background-size: cover;
						width: 50px;
						height: 50px;
					"></div>
					<?php if (!empty($_SESSION['cart'])): ?>
						<span class="simpleCart_total"><?= $_SESSION['cart.sum'] ?></span>
					<?php else: ?>
						<span class="simpleCart_total">Корзина пуста</span>
					<?php endif; ?>
				</a>
			</div>
			<div class="searchline">
				<form class="searchForm" action="http://eshop/" method="get">
					<input name="search" id="search" required>
					<button class="searchLogo" style="
						background: url('/public/source/icons/searchLogo.svg') no-repeat;">
					</button>
				</form>
			</div>
		</div>
	</div>
	<div class="tags">
		<div class="menu-container">
			<div class="menu">
				<?php new \Up\widgets\menu\Menu([
					'prepend' => '<li><a href="" class="menu-dropdown-icon">Новинки</a></li>'
				]); ?>
			</div>
		</div>
	</div>
</div>

<div class="content">
		<?= $content;?>
</div>

<div class="footer">

</div>

<!-- Модальное окно -->
<div class="modal fade" id="order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Заказ</h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
				<a href="/order/view" type="button" class="btn btn-primary">Оформить заказ</a>
				<button type="button" class="btn btn-danger" onclick="clearCart()">Очистить заказ</button>
			</div>
		</div>
	</div>
</div>

<script src="/public/js/jquery-1.11.0.min.js"></script>
<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/megamenu/js/megamenu.js"></script>
<script src="/public/js/order.js"></script>

</body>
</html>