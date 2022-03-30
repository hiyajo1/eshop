<?php

namespace Up\controllers;

use Eshop\App;
use Eshop\base\Controller;
use Eshop\Cache;
use Up\models\Services\AppService;

class AppController extends Controller
{
	public function __construct($route)
	{
		parent::__construct($route);
		App::$app->setProperty('cats', self::cacheCategory());
	}

	public static function cacheCategory()
	{
		$cache = Cache::instance();
		$cats = $cache->get('cats');
		if (!$cats) {
			$cats = AppService::getAssoc('up_category');
			$cache->set('cats', $cats);
		}
		return $cats;
	}
}