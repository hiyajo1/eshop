<?php

namespace Up\controllers\admin;

use Eshop\base\Controller;

class AuthController extends AppController
{
    public function loginAction(){
     $this->layout = false;
    }
}