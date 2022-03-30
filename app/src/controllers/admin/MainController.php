<?php

namespace Up\controllers\admin;

use Eshop\Request;
use Up\models\Services\ItemService;
use Up\models\Services\OrderService;

class MainController extends AppController
{
	public function indexAction()
	{

	}

	public function itemlistAction()
	{
        $items = ItemService::getItems();
		$currentMenuItem = 'Item list';
		$username = 'Admin Admin'; //edit
        if(isset($_POST['delete'])){
            $set['item_delete_id'] = clear_data($_POST['delete']);
            ItemService::deleteItem($set['item_delete_id']);
        }
        $this->set(compact('items', 'currentMenuItem', 'username'));
	}

	public function orderlistAction()
	{
		$currentMenuItem = 'Order list';
		$username = 'Admin Admin'; //edit
        $orders = OrderService::getOrders();
        if(isset($_POST['delete'])){
            $set['order_delete_id'] = clear_data($_POST['delete']);
            OrderService::deleteOrder($set['order_delete_id']);
        }
        $this->set(compact('orders', 'currentMenuItem', 'username'));
	}

	public function formAction()
	{
		$currentMenuItem = 'Form';
		$username = 'Admin Admin'; //edit
		$this->set(compact('currentMenuItem', 'username'));
	}

	public function indexLteAction()
	{
		$this->layout = 'adminlte';
	}
}