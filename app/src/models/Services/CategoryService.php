<?php

namespace Up\models\Services;


use Eshop\App;
use Eshop\Db;
use PDO;
use Up\models\Entity\Category;

class CategoryService extends AppService
{
//метод получения всех категорий
    public static function getCategories(): array
    {
        $query = self::get('up_category', ['fields' => ['ID', 'NAME', 'PARENT_ID', 'ALIAS']]);
        $queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($queryResult as $category) {
            $categories[] = new Category($category['ID'], $category['NAME'], $category['PARENT_ID'], $category['ALIAS']);
        }
        return $categories;
    }

//метод получения категорий по alias
    public static function getCategoryByAlias($alias): array
    {
        $query = self::get('up_category', [
            'fields' => ['ID', 'NAME', 'PARENT_ID', 'ALIAS'],
            'where' => ['ALIAS' => $alias]
        ]);
        return Db::getOrConnectPDO()->query($query)->fetch(PDO::FETCH_ASSOC);

    }

//метод создания новой категории
    public static function createNewCategory($set)
    {
        $query = self::add('up_category', [
            'fields' => [
                'NAME' => $set['category_name'],
                'PARENT_ID' => $set['category_parent'],
                'ALIAS' => '0'
            ]
        ]);
        //Db::getOrConnectPDO()->query($query);
    }

//метод удаления категории
    public static function deleteCategory($set)
    {
        $query = self::delete('up_category', [
            'where' => ['ID' => $set['category_id']]
        ]);
        //Db::getOrConnectPDO()->query($query);
    }

	public static function getIds($id): ?string
	{
		$cats = App::$app->getProperty('cats');
		$ids = null;
		foreach ($cats as $key => $value) {
			if ($value['PARENT_ID'] == $id) {
				$ids .= $key . ', ';
				$ids .= self::getIds($key);
			}
		}
		return $ids;
	}
}