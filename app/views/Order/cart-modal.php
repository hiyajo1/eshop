<?php if(!empty($_SESSION['cart'])): ?>
	<div class="modalOrder">
		<div class="orderCard">
			<div class="orderCardInfo">
				<table>
					<thead>
						<tr>
							<th class="orderCardFormHeadline line orderTableDataCell">Изображение</th>
							<th class="orderCardFormHeadline line orderTableDataCell">Название</th>
							<th class="orderCardFormHeadline line orderTableDataCell">Цена</th>
							<th class="orderCardFormHeadline line orderTableDataCell">Количество</th>
							<th class="orderCardFormHeadline line orderTableDataCell">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($_SESSION['cart'] as $id => $item): ?>
							<tr>
								<td class="orderTableDataCell">
									<div class="orderCardPoster"></div>
								</td>
								<td class="orderTableDataCell">
									<div class="orderCardTitle line"><?= $item['title'] ?></div>
								</td>
								<td class="orderTableDataCell">
									<div class="orderCardPrice line"><?= $item['price'] ?> руб</div>
								</td>
								<td class="orderTableDataCell">
									<div class="orderCardPrice line"><?= $item['qty'] ?></div>
								</td>
								<td class="orderTableDataCell">
									<span data-id="<?= $id; ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr>
							<td>Итого:</td>
							<td colspan="4" class="text-right cart-qty"><?= $_SESSION['cart.qty']; ?></td>
						</tr>
						<tr>
							<td>На сумму:</td>
							<td colspan="4" class="text-right cart-sum"><?= $_SESSION['cart.sum']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php else: ?>
	<h3>Корзина пуста</h3>
<?php endif; ?>