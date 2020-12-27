<?php

require_once('config.php');
require_once('functions.php');

session_start();
$pdo = connectDb();

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}
$today= date('Y-m-d');;
$user = $_SESSION['tablet_order_system_setting'];

// グループリストを取得
$group_list = array();
$sql = "select * from group_setting where user_id = :user_id ORDER BY group_id ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
foreach ($stmt->fetchAll() as $row) {
    array_push($group_list, $row);
}

//テーブル別の未対応注文リストを取得
for ($n = 1; $n <= 60; $n=$n+1){
    ${'order'.$n} =array();
    $sql = "select * from order_record
    where user_id = :user_id and`order_date`like :query
    and order_table = :order_table and taiou = :taiou
    ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':order_table',$n, PDO::PARAM_INT);
    $stmt->bindValue(':query', '%'.$today.'%', PDO::PARAM_STR);
    $stmt->bindValue(':taiou','未対応', PDO::PARAM_STR);
    $stmt->execute();
    ${'order'.$n} = $stmt->fetchall();
}


//今日の呼び出し記録を取得
for ($n = 1; $n <= 60; $n=$n+1){
    $staff_call = array();
    $sql2 = "select order_table from staff_call
            where user_id = :user_id and`order_date`like :query and order_table = :order_table";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt2->bindValue(':query', '%'.$today.'%', PDO::PARAM_STR);
    $stmt2->bindValue(':order_table', $n, PDO::PARAM_STR);
    $stmt2->execute();
    $staff_call = $stmt2->fetch();
    if($staff_call){
        $order_table[$n]=$n;
    }
}



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();

} else {

    // CSRF対策↓
    checkToken();

    unset($pdo);

}

