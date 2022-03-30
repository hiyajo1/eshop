<?php

namespace Up\controllers;

use Eshop\App;
use Eshop\Cache;
use Eshop\Request;
use http\Url;
use Up\models\Entity\Order;
use Up\models\Services\CategoryService;
use Up\models\Services\ItemService;
use Up\models\Services\OrderService;

class OrderController extends AppController
{
//    public function indexAction()
//    {
//        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключевые слова');
//
//        $order = OrderService::getOrder(1);//пример
//        if($order === null)
//        {
//            $this->view = "order_not_found";
//        }
//        $this->set(compact('order'));
//    }

	public function addAction()
	{
		$id = !empty(Request::get('id')) ? clear_data(Request::get('id')) : null;
		if ($id) {
			$item = ItemService::getItemById($id);
			if (!$item) {
				return false;
			}
		}
		$orderModal = new OrderService();
		$orderModal->addToModalCart($item);
		if ($this->isAjax()) {
			$this->loadView('cart-modal');
		}
		redirect();
	}

	public function showAction()
	{
		$this->loadView('cart-modal');
	}

	public function deleteAction()
	{
		$id = !empty(Request::get('id')) ? clear_data(Request::get('id')) : null;
		if (isset($_SESSION['cart'][$id])) {
			$orderModal = new OrderService();
			$orderModal->deleteItem($id);
		}
		if ($this->isAjax()) {
			$this->loadView('cart-modal');
		}
		redirect();
	}

	public function clearAction()
	{
		unset($_SESSION['cart']);
		unset($_SESSION['cart.qty']);
		unset($_SESSION['cart.sum']);
		unset($_SESSION['cart.currency']);
		$this->loadView('cart-modal');
	}

	public function viewAction()
	{
        debug($_SESSION);
        $err = Order::getConfigForm();
        if(isset($_POST)){
            $set = [];
            foreach ($_POST as $key => $var){
                $set[$key] = clear_data($var);
            }
            $set['item_id'] = $_SESSION['order']['id'];
            $validator = new Validation();
            $result = $validator->validateOrderPublic($set);
            $err = $result['error'];
            if($result['flag'] === 0) {
                OrderService::createNewOrder($set);
                redirect('http://eshop/main');
              }
        }
		$this->set(compact('err'));
	}
}