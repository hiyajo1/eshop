<?php

namespace Eshop;

abstract class ValidationMain
{
    private $pattern_name = "/^[a-zA-Zа-яёА-ЯЁ]+$/u";
    private $pattern_phone = '/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/';

    public function validateNameByRus($field, $required = true)
    {
        if($required && empty($field)){
            return 'Поле не может быть пустым';
        }elseif(!preg_match($this->pattern_name, $field)){
            return 'Только латинские и русские буквы.';
        }else{
            return false;
        }
    }

    public function validatePhone($field, $required = true)
    {
        if($required && empty($field)){
            return 'Поле не может быть пустым';
        }elseif(!preg_match($this->pattern_phone, $field)){
            return 'Неверный формат номера';
        }else{
            return false;
        }
    }

    public function validateEmail($field, $required = true)
    {
        if($required && empty($field)){
            return 'Поле не может быть пустым';
        }elseif(!(filter_var($field, FILTER_VALIDATE_EMAIL) && strlen($field) > 2)){
            return 'Неверный формат email';
        }else{
            return false;
        }
    }

    public function validateComment($field, $required = true, $symbols = 300)
    {
        if($required && empty($field)){
            return 'Поле не может быть пустым';
        }elseif(strlen($field) > $symbols){
            return 'Должно быть не более 300 символов';
        }else{
            return false;
        }
    }

    public function setPatternName(string $pattern_name): void
    {
        $this->pattern_name = $pattern_name;
    }

    public function setPatternPhone(string $pattern_phone): void
    {
        $this->pattern_phone = $pattern_phone;
    }


}