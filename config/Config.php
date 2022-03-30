<?php

namespace Conf;

class Config
{
    public static function getDataBaseConfig(string $iniFileName='db_config.ini'):void
    {
        $iniFileArray = parse_ini_file($iniFileName);
        define('DB_HOST', $iniFileArray['db_host']);
        define('DB_USERNAME', $iniFileArray['db_userName']);
        define('DB_PASSWORD', $iniFileArray['db_password']);
        define('DB_NAME', $iniFileArray['db_name']);
        define('DB_VERSIONS', $iniFileArray['db_versions']);
        define('DB_CS', $iniFileArray['db_CS']);
        define('DB_CHARSET', $iniFileArray['db_charset']);
        define('DB_PATH', $iniFileArray['db_path']);
    }
}