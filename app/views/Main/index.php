<?php
/** @var array $items */
/** @var array $images */
/** @var array $categories */
/** @var array $attributes */
/** @var array $additionalCharacteristics */
?>
<div class="mainPartContent">
	<?php if($items): ?>
	<div class="itemCardList">
		<?php foreach ($items as $item):?>
		<div class="itemCard">
			<div class="itemOverlay">
				<a class="detailsButton headline" href="http://eshop/details/<?= $item->getId()?>">Подробнее</a>
			</div>
			<div class="itemCardPoster" style="background: url() no-repeat;"></div>
			<div class="itemCardInfo">
				<div class="itemCardTitle line"><?= $item->getName()?></div>
				<div class="itemCardAuthor"><?= ($item->getadditionalCharacteristics())['Автор']?></div>
				<div class="itemCardPrice"><?= $item->getPrice()?> руб.</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>
	<?php else: ?>
	<h3>По вашему запросу ничего не найдено</h3>
	<?php endif; ?>
	<div class="itemsFilter">
		<?php foreach ($attributes as $attribute):?>
		<div class="itemsFilterBlock">
			<div class="itemsFilterHeadline line"><?= $attribute['attributeName']?></div>
			<?php foreach ($additionalCharacteristics[1][$attribute['attributeID']] as $key => $additionalCharacteristic):?>
				<div class="itemsFilterLine">
					<input type="checkbox" class="itemsFilterInput">
					<label class="itemsFilterInputLabel line"><?= ($key) ?></label>
				</div>
			<?php endforeach;?>
		</div>
		<?php endforeach;?>
	</div>
</div>

<div class="pageListingButtons">
	<div class="pageListingButton pageListingButtonArrow line"><</div>
	<div class="pageListingButton pageListingButtonNumber line">1</div>
	<div class="pageListingButton pageListingButtonNumber line">2</div>
	<div class="pageListingButton pageListingButtonNumber line">3</div>
	<div class="pageListingButton pageListingButtonNumber line">4</div>
	<div class="pageListingButton pageListingButtonArrow line">></div>
</div>