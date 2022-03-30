<?php

namespace Up\models\Services;

use Eshop\Db;
use PDO;
use Up\models\Entity\Image;

class ImageService extends AppService
{
	public static function getImages(): array
    {
        $query = self::get('up_item_image', [
            'fields' => ['ID', 'ITEM_ID', 'IMG']
        ]);
        $queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $images= [];
        foreach ($queryResult as $image) {
            $images[] = new Image(
                $image['ID'], $image['ITEM_ID'], $image['IMG']);
        }
        return $images;
    }

	public static function getImageById($id): Image
	{
        $query = self::get('up_item_image', [
            'fields'=>['ID', 'ITEM_ID', 'IMG'],
            'where' => ['ITEM_ID' => $id]
        ]);
		$queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
		return new Image(
			$queryResult[0]['ID'], $queryResult[0]['ITEM_ID'], $queryResult[0]['IMG']);
	}
}