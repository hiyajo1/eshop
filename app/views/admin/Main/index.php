<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__.'/../../src/auth.php');
require(__ROOT__ . '/../../src/logout.php');

if ($_SESSION['auth'] = false){
    header ('Location: ../admin/auth/login');
}
if ($_SESSION['status'] != 1){
    header ('Location:../admin/auth/login');
}


?>

<div>
	<a class="item-back-list" href="http://eshop/admin/main/itemlist">Item list</a>
</div>
<div>
	<a class="item-back-list" href="http://eshop/admin/main/orderlist">Order list</a>
</div>
<div>
	<a class="item-back-form" href="http://eshop/admin/main/form">Form</a>
</div>
