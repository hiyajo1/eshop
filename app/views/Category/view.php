<div class="mainPartContent">
	<?php if(!empty($items)): ?>
		<div class="itemCardList">
			<?php foreach ($items as $item):?>
				<div class="itemCard">
					<div class="itemOverlay">
						<a class="detailsButton headline" href="http://eshop/details/<?= $item->getId()?>">Подробнее</a>
					</div>
					<div class="itemCardPoster" style="background: url() no-repeat;"></div>
					<div class="itemCardInfo">
						<div class="itemCardTitle"><?= $item->getName()?></div>
						<div class="itemCardAuthor"><?= ($item->getadditionalCharacteristics())['Автор']?></div>
						<div class="itemCardPrice"><?= $item->getPrice()?> руб.</div>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php else: ?>
		<h3>В данной категории пока нет товаров...</h3>
	<?php endif; ?>
</div>
<div class="text-center">
	<?php if($pagination->countPages > 1): ?>
		<?= $pagination; ?>
	<?php endif; ?>
	<p>(<?= count($items); ?> товара(ов) <?= $total; ?>)</p>
</div>