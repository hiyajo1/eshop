<?php

namespace Eshop;

class Request
{
	private static $storage; // переменная хранящая данные GET и POST
	private static $is_post;

	public static function init()
	{
		self::$storage = self::cleanInput($_REQUEST);
		if(empty($_POST))
		{
			self::$is_post = false;
		}
		else
		{
			self::$is_post = true;
		}
	}

	public static function get($name)
	{
		return self::$storage[$name] ?? null;
	}

	public static function isPost()
	{
		return self::$is_post;
	}

	private static function cleanInput($data) {
		if (is_array($data)) {
			$cleaned = [];
			foreach ($data as $key => $value) {
				$cleaned[$key] = self::cleanInput($value);
			}
			return $cleaned;
		}
		return trim(htmlspecialchars($data, ENT_QUOTES));
	}


	public function getRequestEntries()
	{
		return self::$storage;
	}
}