<?php
/** @var array $item */
/** @var array $image */
/** @var array $categories */
?>


<div class="detailsCard">
	<div class="detailsCardPoster" style="background:  no-repeat "></div>
	<div class="detailsCardInfo">

		<div class="detailsCardHeader">
			<div class="detailsCardTitle headline"><?= $item->getName()?></div>
			<div class="detailsCardAuthor line"><?= ($item->getadditionalCharacteristics())['Автор']?></div>
		</div>
		<div class="detailsCardDescription line"><?= $item->getshortDesc()?></div>
		<div class="detailsCardTags line"><?/*= $categories[0]->getName()*/?></div>

		<div class="orderPart">
			<div class="detailsCardPrice line">Цена: <?= $item->getPrice()?> руб.</div>
			<div class="detailsCardOrderButton line">
				<a id="productAdd" data-id="<?= $item->getID(); ?>" href="/order/add?id=<?= $item->getID(); ?>"  class="add-to-cart-link">Заказать</a>
			</div>
		</div>
	</div>
</div>