?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <meta http-equiv="refresh" content="30; URL=https://tablet-order-system.com/setting_today_table_order_list.php">
        <meta charset="utf-8">
        <title>テーブル別未対応注文リスト | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            h3{
            font-size: 27px;
            }

            p{
            font-size:15px;
            }

            .row{
            padding: 2px;
            }

            .list-group{
            font-size: 12px;
            margin-bottom: 0px;
            }

            .list-group-item{
            font-size: 12px;
            margin-top: 0px;
            }

            .btn-default{
            font-size:12px;
            }

            .btn-info{
            font-size:12px;
            }

            .nav-pills{
            font-size: 18px;
            }

            }

            @media screen and (max-width: 414px) {

            h1{
            font-size:26px;
            }

            p{
            font-size:9px;
            }

            h3{
            font-size:20px;
            }

            .row{
            padding: 2px;
            }

            .list-group{
            font-size: 12px;
            margin-bottom: 0px;
            }

            .list-group-item{
            font-size: 14px;
            margin-top: 0px;
            }

            .btn-default{
            font-size:10px;
            padding-left: 3px;
            }

            .btn-info{
            font-size:10px;
            padding-left: 3px;
            }

            .nav-pills{
            font-size: 18px;
            }

            }

        </style>

    </head>



    <body id="main">

        <?php include("./common_header_setting.php"); ?>
        <div class="container-fluid">

        <h1>今日の注文</h1>
        <p><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#今日の注文を確認する"target="_blank">→今日の注文を確認する方法をビデオで見る。</a></p>

        <ul class="nav nav-pills nav-justified">
                <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_today_order.php'|| basename($_SERVER['SCRIPT_NAME']) == 'setting_today_order.php') echo "class=\"active\"" ?>role="presentation"><a href="setting_today_order.php" class="nav-pills">今日の注文一覧</a></li>
                <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_today_table_order_list.php'|| basename($_SERVER['SCRIPT_NAME']) == 'setting_today_table_order_list.php') echo "class=\"active\"" ?>role="presentation"><a href="setting_today_table_order_list.php"class="nav-pills">テーブル別未対応注文リスト</a></li>
        </ul>

         <hr id ="hr">



        <h3>お客様からの呼び出し</h3>
                    <p>お客様から呼び出しのあるテーブル番号は青色に変わります。呼び出しに対応後、テーブル番号をクリックすると白色に変わります。</p>

            <div class="row">
                  <div class="col-md-12">

                    <div class="btn-group btn-group-justified" role="group" id="group_list1">
                        <?php for($i = 1; $i <= 15; $i=$i+1):?>
                        <a href="setting_staff_call_taiouzumi2.php?id=<?php echo "$i"?>)"
        											<?php if ($order_table[$i]):?>
        											    <?php echo "class=\"btn btn-info\""?>
        											<?php else: ?>
        											    <?php  echo "class=\"btn btn-default\"" ?>
        											<?php endif; ?>
        										role="button"><?php echo "$i"?></a>
        			          <?php endfor ;?>
        		        </div>

        		  <div class="btn-group btn-group-justified" role="group" id="group_list1">
        		  <?php for($i = 16; $i <= 30; $i=$i+1):?>
                    <a href="setting_staff_call_taiouzumi2.php?id=<?php echo "$i"?> "
        										<?php if ($order_table[$i]):?>
        										    <?php echo "class=\"btn btn-info\""?>
        										<?php else: ?>
        										    <?php  echo "class=\"btn btn-default\"" ?>
        										<?php endif; ?>
        									role="button"><?php echo "$i"?></a>
        		  <?php endfor ;?>
        		  </div>

              <div class="btn-group btn-group-justified" role="group" id="group_list1">
        		  <?php for($i = 31; $i <= 45; $i=$i+1):?>
                    <a href="setting_staff_call_taiouzumi2.php?id=<?php echo "$i"?> "
        										<?php if ($order_table[$i]):?>
        										    <?php echo "class=\"btn btn-info\""?>
        										<?php else: ?>
        										    <?php  echo "class=\"btn btn-default\"" ?>
        										<?php endif; ?>
        									role="button"><?php echo "$i"?></a>
        		  <?php endfor ;?>
        		  </div>

              <div class="btn-group btn-group-justified" role="group" id="group_list1">
        		  <?php for($i = 46; $i <= 60; $i=$i+1):?>
                    <a href="setting_staff_call_taiouzumi2.php?id=<?php echo "$i"?> "
        										<?php if ($order_table[$i]):?>
        										    <?php echo "class=\"btn btn-info\""?>
        										<?php else: ?>
        										    <?php  echo "class=\"btn btn-default\"" ?>
        										<?php endif; ?>
        									role="button"><?php echo "$i"?></a>
        		  <?php endfor ;?>
        		  </div>

        		</div><!--/col-md-12-->
        </div><!--/row-->


        <h3>テーブル別未対応注文リスト</h3>
                    <p>未対応の注文リストをテーブル別に表示しています。注文後、10分以上経過して未対応の場合は<span class="label label-danger">10分経過</span>と表示されます。<span class="label label-success">対応</span>ボタンを押すとリストから削除されます。</p>


        <div class="row">
            <?php for($n = 1; $n <= 4; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 5; $n <= 8; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 9; $n <= 12; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 13; $n <= 16; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 17; $n <= 20; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 21; $n <= 24; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 25; $n <= 28; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 29; $n <= 32; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 33; $n <= 36; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 37; $n <= 40; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 41; $n <= 44; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 45; $n <= 48; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 49; $n <= 52; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 53; $n <= 56; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->

        <div class="row">
            <?php for($n = 57; $n <= 60; $n=$n+1):?>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-info" class="テーブル" >テーブル<?php echo h($n); ?></a>
                    </div>

                    <?php foreach ((array)${'order'.$n} as $item): ?>
                        <?php  if (((strtotime('now') - strtotime($item['order_date']))/60) > 10):?>
                            <?php  $minite= '10分経過';?>
                            <li class="list-group-item" >
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <span class="label label-danger"><?php echo h($minite); ?> </span>
                            </li>
                        <?php else: ?>
                            <?php  $minite= '';?>
                            <li   class="list-group-item">
                                <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                <a href="setting_today_order_taiouzumi2.php?id=<?php echo h($item['id']); ?>"><span class="label label-success">対応</span></a> <?php echo h($minite); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/col-md-3-->
            <?php endfor ;?>
        </div><!--/row-->


        <hr>
        <?php include("./common_footer.php"); ?>
        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
