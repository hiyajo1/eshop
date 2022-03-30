<?php

namespace Up\controllers;

use Eshop\App;
use Eshop\Cache;
use Up\models\AppModel;
use Up\models\Services\CategoryService;
use Up\models\Services\ImageService;
use Up\models\Services\ItemService;

class DetailsController extends AppController
{
	public function indexAction()
	{
		$this->setMeta(App::$app::getProperty('shop_name'), 'Описание', 'Ключевые слова');

		$id = $this->route['id'];
		$item = ItemService::getItemById($id);
		if($item === null)
		{
			$this->view = "item_not_found";
		}
//		$image = ImageService::getImageById($id);//значение 3 для примера
		$categories = CategoryService::getCategories();
		$this->set(compact('item', 'categories'));
	}
}