<?php

namespace Up\lib\auth;

use PDO;




if ( !empty($_REQUEST['password']) and !empty($_REQUEST['login']) ) {
    $login = $_REQUEST['login'];
    $password = $_REQUEST['password'];

    $pdo = new PDO('mysql:host=localhost;dbname=eshop', 'admin', 'admin');
    $result = $pdo->query('SELECT*FROM users WHERE login="'.$login.'"');

    $user = $result->fetch(PDO::FETCH_ASSOC);

    if (!empty($user)) {
        $salt = $user['salt'];
        $saltedPassword = md5($password.$salt);

        if ($user['password'] == $saltedPassword) {

            session_start();

            $_SESSION['auth'] = true;

            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['status'] = $user['status'];
            header ("Location: ..");
        }
        else {
            echo "Wrong pass or login";
        }
    } else {
        echo "Wrong pass or login";
    }
}
?>
