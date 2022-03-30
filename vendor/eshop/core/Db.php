<?php

namespace Eshop;

use Conf\Config;
use PDO;

class Db
{
	use TSingleton;

	private static $pdo;

	protected function __construct()
	{
		self::$pdo = self::getOrConnectPDO();
	}

	private static function connectPDOToDB(): void
	{
		Config::getDataBaseConfig();
		$dsn = sprintf('%s:host=%s;dbname=%s;charset=%s', DB_CS, DB_HOST, DB_NAME, DB_CHARSET);

		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false
		];
		try {
			self::$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
	}

	public static function getOrConnectPDO(): PDO
	{
		if(self::$pdo=== null)
		{
			self::connectPDOToDB();
		}
		return self::$pdo;
	}
}