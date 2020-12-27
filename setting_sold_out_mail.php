<?php

require_once('config.php');
require_once('functions.php');

session_start();
$pdo = connectDb();



// 売り切れメニューがあるユーザーIDリストを取得
$sold_out_list = array();
$sql = "select user_id from food where sold_out = :sold_out GROUP BY user_id ORDER BY user_id ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':sold_out','売り切れ', PDO::PARAM_STR);
$stmt->execute();
$sold_out_list = $stmt->fetchall();
$cnt = count($sold_out_list);


for ($i = 0; $i <= $cnt-1; $i=$i+1){

    $user_sold_out = array();
    $sql2 = "select * from user where id = :id";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindValue(':id',$sold_out_list[$i]['user_id'], PDO::PARAM_STR);
    $stmt2->execute();
    $user_sold_out = $stmt2->fetchall();

    $address = $user_sold_out[0]['user_email'];
    $user_name = $user_sold_out[0]['user_name'];

    $sold_out_food_list = array();
    $sql3 = "select food_name from food where sold_out = :sold_out and user_id = :user_id ORDER BY group_id ASC";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->bindValue(':sold_out','売り切れ', PDO::PARAM_STR);
    $stmt3->bindValue(':user_id',$sold_out_list[$i]['user_id'], PDO::PARAM_STR);
    $stmt3->execute();
    $sold_out_food_list = $stmt3->fetchall();

    // 差出人
    $mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

    // 管理者にメールを送信"
    mb_language("japanese");
    mb_internal_encoding("UTF-8");
    $mail_title = 'TABLET ORDER SYSTEM【'.$user_name.'様】現在、売り切れのメニューがあります。';
    $mail_body = $user_name.'様'.PHP_EOL;
    $mail_body.= 'お世話になっております。'.PHP_EOL.PHP_EOL;
    $mail_body.= '現在、売り切れ状態になっているメニューがありますので、対応（売り切れ状態の解除、食材の準備など）をよろしくお願いいたします。'.PHP_EOL.PHP_EOL;

    $mail_body.= '※「設定メニュー」の「売り切れ」で一覧が表示されますので売り切れ状態を解除して下さい。'.PHP_EOL.PHP_EOL;
    $mail_body.= '設定メニュー:https://tablet-order-system.com/login_setting.php'.PHP_EOL.PHP_EOL;


    $mail_body.= '売り切れているメニュー'.PHP_EOL;
    $mail_body.= '（最大20メニューまで表示します）'.PHP_EOL;
    $mail_body.= $sold_out_food_list['0']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['1']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['2']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['3']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['4']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['5']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['6']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['7']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['8']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['9']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['10']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['11']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['12']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['13']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['14']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['15']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['16']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['17']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['18']['food_name'].PHP_EOL;
    $mail_body.= $sold_out_food_list['19']['food_name'];

    mb_send_mail($address, $mail_title, $mail_body, $mailfrom);


}




unset($pdo);




?>
