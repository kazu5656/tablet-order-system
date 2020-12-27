<?php

require_once('config.php');
require_once('functions.php');

session_start();

// データベースに接続する（PDOを使う）

$pdo = connectDb();

$user = $_SESSION['tablet_order_system_USER'];
$table_number = $_SESSION['login_table'];

$id = $_GET['id'];

if($id){

    $sql = "delete from login_table where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location:'.SITE_URL.'setting_table.php');

}else{

    // DB情報をクリア
    $sql = "delete from login_table where user_id = :user_id and table_number = :table_number";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':table_number', '%'.$table_number.'%', PDO::PARAM_STR);
    $stmt->execute();

    // ログアウト処理
    $_SESSION = array();

    if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/');
    }
    session_destroy();
    unset($pdo);
    header('Location:'.SITE_URL.'login_order.php');

}

?>
