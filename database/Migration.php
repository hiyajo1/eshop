<?php

namespace Db;

use Eshop\ErrorHandler;
use PDO;
use Eshop\Db;

class Migration
{
	public static function getMigrationFiles(): array
    {
        $dataBase = Db::getOrConnectPDO();

        $sqlFolder = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
        $allFiles = glob($sqlFolder . 'migrations/' . '*.sql');

        $query = sprintf('show tables from `%s` like "%s"', DB_NAME, DB_VERSIONS);
        $data = $dataBase->query($query);
        $firstMigration = $data->fetchAll();


        if (!$firstMigration) {
            return $allFiles;
        }

        $versionsFiles = array();
        $query = sprintf('SELECT name FROM %s', DB_VERSIONS);
        $result = $dataBase->query($query);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            array_push($versionsFiles, $sqlFolder . 'migrations/' . $row['name']);
        }

        return array_diff($allFiles, $versionsFiles);
    }

    public static function migrate($file):void
    {
        $dataBase = Db::getOrConnectPDO();
		$error = new ErrorHandler();
		$error->setPathLog(ROOT . '/tmp/migration.log');

        $command = sprintf('%s -u%s -p%s -h %s -D %s < %s', DB_PATH, DB_USERNAME, DB_PASSWORD, DB_HOST, DB_NAME, $file);
        exec($command, $output, $result);
        if ($result) {
			throw new \Exception('Нарушена миграция', 500);
        }
        $baseName = basename($file);
        $query = sprintf('insert into %s (`name`) values("%s")', DB_VERSIONS, $baseName);
        $dataBase->query($query);
    }

    public static function migrationRun():void
    {
        $files = self::getMigrationFiles();
        $log = date('Y-m-d H:i:s');
        if (empty($files)) {
            $log .= ' Ok. Your database is up to date';
            file_put_contents(ROOT . '/tmp/migration.log', $log . PHP_EOL, FILE_APPEND);

        } else {
            $log .= ' Start Migration...' . PHP_EOL;
            foreach ($files as $file) {
                self::migrate($file);
                $log .= basename($file) . PHP_EOL;
            }
            $log .= 'Migration completed.' . PHP_EOL;
            file_put_contents(ROOT . '/tmp/migration.log', $log . PHP_EOL, FILE_APPEND);
        }
    }
}