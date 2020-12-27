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

//本日から過去10日間の日付を取得
$year_month_today = date('Y-m-d');;
for ($i = 1; $i <= 10; $i=$i+1){
    ${'year_month_today_'.$i} = date('Y-m-d', strtotime("-$i day", time()));;
}


if ($_SERVER['REQUEST_METHOD'] != 'GET') {

   // CSRF対策↓
    checkToken();

} else {

       // CSRF対策↓
    setToken();

    //$_GET['id']があればその日の日付、なければ本日の日付を $search_dayに入れる
    if($_GET['id']){
        $search_day = $_GET['id'];
    }else{
        $search_day = $year_month_today;
    }

      //検索日の売上合計(全メニュー）をだす
    $sql1 = "SELECT SUM(count*price) AS uriage_goukei
        FROM order_record  WHERE user_id = :user_id and`order_date`like :query";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt1->bindValue(':query', '%'.$search_day.'%', PDO::PARAM_STR);
    $stmt1->execute();
    $uriage_goukei = $stmt1->fetch();

    $uriage_goukei['0']=number_format($uriage_goukei['0']);

    //検索日の売上リスト(メニュー別）をだす（円グラフ）
    $sql2 = "SELECT food_id,food_name,price, SUM(count) AS count_sum, price*SUM(count) AS uriage
        FROM order_record  WHERE user_id = :user_id and`order_date`like :query
        GROUP BY food_name,price ORDER BY uriage DESC";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt2->bindValue(':query', '%'.$search_day.'%', PDO::PARAM_STR);
    $stmt2->execute();
    $menu_uriage_list = $stmt2->fetchall();

       //検索月の売上リスト(グループ別）をだす（円グラフ）
    $sql3 ="SELECT
        sum(order_record.price*order_record.count) as uriage,
        group_setting.group_name
        FROM
        group_setting
        JOIN
        order_record
        ON
        order_record.group_id = group_setting.group_id
        and
        order_record.user_id= group_setting.user_id
        where order_record.user_id = :user_id and`order_date`like :query
        GROUP BY group_name
        ORDER BY uriage desc";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt3->bindValue(':query', '%'.$search_day.'%', PDO::PARAM_STR);
    $stmt3->execute();
    $group_uriage_list  = $stmt3->fetchall();



       //検索日の売上リストをだす（表）
    $sql4 = "SELECT food_id,food_name,price, SUM(count) AS count_sum, price*SUM(count) AS uriage
        FROM order_record  WHERE user_id = :user_id and`order_date`like :query
        GROUP BY food_name , price ORDER BY uriage DESC";
    $stmt4 = $pdo->prepare($sql4);
    $stmt4->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt4->bindValue(':query', '%'.$search_day.'%', PDO::PARAM_STR);
    $stmt4->execute();

    unset($pdo);
}


?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>日別メニュー | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <!-- メニュー別円グラフ -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['メニュー', '売り上げ'],
                <?php foreach ($menu_uriage_list as $row2): ?>
                      ["<?php echo h($row2[1]) ?>",   <?php echo h($row2[4]) ?>],
                <?php endforeach; ?>
                     ]);
              var options = {
                title: 'メニュー別 円グラフ(売り上げに対する割合）',
                pieHole: 0.4,
              };

              var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
              chart.draw(data, options);
              }
        </script>

        <!-- グループ別円グラフ -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
          	  var data = google.visualization.arrayToDataTable([
                    ['グループ', '売り上げ'],
                    <?php foreach ($group_uriage_list as $row2): ?>
                    ["<?php echo h($row2[1]) ?>",   <?php echo h($row2[0]) ?>],
                    <?php endforeach; ?>
                         ]);

              var options = {
                title: 'グループ別 円グラフ(売り上げに対する割合）',
                pieHole: 0.4,
              };

              var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
              chart.draw(data, options);
            }
        </script>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            p{
            font-size:15px;
            }

            .btn-default{
            font-size:15px;
            }

            table{
            font-size:15px;
            }

            #uriage_tr1{
            font-size:20px;
            }

            #別メニューとして表示{
            font-size:15px;
            text-align: right;
            }

            #uriage_goukei{
            font-size:20px;
            }

            }



            @media screen and (max-width: 414px) {

            h1{
            font-size:26px;
            }

            p{
            font-size:10px;
            }

            .btn-default{
            font-size:7px;
            }

            table{
            font-size:8px;
            }

            #uriage_tr1{
            font-size:8px;
            }

            #別メニューとして表示{
            font-size:7px;
            text-align: right;
            }

            #uriage_goukei{
            font-size:11px;
            }

            }/* smax-width: 414px*/

        </style>

    </head>


    <body id="main">

      <?php include("./common_header_setting.php"); ?>
      <div class="container-fluid">
          <div class="row">

              <div class="panel-body">
                  <h1>日別データ</h1>
                  <p>過去１０日間の売上記録を見ることができます。</p>
                  <hr>
                  <div class="btn-group btn-group-justified" role="group">
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_9); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_9); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_8); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_8); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_7); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_7); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_6); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_6); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_5); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_5); ?></a>
                  </div>
                  <div class="btn-group btn-group-justified" role="group">
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_4); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_4); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_3); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_3); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_2); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_2); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today_1); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today_1); ?></a>
                    <a href="setting_Sales_day_sales.php?id=<?php echo h($year_month_today); ?>" class="btn btn-default" role="button"><?php echo h($year_month_today); ?></a>
                  </div><br>

                  <?php if ($no_data_message): ?>
                      <div class="alert alert-warning">
                        <?php echo h($no_data_message); ?>
                      </div>
                  <?php endif; ?>

                  <h4> <?php echo h($search_day); ?>の売上データ</h4>

                  <table width="100%" border="1">
                      <tr id="uriage_tr1">
                          <th>メニュー名</th>
                          <th>価格</th>
                          <th>個数</th>
                          <th>売上金額</th>
                      </tr>
                      <?php
                          while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                          echo "<tr>";
                          echo "<td>".h($row['food_name'])."</td>";
                          echo "<td>".h(number_format($row['price']))."</td>";
                          echo "<td>".h($row['count_sum'])."</td>";
                          echo "<td>".h(number_format($row['uriage']))."</td>";
                          echo "</tr>";
                          }
                          unset($pdo);
                      ?>
                      <tr id="uriage_goukei_tr2">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td id="uriage_goukei">合計：<?php echo h($uriage_goukei['0']); ?>円</td>
                      </tr>
                  </table>

                  <br>
                  <p id="別メニューとして表示" >※メニュー名や価格を変更した場合は別メニューとして表示されます。</p>
              </div>

              <div class="row">
                  <div class="col-md-6">
                      <div id="donutchart"></div>
                  </div><!--/col-md-6-->
                  <div class="col-md-6">
                      <div id="donutchart2"></div>
                  </div><!--/col-md-6-->
              </div><!--/row-->

          </div><!--/row-->

        <hr>
        <?php include("./common_footer.php"); ?>

      </div><!--/.container-->
      <?php include("./script.php"); ?>


    </body>



</html>
