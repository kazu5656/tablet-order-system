<?php

require_once('config.php');
require_once('functions.php');

session_start();

$pdo = connectDb();

?>

<!DOCTYPE html>
<html lang="ja">

    <head>

        <!-- metas -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
        <meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。">

        <!-- title  -->
        <title>新規ユーザー登録完了 | <?php echo SERVICE_NAME; ?></title>

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
            margin-top:40px;
            }

            .footer-bar {
            padding-top: 20px;
            padding-bottom: 20px;
            margin-top: 280px;
            margin-bottom: 0;
            text-align: center;
            background: #191919;
            color: #939393;
            }

            #登録完了メールをご確認下さい。{
            color: white;
            font-weight: bold;
            font-size: 26px;
            }


            #ありがとう{
            color: white;
            font-weight: bold;
            font-size: 26px;
            }

            @media screen and (max-width: 414px) {

            .br-pc { display:none; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:block; }

            h1{
            font-size:26px;
            }

            #登録完了メールをご確認下さい。{
            color: white;
            font-weight: bold;
            font-size: 15px;
            }


            #ありがとう{
            color: white;
            font-weight: bold;
            font-size: 15px;
            }

            }/* smax-width: 414px*/

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
                <h1>新規ユーザー登録完了</h1>
            </div>

            <!-- start advice section -->
            <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 id="ありがとう">TABLET ORDER SYSTEM を<br>ご登録いただきありがとうございます。</h3>
                            <p id="登録完了メールをご確認下さい。">登録完了メールをご確認下さい。</p>
                        </div><!-- col-md-12 -->
                    </div><!-- row -->
                </div><!-- container text-center -->
            </section>
            <!-- end advice section -->

            <!-- start footer section -->
            <footer class="no-padding-top">
                <div class="footer-bar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 text-left xs-text-center xs-margin-5px-bottom">
                            </div>
                            <div class="col-md-6 text-right xs-text-center">
                                <p class="xs-margin-5px-top xs-font-size13"><?php echo COPYRIGHT; ?></p>
                            </div>
                        </div><!-- row -->
                    </div><!-- container -->
                </div><!-- footer-bar -->
            </footer>
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
