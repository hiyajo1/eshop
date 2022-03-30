<?php

namespace Up\models\Services;

use Eshop\Db;
use PDO;

class AttributesService extends AppService
{
	public static function getAttributes($categoryId = null): array
	{
		$query = "SELECT *
				FROM up_attributes";
		if($categoryId !== null)
		{
			$query .= " WHERE CATEGORY_ID = " . $categoryId;
		}

		$queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
		$attributes = [];
		foreach ($queryResult as $row)
		{
			$attributes[$row['ID']] =['attributeName' => $row['NAME'], 'attributeID' => $row['ID']];
		}
		return $attributes;
	}

	public static function getAdditionalCharacteristics(): array
	{
		$query = "SELECT
				   uac.NAME as CHARACTERISTIC_NAME,
       			   up_attributes.ID as ATTRIBUTE_ID,
				   up_attributes.CATEGORY_ID,
				   GROUP_CONCAT(
						   CONCAT( uac.ITEM_ID)
						   SEPARATOR ','
					   ) ITEMS
			FROM up_attributes
			INNER JOIN up_additional_characteristics uac on up_attributes.ID = uac.ATTRIBUTES_ID
			GROUP BY uac.NAME";
		$queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
		$additionalCharacteristics = [];
		foreach ($queryResult as $row)
		{
			$additionalCharacteristics[$row['CATEGORY_ID']][$row['ATTRIBUTE_ID']][$row['CHARACTERISTIC_NAME']] =
				explode(',',$row['ITEMS']);
		}
		return $additionalCharacteristics;
	}
}