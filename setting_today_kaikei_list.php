<?php

require_once('config.php');
require_once('functions.php');

session_start();
$pdo = connectDb();

$today= date('Y-m-d');;

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}

$user = $_SESSION['tablet_order_system_setting'];

$message="本日お会計履歴はありません。";



// 当日のお会計リストを取得
$today_okaikei_list = array();
$sql = "select * from okaikei where user_id = :user_id  and`order_date`like :query ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->bindValue(':query', '%'.$today.'%', PDO::PARAM_STR);
$stmt->execute();
foreach ($stmt->fetchAll() as $row) {
    array_push($today_okaikei_list, $row);
}

?>



<!DOCTYPE html>

<html lang="ja">

    <head>

        <meta http-equiv="refresh" content="30; URL="https://tablet-order-system.com/setting_today_kaikei_list.php>

        <title>今日のお会計 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>


        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            .list-group-item{
            font-size:15px;
            }

            }

            @media screen and (max-width: 414px) {

            h1{
            font-size:26px;
            }

            .list-group-item{
            font-size:11px;
            }

            }

        </style>

    </head>



    <body id="main">
        <?php include("./common_header_setting.php"); ?>
        <div class="container-fluid">

            <h1>今日のお会計</h1>
            <p>最新のお会計情報から順に表示されます。<br>金額は税込です。画面は30秒毎に最新の情報に更新されます。
            </p>
            <hr>

            <div class="row">
                  <div class="panel-body">

                      <?php if (!$today_okaikei_list): ?>
                          <div class="alert alert-info">
                              <?php echo h($message); ?>
                          </div>
                      <?php endif; ?>

                      <?php if ($today_okaikei_list): ?>
                          <?php foreach ($today_okaikei_list as $item): ?>
                              <li class="list-group-item">
                                  <?php echo h($item['order_date']); ?> ：テーブル<?php echo h($item['order_table']); ?> ：<?php echo h(number_format($item['price'])); ?>円
                              </li>
                          <?php endforeach; ?><br>
                      <?php endif; ?>

                  </div>
            </div><!--/row-->

            <hr>

            <?php include("./common_footer.php"); ?>

        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
