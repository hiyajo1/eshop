<?php

namespace Up\models\Services;


use Eshop\Db;
use PDO;
use Up\models\Entity\Item;

class ItemService extends AppService
{

//метод получения товаров
    public static function getItems($category = null, $name = null, $additional = null): array
    {
        $query = self::getQuery() . " WHERE i.ACTIVE = TRUE";
        if ($category !== null)
		{
            $query .= " && uc.NAME = '" . $category . "'";
        }
		if($additional !== null)
		{
			$paramsStr = implode('\',\'',$additional);
			$query .= " 
			&& i.ID IN (
    						SELECT i2.ID
							FROM up_item i2
							INNER JOIN up_additional_characteristics uac2 on i2.ID = uac2.ITEM_ID
							WHERE uac2.NAME IN ('" . $paramsStr . "')
							HAVING COUNT(DISTINCT uac2.ATTRIBUTES_ID) = " . count($additional) .
						")";
		}
        if ($name !== null)
		{
            $query .= " && i.NAME LIKE '%" . $name . "%'";
        }
        $query .= " GROUP BY i.ID ";
        $queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $items = [];
        $additionalCharacteristics = [];
        foreach ($queryResult as $item) {
            parse_str($item['ADDITIONAL_CHARACTERISTICS'], $additionalCharacteristics);
            $items[] = new Item(
                $item['ID'], $item['NAME'], $item['PRICE'], $item['SHORT_DESC'],
                $item['SHORT_DESC'], $item['CREATION_DATE'], $item['EDITING_DATE'], $item['SORT_ORDER'],
                $additionalCharacteristics
            );
        }
        return $items;
    }

//метод получения одного товара
    public static function getItemById($id): Item
    {
        $query = self::getQuery() . " AND i.ID =" . $id;
        $queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $additionalCharacteristics = [];
        parse_str($queryResult[0]['ADDITIONAL_CHARACTERISTICS'], $additionalCharacteristics);
        return new Item(
            $queryResult[0]['ID'], $queryResult[0]['NAME'], $queryResult[0]['PRICE'], $queryResult[0]['SHORT_DESC'],
            $queryResult[0]['SHORT_DESC'], $queryResult[0]['CREATION_DATE'], $queryResult[0]['EDITING_DATE'], $queryResult[0]['SORT_ORDER'],
            $additionalCharacteristics
        );
    }

//метод получения товара по категории
	public static function getItemsByCategory($ids, $start, $perpage): array
	{
		$query = self::getQuery() . " WHERE uic.CATEGORY_ID in ($ids)";
		$query .= " GROUP BY i.ID LIMIT $start, $perpage";
		$queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
		$items = [];
		$additionalCharacteristics = [];
		foreach ($queryResult as $item) {
			parse_str($item['ADDITIONAL_CHARACTERISTICS'], $additionalCharacteristics);
			$items[] = new Item(
				$item['ID'], $item['NAME'], $item['PRICE'], $item['SHORT_DESC'],
				$item['SHORT_DESC'], $item['CREATION_DATE'], $item['EDITING_DATE'], $item['SORT_ORDER'],
				$additionalCharacteristics
			);
		}
		return $items;
	}

	public static function countItemsInCategory($ids): int
	{
		$query = self::getQuery() . " WHERE uic.CATEGORY_ID in ($ids)";
		$query .= " GROUP BY i.ID ";
		return Db::getOrConnectPDO()->query($query)->rowCount();
	}

//метод создания нового товара
    public static function createNewItem($set)
    {
        $query = self::add('up_item', [
            'fields' => [
                'NAME' => $set['item_name'],
                'PRICE' => $set['item_price'],
                'SHORT_DESC' => $set['item_short_desc'],
                'FULL_DESC' => $set['item_full_desc'],
                'IMG' => $set['item_main_img'],
                'SORT_ORDER' => $set['item_sort_order'],
                'ACTIVE' => $set['item_active']
            ]
        ]);
//        Db::getOrConnectPDO()->query($query);
//        $set['item_id'] = Db::getOrConnectPDO()->lastInsertId();
        $queryIMG = '';
        foreach ($set['default_img'] as $img) {
            $queryIMG .= self::add('up_image', [
                    'fields' => [
                        'ITEM_ID' => $set['item_id'],
                        'IMG' => $img
                    ]
                ]) . ' ';
        }
//        Db::getOrConnectPDO()->query($queryIMG);
        $queryItemCategory = '';
        foreach ($set['item_category'] as $category) {
            $queryItemCategory .= self::add('up_item_category', [
                    'fields' => ['ITEM_ID' => $set['item_id'], 'CATEGORY_ID' => $category]
                ]) . ' ';
        }
//        Db::getOrConnectPDO()->query($queryItemCategory);
        $queryItemAttributes = '';
        foreach ($set['item_attributes'] as $attribute) {
            $queryItemCategory .= self::add('up_additional_characteristics', [
                    'fields' => ['NAME' => $attribute['NAME'], 'ITEM_ID' => $set['item_id'], 'ATTRIBUTE_ID' => $attribute['ID']]
                ]) . ' ';
        }
//        Db::getOrConnectPDO()->query($queryItemAttributes;
        return $query;
    }

//метод редактирование товара
    public static function editItem($set)
    {
        ItemService::edit('up_item', [
            'fields' => [
                'NAME' => $set['new_item_name'],
                'PRICE' => $set['new_item_price'],
                'SHORT_DESC' => $set['new_item_short_desc'],
                'FULL_DESC' => $set['new_item_full_desc'],
                'IMG' => $set['new_item_mainimg'],
                'SORT_ORDER' => $set['new_item_sort_order'],
                'ACTIVE' => $set['new_active']
            ],
            'where' => ['id' => $set['item_id']],
            'operand' => ['=']
        ]);
        $imageQuery = '';
        foreach ($set['new_item_images_id'] as $image) {
            $imageQuery .= ItemService::edit('up_item_image', [
                    'fields' => ['IMG' => $image['new_image_path']],
                    'where' => ['id' => $image['image_id']]
                ]) . ' ';
        }
        ItemService::delete('up_item_category', [
            'where' => ['ITEM_ID' => $set['item_id']]
        ]);

        foreach ($set['item_category'] as $category) {
            $queryCategory = self::add('up_item_category', [
                'fields' => ['ITEM_ID' => $set['item_id'], 'CATEGORY_ID' => $category]
            ]);
            //Db::getOrConnectPDO()->query($queryCategory);
        }

        foreach ($set['item_characteristics'] as $characteristic) {
            $queryItemCharacteristic = self::edit('up_additional_characteristics', [
                'fields' => ['NAME' => $characteristic['NAME'], 'ITEM_ID' => $characteristic['ITEM_ID'], 'ATTRIBUTE_ID' => $characteristic['ID']],
                'where' => ['ID' => $characteristic['ID']]
            ]);
            //Db::getOrConnectPDO()->query($queryItemCharacteristic);
        }
    }

//метод удаления товара
    public static function deleteItem($id): void
    {
        $query = self::delete('up_item', [
            'where' => ['ID' => $id]
        ]);
        echo $query;
        Db::getOrConnectPDO()->query($query);
    }

    protected static function getQuery(): string
    {
        return $query = "SELECT
       				i.ID,
       				i.NAME,
       				i.PRICE,
       				i.SHORT_DESC,
       				i.FULL_DESC,
       				i.SORT_ORDER,
       				i.CREATION_DATE,
       				i.EDITING_DATE,
       				GROUP_CONCAT(
             			CONCAT( ua.NAME,'=',uac.NAME)
               			SEPARATOR '&'
           			) ADDITIONAL_CHARACTERISTICS
				FROM up_item i
				INNER JOIN up_item_category uic on i.ID = uic.ITEM_ID
				INNER JOIN up_category uc on uic.CATEGORY_ID = uc.ID
				INNER JOIN up_attributes ua on uc.ID = ua.CATEGORY_ID
				INNER JOIN up_additional_characteristics uac on i.ID = uac.ITEM_ID and ua.ID = uac.ATTRIBUTES_ID";
    }
}