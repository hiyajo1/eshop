<?php

namespace Up\models\Services;

use Eshop\App;
use Eshop\Db;
use PDO;
use Up\models\Entity\Order;

class OrderService extends AppService
{

//получения данных о заказе
    public static function getOrderById($id_order): array
    {
        $query = self::get('up_order', [
            'fields' => ['ID', 'NAME', 'EMAIL', 'PHONE', 'COMMENT', 'CREATION_DATE', 'EDITING_DATE'],
            'where' => ['ID' => $id_order],
            'operand' => ['='],
            'join' => [
                'up_status' => [
                    'table' => 'up_status',
                    'type' => 'inner',
                    'fields' => ['NAME as status_name'],
                    'on' => ['STATUS_ID', 'ID']
                ],
                'up_item' => [
                    'table' => 'up_item',
                    'type' => 'inner',
                    'fields' => ['NAME as item_name', 'PRICE as item_price'],
                    'on' => [
                        'table' => 'up_order',
                        'fields' => ['ITEM_ID', 'ID']],
                ]
            ]
        ]);
        $queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $order = [];
        foreach ($queryResult as $key) {
            $order[] = new Order(
                $key['ID'], $key['NAME'], $key['item_name'], $key['item_price'], $key['status_name'],
                $key['EMAIL'], $key['PHONE'], $key['COMMENT'], $key['CREATION_DATE'], $key['EDITING_DATE']);
        }
        return $order;
    }

    public static function getOrders(): array
    {
        $query = self::get('up_order', [
            'fields' => ['ID', 'NAME', 'EMAIL', 'PHONE', 'COMMENT', 'CREATION_DATE', 'EDITING_DATE'],
            'operand' => ['='],
            'join' => [
                'up_status' => [
                    'table' => 'up_status',
                    'type' => 'inner',
                    'fields' => ['NAME as status_name'],
                    'on' => [
                        'table' => 'up_order',
                        'fields' => ['STATUS_ID', 'ID']
                        ]
                ],
                'up_item' => [
                    'table' => 'up_item',
                    'type' => 'inner',
                    'fields' => ['NAME as item_name', 'PRICE as item_price'],
                    'on' => [
                        'table' => 'up_order',
                        'fields' => ['ITEM_ID', 'ID']],
                ]
            ]
        ]);
        $queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $order = [];
        foreach ($queryResult as $key) {
            $order[] = new Order(
                $key['ID'], $key['NAME'], $key['item_name'], $key['item_price'], $key['status_name'],
                $key['EMAIL'], $key['PHONE'], $key['COMMENT'], $key['CREATION_DATE'], $key['EDITING_DATE']);
        }
        return $order;
    }

//создание нового заказа
    public static function createNewOrder($set): bool
    {
        if(!isset($set)){
            return false;
        }
        //имя.номер. телефона.емаил.коммент
        $query = self::add('up_order', [
            'fields' => [
                'ITEM_ID' => $set['item_id'],
                'NAME' => $set['order_name'],
                'STATUS_ID' => '1',
                'EMAIL' => $set['order_email'],
                'PHONE' => $set['order_phone'],
                'COMMENT' => $set['order_comment']
            ]
        ]);
        Db::getOrConnectPDO()->query($query);
        return true;
    }

//редактирование заказа
    public static function editOrder($id)
    {
        //имя.номер. телефона.емаил.коммент
        $query = self::edit('up_order', [
            'fields' => [
                'ITEM_ID' => $set['item_id'],
                'NAME' => $set['order_name'],
                'STATUS_ID' => '1',
                'EMAIL' => $set['order_email'],
                'PHONE' => $set['order_phone'],
                'COMMENT' => $set['order_comment']
            ],
            'where' => ['ID' => $set['order_id']]
        ]);
        //Db::getOrConnectPDO()->query($query);
    }

//удаление заказа
    public static function deleteOrder($id)
    {
        $query = self::delete('up_order', [
            'where' => ['ID' => $id]
        ]);
        Db::getOrConnectPDO()->query($query);
    }

    public function addToModalCart($item, $qty = 1)
    {
        $id = $item->getId();
        $title = $item->getName();
        $price = $item->getPrice();
        if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]['qty'] += $qty;
        } else {
			$_SESSION['cart'][$id] = [
				'qty' => $qty,
				'title' => $title,
				'price' => $price,
//				'img' => $item->getImage()
			];
		}
		$_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
		$_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $price : $qty * $price;
    }

	public function deleteItem($id)
	{
		$qtyMinus = $_SESSION['cart'][$id]['qty'];
		$sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
		$_SESSION['cart.qty'] -= $qtyMinus;
		$_SESSION['cart.sum'] -= $sumMinus;
		unset($_SESSION['cart'][$id]);
	}
}