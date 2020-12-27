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

// idのメニューを削除
$sql = "select * from food where id = :id and user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
$menu = $stmt->fetch();

if(!$menu){

    // データが取得出来なかったら404エラーページに遷移
    error_log(date("Y/m/d H:i:s"). basename(__FILE__)." アイテムid＝"."$id"."で404エラーが発生しました。".PHP_EOL, 3, "../logs/error_log");
    error_log(date("Y/m/d H:i:s"). basename(__FILE__)."で404エラーが発生しました。", 1, "goalhunter.kazu@gmail.com");
    header('Location: '.SITE_URL.'404.php');
    exit;

}else{

    // idのメニューを削除
    $sql = "delete from food where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->execute();

}


unset($pdo);

// setting_food_menu.phpに画面遷移する。
header('Location: '.SITE_URL.'setting_food.php');

?>
