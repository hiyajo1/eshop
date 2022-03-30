<?php

namespace Up\controllers;

use Eshop\App;
use Eshop\libs\Pagination;
use Up\models\Services\CategoryService;
use Up\models\Services\ItemService;

class CategoryController extends AppController
{
	public function viewAction()
	{
		$alias = $this->route['alias'];
		$category = CategoryService::getCategoryByAlias($alias);
		if (!$category) {
			throw new \Exception('Страница не найдена', 404);
		}

		$ids = CategoryService::getIds($category['ID']);
		$ids = !$ids ? $category['ID'] : $ids . $category['ID'];

		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$perpage = App::$app->getProperty('pagination');

		$total = ItemService::countItemsInCategory($ids);
		$pagination = new Pagination($page, $perpage, $total);
		$start = $pagination->getStart();

		$items = ItemService::getItemsByCategory($ids, $start, $perpage);

		$this->setMeta('Категории');
		$this->set(compact('items', 'pagination', 'total'));
	}
}