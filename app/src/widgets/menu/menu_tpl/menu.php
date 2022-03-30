<li>
	<a href="/category/<?=$category['ALIAS'];?>"><?= $category['NAME']; ?></a>
	<?php if (isset($category['CHILDREN'])): ?>
		<ul>
			<?= $this->getMenuHtml($category['CHILDREN']); ?>
		</ul>
	<?php endif; ?>
</li>