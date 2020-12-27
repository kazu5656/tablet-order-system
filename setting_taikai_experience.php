<?php

require_once('config.php');
require_once('functions.php');


$pdo = connectDb();

//７日間の無料体験が終わったユーザーを取得
$seven_days_ago = date('Y-m-d', strtotime("-7 day", time()));
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
    $mail_title = '無料体験を終了したユーザーのお知らせ';
    $mail_body = '氏名：'.$user_name.PHP_EOL;
    $mail_body.= 'メールアドレス：'.$user_email;
    mb_send_mail(kazu_mail, $mail_title, $mail_body, $mailfrom);

    // 登録完了メールを送信"
    mb_language("japanese");
    mb_internal_encoding("UTF-8");
    $mail_title = '無料体験終了のお知らせ';
    $mail_body = $user_name. ' 様'.PHP_EOL.PHP_EOL;
    $mail_body.= 'この度は【TABLET ORDER SYSTEM】を無料体験していただきまして、ありがとうございました。'.PHP_EOL.PHP_EOL;
    $mail_body.= '無料体験期間の１週間を経過しましたのでお知らせしました。'.PHP_EOL.PHP_EOL;
    $mail_body.= '使ってみた感想はいかがでしたでしょうか？'.PHP_EOL.PHP_EOL;
    $mail_body.= 'そのまま新規登録を行いたい場合は下記のリンクからログインしていただき、必要な情報を追加するだけでスムーズに新規登録が可能です。'.PHP_EOL.PHP_EOL;
    $mail_body.= '本日より1週間後にはデータが完全に消去されますので、新規登録を行う場合はお早めにお願い致します。'.PHP_EOL.PHP_EOL;
    $mail_body.= 'ログイン画面:https://tablet-order-system.com/login_account_update.php';
    mb_send_mail($user_email, $mail_title, $mail_body, $mailfrom);


}






unset($pdo);


exit;
?>
