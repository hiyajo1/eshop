<table class="item-list">
	<thead class="item-header">
	<tr>
		<th class="header-cell">ID</th>
		<th class="header-cell">ITEM_ID</th>
		<th class="header-cell">EMAIL</th>
		<th class="header-cell">PHONE</th>
		<th class="header-cell">COMMENT</th>
		<th class="header-cell">CREATION_DATE</th>
		<th class="header-cell">EDITING_DATE</th>
		<th class="header-cell"></th>
	</tr>
	</thead>
	<tbody class="items-body">
	<?php foreach ($orders as $order):?>
	<tr class="items-info">
		<td class="body-cell"><?= $order->getId() ?></td>
		<td class="body-cell"><?= $order->getItemId() ?></td>
		<td class="body-cell"><?= $order->getEmail() ?></td>
		<td class="body-cell"><?= $order->getPhone() ?></td>
		<td class="body-cell"><?= $order->getComment() ?></td>
		<td class="body-cell"><?= $order->getCreationDate() ?></td>
		<td class="body-cell"><?= $order->getEditingDate() ?></td>
		<td class="body-cell">
			<form name="edit" action="http://eshop/admin/main/orderlist/<?= $order->getId() ?>" method="get">
				<button class="button">Edit</button>
			</form>
			<form name="delete" action="http://eshop/admin/main/orderlist" method="post">
				<button class="button" name="delete" value="<?= $order->getId() ?>">Delete</button>
			</form>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>