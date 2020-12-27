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

//今日の日付を取得
$today= date('Y-m-d');;

//今日の注文を取得

$sql = "select * from order_record where user_id = :user_id and`order_date`like :query
            ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->bindValue(':query', '%'.$today.'%', PDO::PARAM_STR);
$stmt->execute();


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



if($_GET['id']){
		$id = $_GET['id'];
}


?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <meta http-equiv="refresh" content="30; URL=https://tablet-order-system.com/setting_today_order.php">
        <title><?php echo $id; ?>今日の注文一覧 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            p{
            font-size:15px;
            }

            #罫線{
            margin-bottom: 0px;
            }

            #お客様からの呼び出し{
            margin-top: 0px;
            }


            h3{
            font-size:28px;
            }

            .btn-default{
            font-size:12px;
            }

            .btn-info{
            font-size:12px;
            }

            table{
            font-size:18px;
            }

            .テーブル項目{
            color: white;
            text-align:center;
            font-size:18px;
            background-color: #3d50d1;
            }

            .order_time{
            width: 25%;

            }

            .order_table{
            width: 15%;

            }

            .food_name{
            width: 30%;

            }

            .order_taiou_button{
            width: 15%;

            }

            .taiouzumi{
            width: 15%;

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
            font-size:12px;
            }

            h3{
            font-size:20px;
            }


            .btn-default{
            font-size:10px;
            padding-left: 3px;
            }

            .btn-info{
            font-size:10px;
            padding-left: 3px;
            }

            table{
            font-size:8px;
            }

            .テーブル項目{
            color: white;
            text-align:center;
            font-size:10px;
            background-color: #3d50d1;
            }

            .order_time{
            width: 25%;
            font-size:8px;
            }

            .order_table{
            width: 15%;
            font-size:8px;
            }

            .food_name{
            width: 30%;
            font-size:8px;
            }

            .order_taiou_button{
            width: 15%;
            font-size:8px;
            }

            .taiouzumi{
            width: 15%;
            font-size:9px;
            }

            .nav-pills{
            font-size: 18px;
            }


            }/* smax-width: 414px*/

        </style>

    </head>


    <body id="main">
          <?php include("./common_header_setting.php"); ?>
          <div class="container-fluid">

              <h1>今日の注文</h1>
              <p><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#今日の注文を確認する"target="_blank">→今日の注文を確認する方法をビデオで見る。</a></p>

              <ul class="nav nav-pills nav-justified">
                  <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_today_order.php'|| basename($_SERVER['SCRIPT_NAME']) == 'setting_today_order.php') echo "class=\"active\"" ?>role="presentation"><a href="setting_today_order.php"class="nav-pills">今日の注文一覧</a></li>
                  <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_today_table_order_list.php'|| basename($_SERVER['SCRIPT_NAME']) == 'setting_today_table_order_list.php') echo "class=\"active\"" ?>role="presentation"><a href="setting_today_table_order_list.php"class="nav-pills">テーブル別未対応注文リスト</a></li>
              </ul>

              <hr id="罫線">

              <div class="row">
                  <div class="panel-body">

                      <h3 id="お客様からの呼び出し">お客様からの呼び出し</h3>
                      <p>お客様から呼び出しのあるテーブル番号は青色に変わります。呼び出しに対応後、テーブル番号をクリックすると白色に変わります。</p>

                      <div class="row">
                          <div class="col-md-12">

                            <div class="btn-group btn-group-justified" role="group" id="group_list1">
                                <?php for($i = 1; $i <= 15; $i=$i+1):?>
                                    <a href="setting_staff_call_taiouzumi.php?id=<?php echo "$i"?>)"
                  											<?php if ($order_table[$i]):?>
                  											    <?php echo "class=\"btn btn-info\""?>
                  											<?php else: ?>
                  											    <?php  echo "class=\"btn btn-default\"" ?>
                  											<?php endif; ?>
                    										role="button"><?php echo "$i"?>
                                    </a>
                			          <?php endfor ;?>
                		        </div>

                      		  <div class="btn-group btn-group-justified" role="group" id="group_list1">
                          		  <?php for($i = 16; $i <= 30; $i=$i+1):?>
                                    <a href="setting_staff_call_taiouzumi.php?id=<?php echo "$i"?> "
                    										<?php if ($order_table[$i]):?>
                    										    <?php echo "class=\"btn btn-info\""?>
                    										<?php else: ?>
                    										    <?php  echo "class=\"btn btn-default\"" ?>
                    										<?php endif; ?>
                      									role="button"><?php echo "$i"?>
                                    </a>
                          		  <?php endfor ;?>
                      		  </div>

                            <div class="btn-group btn-group-justified" role="group" id="group_list1">
                          		  <?php for($i = 31; $i <= 45; $i=$i+1):?>
                                    <a href="setting_staff_call_taiouzumi.php?id=<?php echo "$i"?> "
                    										<?php if ($order_table[$i]):?>
                        										<?php echo "class=\"btn btn-info\""?>
                    										<?php else: ?>
                        										<?php  echo "class=\"btn btn-default\"" ?>
                    										<?php endif; ?>
                      									role="button"><?php echo "$i"?>
                                    </a>
                          		  <?php endfor ;?>
                      		  </div>


                            <div class="btn-group btn-group-justified" role="group" id="group_list1">
                          		  <?php for($i = 46; $i <= 60; $i=$i+1):?>
                                    <a href="setting_staff_call_taiouzumi.php?id=<?php echo "$i"?> "
                    										<?php if ($order_table[$i]):?>
                    										    <?php echo "class=\"btn btn-info\""?>
                    										<?php else: ?>
                    										    <?php  echo "class=\"btn btn-default\"" ?>
                    										<?php endif; ?>
                      									role="button"><?php echo "$i"?>
                                    </a>
                          		  <?php endfor ;?>
                      		  </div>

                      		</div><!--/col-md-12-->
                      </div><!--/row-->

                      <h3>今日の注文一覧</h3>
                      <p>「対応」ボタンを押すと「状況」の項目に「対応済」と表示されます。画面は30秒毎に最新の情報に更新されます。最新の注文が表の上部に表示されます。</p>

                      <table width="100%" border="1" >
                          <tr class="テーブル項目">
                              <th class="order_time">日時</th>
                              <th class="order_table">テーブル</th>
                              <th class="food_name">メニュー</th>
                              <th class="order_taiou_button">対応ボタン</th>
                              <th class="taiouzumi">状況</th>
                          </tr>

                          <?php
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                  if($row['taiou']=='対応済'){
                                      $taiou='対応済';
                                  }else{
                                      $taiou='';
                                  }
                                  echo "<tr>";
                                      echo "<td>".h($row['order_date'])."</td>";
                                      echo "<td>".h($row['order_table'])."</td>";
                                      echo "<td>".h($row['food_name'])."</td>";
                                      echo "<td><a href=\"setting_today_order_taiouzumi.php?id=".h($row['id'])."\">[対応]</a></td>";
                                      echo "<td>".h($taiou)."</td>";
                                  echo "</tr>";
                                }
                              unset($pdo);
                          ?>
                      </table>

                  </div><!--/panel-body-->
              </div><!--/row-->
              <hr>

          <?php include("./common_footer.php"); ?>
          </div><!--/.container-->
          <?php include("./script.php"); ?>

    </body>



</html>
