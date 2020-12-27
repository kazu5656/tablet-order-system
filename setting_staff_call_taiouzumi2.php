<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}

$pdo = connectDb();

$user = $_SESSION['tablet_order_system_setting'];

$id = $_GET['id'];

$sql = "delete from staff_call where order_table = :order_table and user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':order_table',$id, PDO::PARAM_INT);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
unset($pdo);


// setting_today_order.phpに画面遷移する。
header('Location: '.SITE_URL.'setting_today_table_order_list.php');

?>
