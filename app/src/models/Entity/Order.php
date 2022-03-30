<?php

namespace Up\models\Entity;

class Order
{
    private $id;
    private $user_name;
    private $item_name;
    private $item_price;
    private $status_id;
    private $email;
    private $phone;
    private $comment;
    private $creation_date;
    private $editing_date;
    private static $configForm = [
        'order_name' => '',
        'order_phone' => '',
        'order_email' => '',
        'order_comment' => ''
    ];

    public function __construct(
        $id,$user_name, $item_name, $item_price, $status_name, $email, $phone, $comment, $creation_date, $editing_date)
    {
        $this->id = $id;
        $this->user_name = $user_name;
        $this->item_name = $item_name;
        $this->item_price = $item_price;
        $this->status_id = $status_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->comment = $comment;
        $this->creation_date = $creation_date;
        $this->editing_date = $editing_date;
    }

    public static function getConfigForm(): array
    {
        return self::$configForm;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUserName()
    {
        return $this->user_name;
    }

    public function setUserName($user_name): void
    {
        $this->user_name = $user_name;
    }

    public function getItemName()
    {
        return $this->item_name;
    }

    public function setItemName($item_name): void
    {
        $this->item_name = $item_name;
    }

    public function getItemPrice()
    {
        return $this->item_price;
    }

    public function setItemPrice($item_price): void
    {
        $this->item_price = $item_price;
    }


    public function getStatusId()
    {
        return $this->status_id;
    }

    public function setStatusId($status_id): void
    {
        $this->status_id = $status_id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getComment()
    {
        return $this->comment;
    }


    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date): void
    {
        $this->creation_date = $creation_date;
    }


    public function getEditingDate()
    {
        return $this->editing_date;
    }

    public function setEditingDate($editing_date): void
    {
        $this->editing_date = $editing_date;
    }





}