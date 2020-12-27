<?php

require_once('config.php');
require_once('functions.php');

session_start();

// セッションからユーザ情報を取得

$user = $_SESSION['tablet_order_system_USER'];
$login_table = $_SESSION['login_table'];
$pdo = connectDb();
$user_id = $user['id'];

$sql = 'UPDATE login_table SET last_action_time = now()
WHERE table_number = :table_number and user_id  = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':table_number', $login_table, PDO::PARAM_STR);
$stmt->bindValue(':user_id',$user_id, PDO::PARAM_STR);
$stmt->execute();
unset($pdo);

// order.phpに画面遷移する。
header('Location: '.SITE_URL.'order_complete.php');

?>
