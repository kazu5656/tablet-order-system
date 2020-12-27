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
$user_file = $user['photo_directory'];

if (!$user['id']) {
    echo '<html><head><meta charset="utf-8"></head><body>不正なアクセスです。</body></html>';
    exit;
}

// データベースに接続
$pdo = connectDb();
$mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

// 管理者にメールを送信"
mb_language("japanese");
mb_internal_encoding("UTF-8");
$mail_title = '【TABLET ORDER SYSTEM】ユーザーの退会がありました。';
$mail_body = '氏名：'.$user['user_name'].PHP_EOL;
$mail_body.= 'メールアドレス：'.$user['user_email'];
mb_send_mail(kazu_mail, $mail_title, $mail_body, $mailfrom);


mb_language("japanese");
mb_internal_encoding("UTF-8");
$mail_title = '【TABLET ORDER SYSTEM】退会手続きが完了しました。';
$mail_body = $user['user_name']. '様'.PHP_EOL.PHP_EOL;
$mail_body.= '【TABLET ORDER SYSTEM】を'.PHP_EOL.'ご利用いただきまして誠にありがとうございました。'.PHP_EOL;
$mail_body.= 'また機会がありましたらよろしくお願い致します。';
mb_send_mail($user['user_email'], $mail_title, $mail_body, $mailfrom);



$user_logo = array();
$sql = "select * from logo where user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
$user_logo = $stmt->fetch();

$user_logo2 = $user_logo['image_name'];

if($user_logo2){
    unlink("/var/app/tablet_order_system/web/images/test/$user_file/logo/$user_logo2");
}


$items0 = array();
$sql0 = "select * from food where user_id = :user_id";
$stmt0 = $pdo->prepare($sql0);
$stmt0->execute(array(":user_id" => $user['id']));
foreach ($stmt0->fetchAll() as $row0) {
    array_push($items0, $row0);
}

foreach ($items0 as $file0) {
    unlink("/var/app/tablet_order_system/web/images/test/$user_file/$file0[image_name]");
}

$items = array();
$sql = "select * from user where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":id" => $user['id']));
foreach ($stmt->fetchAll() as $row) {
    array_push($items, $row);
}

foreach ($items as $file) {
    unlink("/var/app/tablet_order_system/web/images/test/$user_file/thank_you/$file[image_name]");
}

// フォルダを削除する。
rmdir("/var/app/tablet_order_system/web/images/test/$user_file/logo");
rmdir("/var/app/tablet_order_system/web/images/test/$user_file/thank_you");
rmdir("/var/app/tablet_order_system/web/images/test/$user_file");



//データベースから全データ削除
if ($user['id']) {
    //user
    $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
    $stmt->bindValue(':id',$user['id'], PDO::PARAM_INT);
    $flag = $stmt->execute();

    //group_setting
    $stmt1 = $pdo->prepare("DELETE FROM group_setting WHERE user_id = :user_id");
    $stmt1->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $flag1 = $stmt1->execute();

    //order_record
    $stmt2 = $pdo->prepare("DELETE FROM order_record WHERE user_id = :user_id");
    $stmt2->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $flag2 = $stmt2->execute();

    //food
    $stmt3 = $pdo->prepare("DELETE FROM food WHERE user_id = :user_id");
    $stmt3->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $flag3 = $stmt3->execute();

    //login_table
    $stmt4 = $pdo->prepare("DELETE FROM login_table WHERE user_id = :user_id");
    $stmt4->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $flag4 = $stmt4->execute();

    //okaikei
    $stmt5 = $pdo->prepare("DELETE FROM okaikei WHERE user_id = :user_id");
    $stmt5->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $flag5 = $stmt5->execute();
}

unset($pdo);
header("Location: setting_taikai_complete.php");

exit;
?>
