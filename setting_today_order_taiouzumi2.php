<?php

require_once('config.php');
require_once('functions.php');

session_start();
$pdo = connectDb();

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}

$user = $_SESSION['tablet_order_system_setting'];

$id = $_GET['id'];

$sql = "UPDATE order_record SET
taiou = :taiou,
updated_at = now()
where id = :id and user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt -> bindValue(':taiou','対応済', PDO::PARAM_STR);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt -> bindValue(':id',$id, PDO::PARAM_INT);
$stmt->execute();

unset($pdo);

// setting_today_table_order_list.phpに画面遷移する。
header('Location: '.SITE_URL.'setting_today_table_order_list.php');

?>
