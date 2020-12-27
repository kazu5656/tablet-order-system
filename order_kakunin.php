<?php

require_once('config.php');
require_once('functions.php');

session_start();
$pdo = connectDb();

if (!isset($_SESSION['tablet_order_system_USER'])) {
    header('Location: '.SITE_URL.'login_order.php');
    exit;
}

$user = $_SESSION['tablet_order_system_USER'];

$login_table = $_SESSION['login_table'];

$id = $_GET['id'];
$_SESSION['id'] = $_GET['id'];

// 注文の合計金額を出す
$sum_price =
$_SESSION['order']['0']['8']+$_SESSION['order']['1']['8']+$_SESSION['order']['2']['8']
+$_SESSION['order']['3']['8']+$_SESSION['order']['4']['8']+$_SESSION['order']['5']['8']
+$_SESSION['order']['6']['8']+$_SESSION['order']['7']['8']+$_SESSION['order']['8']['8']+$_SESSION['order']['9']['8'];



// 合計金額を税込価格にする
$sum_price_tax = $sum_price*(1+TAX);

$sum_price= number_format($sum_price);
$sum_price_tax= number_format($sum_price_tax);


// $_SESSION['order']][$n]があれば$_SESSION['order'][$n]['number']に[$n]を入れる（注文delete時に使用）
for ($n = 0; $n <= 9; $n=$n+1){
    if($_SESSION['order'][$n]){
        $_SESSION['order'][$n]['number']=$n;
    }
}

$order_cnt = count($_SESSION['order']);

if($order_cnt==0){
    header('Location: '.SITE_URL.'order.php');
}



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();


} else {

    // CSRF対策↓
    checkToken();


    for ($n = 0; $n <= 9; $n=$n+1){

        if($_SESSION['order'][$n]==null){
             // 注文内容がなければ何もしない
        }else{
             // 注文内容があればorder_recordテーブルに保存する
              $food_id = $_SESSION['order'][$n]['id'];
              $food_name = $_SESSION['order'][$n]['food_name'];
              $price = str_replace(',','',$_SESSION['order'][$n]['price']);
              $group_id = $_SESSION['order'][$n]['group_id'];

              $_SESSION['order_kakutei'][]=$_SESSION['order'][$n];

              $sql = "insert into order_record
              (user_id,food_id,group_id,food_name,price,count,order_table,order_date,taiou,created_at,updated_at)
              values
              (:user_id,:food_id,:group_id,:food_name,:price,:count,:order_table,:order_date,:taiou, now(), now())";
              $stmt = $pdo->prepare($sql);
              $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
              $stmt->bindValue(':food_id',$food_id, PDO::PARAM_INT);
              $stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
              $stmt->bindValue(':food_name',$food_name, PDO::PARAM_STR);
              $stmt->bindValue(':price',$price, PDO::PARAM_INT);
              $stmt->bindValue(':count','1', PDO::PARAM_INT);
              $stmt->bindValue(':order_table',$login_table, PDO::PARAM_INT);
              $stmt->bindValue(':order_date',date("Y/m/d H:i:s"), PDO::PARAM_STR);
              $stmt->bindValue(':taiou','未対応', PDO::PARAM_STR);
              $stmt->execute();

           // 受注メール用に各メニュー毎の注文数を数える
              $sql2 = "SELECT food_name, SUM(count) AS count_sum
              FROM order_record
              WHERE user_id = :user_id and order_table = :order_table and order_date = :order_date
              GROUP BY food_name";
              $stmt2 = $pdo->prepare($sql2);
              $stmt2->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
              $stmt2->bindValue(':order_table',$login_table, PDO::PARAM_INT);
              $stmt2->bindValue(':order_date',date("Y/m/d H:i:s"), PDO::PARAM_STR);
              $stmt2->execute();
              $record = $stmt2->fetchall();

        }

    }

    if($record){

        // 管理者にメールを送信"
        mb_language("japanese");
        mb_internal_encoding("UTF-8");

        // 差出人
        $mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

        $mail_title = '【'.$login_table.'番テーブル】注文がありました。';

        $mail_body = $login_table.'番テーブル'.PHP_EOL.PHP_EOL;
        $mail_body.= $record['0']['0'].' '.$record['0']['1'].PHP_EOL;
        $mail_body.= $record['1']['0'].' '.$record['1']['1'].PHP_EOL;
        $mail_body.= $record['2']['0'].' '.$record['2']['1'].PHP_EOL;
        $mail_body.= $record['3']['0'].' '.$record['3']['1'].PHP_EOL;
        $mail_body.= $record['4']['0'].' '.$record['4']['1'].PHP_EOL;
        $mail_body.= $record['5']['0'].' '.$record['5']['1'].PHP_EOL;
        $mail_body.= $record['6']['0'].' '.$record['6']['1'].PHP_EOL;
        $mail_body.= $record['7']['0'].' '.$record['7']['1'].PHP_EOL;
        $mail_body.= $record['8']['0'].' '.$record['8']['1'].PHP_EOL;
        $mail_body.= $record['9']['0'].' '.$record['9']['1'];

        mb_send_mail($user['order_pc_email'], $mail_title, $mail_body, $mailfrom);

    }

    $_SESSION['order']= array();
    header('Location: '.SITE_URL.'order.php');
    unset($pdo);


}




?>




