<?php

require_once('config.php');
require_once('functions.php');


$pdo = connectDb();

//７日間の無料体験が終わったユーザーを取得
$seven_days_ago = date('Y-m-d', strtotime("-14 day", time()));
$sql = "SELECT * FROM user WHERE experience = :experience and`created_at`like :query";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':experience','体験', PDO::PARAM_STR);
$stmt->bindValue(':query', '%'.$seven_days_ago.'%', PDO::PARAM_STR);
$stmt->execute();
$delete_target_experience_user = $stmt->fetchall();


//７日間の無料体験が終わったユーザーの数を取得
$user_count = count($delete_target_experience_user);


for ($n = 0; $n <= $user_count-1; $n=$n+1){

    $user_id = $delete_target_experience_user[$n]['id'];
    $user_file = $delete_target_experience_user[$n]['photo_directory'];
    $user_name = $delete_target_experience_user[$n]['user_name'];
    $user_email = $delete_target_experience_user[$n]['user_email'];

    // 差出人
    $mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

    // 管理者にメールを送信"
    mb_language("japanese");
    mb_internal_encoding("UTF-8");
    $mail_title = '無料体験ユーザーデータ消去のお知らせ';
    $mail_body = '氏名：'.$user_name.PHP_EOL;
    $mail_body.= 'メールアドレス：'.$user_email;
    mb_send_mail(kazu_mail, $mail_title, $mail_body, $mailfrom);

    // 登録完了メールを送信"
    mb_language("japanese");
    mb_internal_encoding("UTF-8");
    $mail_title = '無料体験ユーザーデータ消去のお知らせ';
    $mail_body = $user_name. ' 様'.PHP_EOL.PHP_EOL;
    $mail_body.= 'この度は【TABLET ORDER SYSTEM】を無料体験していただきまして、ありがとうございました。'.PHP_EOL.PHP_EOL;
    $mail_body.= '無料体験のユーザーデータを消去しましたのでお知らせしました。'.PHP_EOL.PHP_EOL;
    $mail_body.= 'また機会がありましたらよろしくお願い致します。'.PHP_EOL.PHP_EOL;
    $mail_body.= 'ホームページ:https://tablet-order-system.com/';
    mb_send_mail($user_email, $mail_title, $mail_body, $mailfrom);



    $items0 = array();
    $sql0 = "select * from food where user_id = :user_id";
    $stmt0 = $pdo->prepare($sql0);
    $stmt0->execute(array(":user_id" => $user_id));
    foreach ($stmt0->fetchAll() as $row0) {
        array_push($items0, $row0);
    }

    foreach ($items0 as $file0) {
        unlink("/var/app/tablet_order_system/web/images/test/$user_file/$file0[image_name]");
    }


    $items = array();
    $sql = "select * from user where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":id" => $user_id));
    foreach ($stmt->fetchAll() as $row) {
        array_push($items, $row);
    }

    foreach ($items as $file) {
        unlink("/var/app/tablet_order_system/web/images/test/$user_file/thank_you/$file[image_name]");
    }

    // フォルダを削除する。
    rmdir("/var/app/tablet_order_system/web/images/test/$user_file/thank_you");
    rmdir("/var/app/tablet_order_system/web/images/test/$user_file");


    //user
    $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
    $stmt->bindValue(':id',$user_id, PDO::PARAM_INT);
    $flag = $stmt->execute();

    //group_setting
    $stmt1 = $pdo->prepare("DELETE FROM group_setting WHERE user_id = :user_id");
    $stmt1->bindValue(':user_id',$user_id, PDO::PARAM_INT);
    $flag1 = $stmt1->execute();

    //order_record
    $stmt2 = $pdo->prepare("DELETE FROM order_record WHERE user_id = :user_id");
    $stmt2->bindValue(':user_id',$user_id, PDO::PARAM_INT);
    $flag2 = $stmt2->execute();

    //food
    $stmt3 = $pdo->prepare("DELETE FROM food WHERE user_id = :user_id");
    $stmt3->bindValue(':user_id',$user_id, PDO::PARAM_INT);
    $flag3 = $stmt3->execute();

    //login_table
    $stmt4 = $pdo->prepare("DELETE FROM login_table WHERE user_id = :user_id");
    $stmt4->bindValue(':user_id',$user_id, PDO::PARAM_INT);
    $flag4 = $stmt4->execute();

    //okaikei
    $stmt5 = $pdo->prepare("DELETE FROM okaikei WHERE user_id = :user_id");
    $stmt5->bindValue(':user_id',$user_id, PDO::PARAM_INT);
    $flag5 = $stmt5->execute();

}






unset($pdo);


exit;
?>
