<?php

require_once CORE . '/Autoloader.php';

$loader = new Autoloader();
$loader->register();

$loader->addNamespace('Up', __DIR__ . '/src');
$loader->addNamespace('Eshop', ROOT . '/vendor/eshop/core');
$loader->addNamespace('Db', ROOT . '/database');
$loader->addNamespace('Conf', ROOT . '/config');
