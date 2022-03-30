<?php

require_once dirname(__DIR__) . "/config/init.php";
require_once LIBS . '/functions.php';
require_once CONF . '/routes.php';

\Eshop\Db::instance();
new \Eshop\App();

//throw new Exception('Страница не найдена', 404);
//debug(\Eshop\Router::getRoutes());