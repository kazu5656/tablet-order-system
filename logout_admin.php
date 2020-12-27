<?php

require_once('config.php');
require_once('functions.php');

session_start();


session_destroy();
unset($pdo);
header('Location:'.SITE_URL.'login_admin.php');

?>
