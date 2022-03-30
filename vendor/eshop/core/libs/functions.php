<?php

function debug($array)
{
	echo '<pre>' . print_r($array, true) . '</pre>';
}

function redirect($http = false)
{
	if ($http) {
		$redirect = $http;
	} else {
		$redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
	}
	header("Location: $redirect");
	exit;
}

function clear_data($var){
    $var = trim($var);
    $var = stripcslashes($var);
    $var = strip_tags($var);
    $var = htmlspecialchars($var);
    return $var;
}