<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/../../src/auth.php');

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<body>
<link href="../../../../public/adminlte/dist/css/auth.css" rel="stylesheet" type="text/css">
<div class="login-page">
    <div class="form">
        <form class="login-form" method="post">
            <input type="text" name="login"/>
            <input type="password" name="password"/>
            <button>login</button>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
        </form>
    </div>
</div>
</body>
</html>
