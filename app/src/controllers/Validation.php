<?php

namespace Up\controllers;

use Eshop\ValidationMain;

class Validation extends ValidationMain
{
    public function validateOrderPublic(array $dataPost): array
    {
        $flag = 0;
        $error['order_name'] = isset($dataPost['order_name']) ? $this->validateNameByRus($dataPost['order_name']) : '';
        $error['order_phone'] = isset($dataPost['order_phone']) ? $this->validatePhone($dataPost['order_phone']) : '';
        $error['order_email'] = isset($dataPost['order_email']) ? $this->validateEmail($dataPost['order_email']) : '';
        $error['order_comment'] = isset($dataPost['order_comment']) ? $this->validateComment($dataPost['order_comment'], false) : '';
        foreach ($error as $item){
            if($item !== false){
                $flag = 1;
            }
        }
        return ['error' => $error, 'flag' => $flag];
    }
}