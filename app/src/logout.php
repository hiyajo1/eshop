<?php


namespace Up\lib\logout;

if (isset($_REQUEST['logOut'])) {
    $_SESSION['auth'] = false;
    session_destroy();
    header ("Location: ..");
}
