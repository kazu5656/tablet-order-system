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

//過去1年の年月を取得
$year_month[0] = date('Y-m', strtotime('-11 month', time()));;
$year_month[1] = date('Y-m', strtotime('-10 month', time()));;
$year_month[2]  = date('Y-m', strtotime('-9 month', time()));;
$year_month[3]  = date('Y-m', strtotime('-8 month', time()));;
$year_month[4]  = date('Y-m', strtotime('-7 month', time()));;
$year_month[5]  = date('Y-m', strtotime('-6 month', time()));;
$year_month[6]  = date('Y-m', strtotime('-5 month', time()));;
$year_month[7]  = date('Y-m', strtotime('-4 month', time()));;
$year_month[8]  = date('Y-m', strtotime('-3 month', time()));;
$year_month[9]  = date('Y-m', strtotime('-2 month', time()));;
$year_month[10]  = date('Y-m', strtotime('-1 month', time()));;
$year_month[11]  = date('Y-m');

//29-31日に検索した場合、2月が3月と表記されてしまうことへの対策
for ($i = 0; $i <= 11; $i=$i+1){
    $s = $i+1;
    // 3月が２つ存在する場合
    if($year_month[$i] == $year_month[$s]){
        $march=$year_month[$s];
        // 一つ目の3月を2月に変更する
        $year_month[$i] = date('Y-m',strtotime($march . "-1 m"));
    }
}

//12ヵ月分の毎月の売上を$monthly_uriage_listに入れる
for ($i = 0; $i <= 11; $i=$i+1){
    $sql = "SELECT
        sum(price*count) as monthly_uriage,
        SUBSTRING(order_date FROM 1 FOR 7) AS order_date
        FROM
        order_record
        where user_id = :user_id  and `order_date`like :query";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':query', '%'.$year_month[$i].'%', PDO::PARAM_STR);
    $stmt->execute();
    $monthly_uriage_list = $stmt->fetch();

    if($monthly_uriage_list[0]==null){

    }else{
        $m[]=$monthly_uriage_list;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

    <head>

        <title>月次売上メニュー | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <!-- 月次売上グラフ -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['月', '月の総売上'],

            <?php foreach ($m as $monthly_uriage_list2): ?>
            ["<?php echo h($monthly_uriage_list2[1]) ?>",
            <?php echo h($monthly_uriage_list2[0]) ?>],
            <?php endforeach; ?>
            ]);

              var options = {
            title: '売上月次推移グラフ',
            curveType: 'streight',
            chartArea:{top:60,left:95,width:"90%",height:"60%"},
            vAxis:{maxValue:100000,minValue:80},
            legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
            }
        </script>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            }

            @media screen and (max-width: 414px) {

            h1{
            font-size:26px;
            }

            }/* smax-width: 414px*/

        </style>

    </head>



    <body id="main">

        <?php include("./common_header_setting.php"); ?>

        <div class="container-fluid">
            <h1>月次売上</h1>
            <hr>
            <div class="row">
            <div id="curve_chart" style="width: 100%; height: 800px" ></div>
            </div><!--/row-->
            <hr>

            <?php include("./common_footer.php"); ?>
        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
