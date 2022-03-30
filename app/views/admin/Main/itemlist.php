<table class="item-list">
	<thead class="item-header">
	<tr>
		<th class="header-cell">ID</th>
		<th class="header-cell">Name</th>
		<th class="header-cell">Price</th>
		<th class="header-cell">Creation date</th>
		<th class="header-cell">Editing date</th>
		<th class="header-cell"></th>
	</tr>
	</thead>
	<tbody class="items-body">
	<?php foreach ($items as $item):?>
		<tr class="items-info">
			<td class="body-cell"><?= $item->getId() ?></td>
			<td class="body-cell"><?= $item->getName() ?></td>
			<td class="body-cell"><?= $item->getPrice() ?></td>
			<td class="body-cell"><?= $item->getCreationDate() ?></td>
			<td class="body-cell"><?= $item->getEditingDate() ?></td>
			<td class="body-cell">
				<form name="edit" action="http://eshop/admin/main/itemlist/<?= $item->getId() ?>" method="get">
					<button class="button">Edit</button>
				</form>
				<form name="delete" action="http://eshop/admin/main/itemlist" method="post">
					<button class="button" name="delete" value="<?= $item->getId() ?>">Delete</button>
				</form>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>