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

$id = $_GET['id'];

$sql = "delete from group_setting where id = :id and user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
unset($pdo);

// setting_group_list.phpに画面遷移する。
header('Location: '.SITE_URL.'setting_group.php');

?>
