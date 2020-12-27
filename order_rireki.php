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
$user_file = $user['user_email'];
define( "FILE_DIR", "images/test/$user_file/");

$id = $_GET['id'];
$_SESSION['id'] = $_GET['id'];

$sum_price = 0;
for ($i = 0; $i <= 500; $i=$i+1){
    $sum_price = $sum_price+$_SESSION['order_kakutei'][$i]['8'];
}

$sum_price_tax = $sum_price*(1+TAX);

$sum_price= number_format($sum_price);
$sum_price_tax= number_format($sum_price_tax);


?>




<!DOCTYPE html>
<html lang="ja">

    <head>

        <!-- metas -->
        <meta charset="utf-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
        <meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。">

        <!-- title  -->
        <title>注文履歴| <?php echo SERVICE_NAME; ?></title>

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

            #注文ページに戻る{
            margin-top: 10px;
            font-size:16px;
            font-weight: bold;
            }

            #お会計{
            font-size:16px;
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
                <h1>注文履歴</h1>
            </div>

            <!-- start advice section -->
            <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">

                            <?php foreach ((array)$_SESSION['order_kakutei'] as $item): ?>
                                <li  id="注文内容" class="list-group-item">
                                    <?php echo h($item['food_name']); ?>:<?php echo h($item['price']); ?>円
                                </li>
                            <?php endforeach; ?>

                            <div class="list-group">
                                <a id="合計金額"class="list-group-item list-group-item-info" >合計金額 <?php echo h($sum_price); ?>円(税抜）</a>
                                <a id="税込金額"class="list-group-item list-group-item-success" >合計金額 <?php echo h($sum_price_tax); ?>円(税込）</a>
                            </div>

                            <a id="注文ページに戻る" href="order.php" class="btn btn-success btn-block" role="button" >注文ページに戻る</a>
                            <a href="javascript:void(0);" onclick="var ok=confirm('お会計しても宜しいですか ?'); if (ok) location.href='order_kaikeisyori.php'; return false;"class="btn btn-info btn-block" role="button" id="お会計" >お会計</a>
                            <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />

                        </div><!-- col-md-12 -->

                    </div><!-- row -->
                </div><!-- container text-center -->
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
