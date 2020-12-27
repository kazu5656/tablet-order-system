<?php

require_once('config.php');
require_once('functions.php');

session_start();

// データベースに接続する（PDOを使う）

$pdo = connectDb();


// ログアウト処理
$_SESSION = array();



unset($pdo);
header('Location:'.SITE_URL.'login_setting.php');

?>
