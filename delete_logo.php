<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}

// セッションからユーザ情報を取得

$user = $_SESSION['tablet_order_system_setting'];
$pdo = connectDb();


// idのメニューを削除
$sql = "delete from logo where user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();

unset($pdo);

// setting_food_menu.phpに画面遷移する。
header('Location: '.SITE_URL.'setting_logo_import.php');

?>
