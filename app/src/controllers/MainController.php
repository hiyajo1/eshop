<?php

namespace Up\controllers;

use Eshop\App;
use Eshop\Request;
use Up\models\Services\AttributesService;
use Up\models\Services\ItemService;
use Up\models\Services\ImageService;

class MainController extends AppController
{
	public function indexAction()
	{
		$this->setMeta(App::$app::getProperty('shop_name'), 'Описание', 'Ключевые слова');
		$items = ItemService::getItems(Request::get("category"), Request::get("search"), Request::get("additional"));
		$attributes = AttributesService::getAttributes(Request::get("category"));
		$additionalCharacteristics = AttributesService::getAdditionalCharacteristics();
		$images = ImageService::getImages();
		$this->set(compact('items', 'images', 'additionalCharacteristics', 'attributes'));
	}
}