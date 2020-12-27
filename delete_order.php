<?php

require_once('config.php');
require_once('functions.php');

session_start();

// セッションからユーザ情報を取得

if (!isset($_SESSION['tablet_order_system_USER'])) {
    header('Location: '.SITE_URL.'login_order.php');
    exit;
}

// セッションからユーザ情報を取得


$user = $_SESSION['tablet_order_system_USER'];
$pdo = connectDb();


$id = $_GET['id'];

// $idと同じ番号のセッションのデータを消す
for ($i = 0; $i <= 9; $i=$i+1){
		if($_SESSION['order'][$i]['number']==$id){
				unset($_SESSION['order'][$i]);
		}
}

unset($pdo);

// order_kakunin.phpに画面遷移する。
header('Location: '.SITE_URL.'order_kakunin.php');

?>