<!DOCTYPE html>
<html lang="ja">

    <head>

        <!-- metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
        <meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。">

        <!-- title  -->
        <title>注文確認| <?php echo SERVICE_NAME; ?></title>

        <!-- favicon -->
        <link rel="icon" href="images/tablet_order_system_favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="images/tablet_order_system_favicon.ico">

        <!-- plugins -->
        <link rel="stylesheet" href="templates/css/plugins.css" />

        <!-- search css -->
        <link rel="stylesheet" href="search/search.css" />


        <!-- custom css -->
        <link href="templates/css/styles.css" rel="stylesheet" id="colors">

        <link rel="stylesheet" href="css/validationEngine.jquery.css">

        <!-- analyticsの読み込み -->
        <?php include("./analytics.php"); ?>


        <style>

            .label{
            font-size: 18px;
            font-weight: bold;
            color: white;
            float: left;
            }

            .btn-success{
            font-weight: bold;
            font-size: 20px;
            margin-top:10px;
            }

            .footer-bar {
            padding-top: 20px;
            padding-bottom: 20px;
            margin-top: 110px;
            margin-bottom: 0;
            text-align: center;
            background: white;
            color: black;
            }

            body {
            padding-top: 10px;
            padding-bottom: 10px;
            }


            #合計金額{
            font-size:16px;
            text-align:right;
            color: black;
            font-weight: bold;
            }

            #税込金額{
            font-size:18px;
            text-align:right;
            color: black;
            font-weight: bold;
            }

            #注文内容{
            font-size:20px;
            text-align:left;
            color: black;
            font-weight: bold;
            }


        </style>

    </head>



    <body>

          <!-- start page loading -->
          <div id="preloader">
              <div class="row loader">
                  <div class="loader-icon"></div>
              </div>
          </div>
          <!-- end page loading -->

          <!-- start main-wrapper section -->
          <div class="main-wrapper">



              <!-- start advice section -->
              <div class="section-heading margin-50px-top md-margin-70px-top sm-margin-50px-top">
                  <h1>注文確認</h1>
              </div>

              <!-- start advice section -->
              <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
                  <div class="container text-center">

                  <div class="row">
                      <div class="col-md-12">
                          <form method="POST" class="panel panel-default panel-body">
                              <?php $i=0; ?>
                              <?php foreach ((array)$_SESSION['order'] as $item): ?>
                                  <?php if ($i>=10): ?>
                                      <?php	break;?>
                                  <?php else: ?>
                                      <li  id="注文内容" class="list-group-item">
                                      <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                      <a href="javascript:void(0);" onclick="var ok=confirm('<?php echo h($item['food_name']); ?>を削除しても宜しいですか?'); if (ok) location.href='delete_order.php?id=<?php echo h($item['number']); ?>'; return false;">[削除]</a>
                                      </li>
                                      <?php $i++; ?>
                                  <?php endif; ?>
                              <?php endforeach; ?>

                              <div class="list-group">
                                  <a id="合計金額"class="list-group-item list-group-item-info" >合計金額 <?php echo h($sum_price); ?>円(税抜）</a>
                                  <a  id="税込金額"class="list-group-item list-group-item-success" >合計金額 <?php echo h($sum_price_tax); ?>円(税込）</a>
                              </div>

                              <input id="注文確定" class="btn btn-success btn-block" type="submit" value="注文確定">
                              <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                          </form>
                      </div><!-- col-md-12 -->
                  </div><!-- row -->
                  </div><!-- container -->
              </section>
              <!-- end advice section -->


              <!-- start footer section -->
              <?php include("./common_footer_order.php"); ?>
              <!-- end footer section -->

          </div>
          <!-- end main-wrapper section -->

          <!-- start scroll to top -->
          <a href="javascript:void(0)" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>
          <!-- end scroll to top -->

          <!-- all js include start -->

          <!-- jquery -->
          <script src="templates/js/jquery.min.js"></script>

          <!-- modernizr js -->
          <script src="templates/js/modernizr.js"></script>

          <!-- bootstrap -->
          <script src="templates/js/bootstrap.min.js"></script>

          <!-- navigation -->
          <script src="templates/js/nav-menu.js"></script>

          <!-- serch -->
          <script src="search/search.js"></script>

          <!-- tab -->
          <script src="templates/js/easy.responsive.tabs.js"></script>

          <!-- owl carousel -->
          <script src="templates/js/owl.carousel.js"></script>

          <!-- jquery.counterup.min -->
          <script src="templates/js/jquery.counterup.min.js"></script>

          <!-- stellar js -->
          <script src="templates/js/jquery.stellar.min.js"></script>

          <!-- waypoints js -->
          <script src="templates/js/waypoints.min.js"></script>

          <!-- tab js -->
          <script src="templates/js/tabs.min.js"></script>

          <!-- countdown js -->
          <script src="templates/js/countdown.js"></script>

          <!-- jquery.magnific-popup js -->
          <script src="templates/js/jquery.magnific-popup.min.js"></script>

          <!-- isotope.pkgd.min js -->
          <script src="templates/js/isotope.pkgd.min.js"></script>

          <!--  chart js -->
          <script src="templates/js/chart.min.js"></script>

          <!-- thumbs js -->
          <script src="templates/js/owl.carousel.thumbs.js"></script>

          <!-- animated js -->
          <script src="templates/js/animated-headline.js"></script>

          <!--  clipboard js -->
          <script src="templates/js/clipboard.min.js"></script>

          <!--  prism js -->
          <script src="templates/js/prism.js"></script>

          <!-- map js -->
          <script src="templates/js/map.js"></script>

          <!-- custom scripts -->
          <script src="templates/js/main.js"></script>

          <!-- contact form scripts -->
          <script src="templates/js/mailform/jquery.form.min.js"></script>
          <script src="templates/js/mailform/jquery.rd-mailform.min.c.js"></script>

          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
          <script src="./js/jquery.validationEngine.js"></script>
          <script src="./js/languages/jquery.validationEngine-ja.js"></script>
          <script>
          $(function(){
          $("#demo_form").validationEngine();
          });
          </script>

          <!-- all js include end -->

    </body>



</html>
