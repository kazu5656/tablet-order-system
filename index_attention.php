
<?php
require_once('config.php');
require_once('functions.php');

session_start();

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
        <title>免責事項について | TABLET ORDER SYSTEM</title>
        <!-- favicon -->
        <link rel="icon" href="images/tablet_order_system_favicon.ico">
        <!-- plugins -->
        <link rel="stylesheet" href="css/plugins.css" />

        <!-- search css -->
        <link rel="stylesheet" href="search/search.css" />
        <!-- custom css -->
        <link href="css/styles.css" rel="stylesheet" id="colors">
        <!-- analyticsの読み込み -->
        <?php include("./analytics.php"); ?>

        <style>

            #問い合わせ_申し込みボタン{
            float: left;
            }
            span.メインタイトル {
            font-size: 42px;
            }
            .アプリ機能_タイトル{
            text-align: center;
            }
            #良くある質問_他サービスとの料金比較表{
            text-align: center;
            }
            #良くある質問_推奨ブラウザ{
            text-align: center;
            }



            @media screen and (max-width: 3000px) {


            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 40px;
            text-align: left;
            }

            #販売者情報{
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 20px;
            }

            h1{
            margin-top: 50px;
            font-weight: bold;
            }



            }
            /*ipad 横幅*/
            @media screen and (max-width: 1024px){


            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 40px;
            }


            }
            /*ipad 縦幅*/
            @media screen and (max-width: 768px){

            .br-メイン用-pc { display:none; }
            .br-メイン用-タブレット長 { display:none; }
            .br-メイン用-タブレット短 { display:block; }
            .br-メイン用-携帯長 { display:none; }
            .br-メイン用-携帯短 { display:none; }

            .br-pc { display:block; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 25px;
            }

            h1{
            margin-top: 80px;
            }


            }

            /*iphone 縦幅(横)*/
            @media screen and (max-width: 736px){

            .br-メイン用-pc { display:none; }
            .br-メイン用-タブレット長 { display:none; }
            .br-メイン用-タブレット短 { display:none; }
            .br-メイン用-携帯長 { display:block; }
            .br-メイン用-携帯短 { display:none; }

            .br-pc { display:none; }
            .br-携帯長 { display:block; }
            .br-携帯短 { display:none; }

            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 24px;
            text-aline: left;
            }

            #各セクション見出し下_説明{
            color: black;
            font-weight: bold;
            font-size: 14px;
            }



            }

            /*iphone 横幅(短)*/
            @media screen and (max-width: 414px){



            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 15px;
            }

            #各セクション見出し下_説明{
            color: black;
            font-weight: bold;
            font-size: 12px;
            }

            h1{
            font-size: 22px;
            font-weight: bold;
            }

            }

        </style>

    </head>



    <body>

        <!-- start main-wrapper section -->
        <div class="main-wrapper">

        <?php include("./common_header_index.php"); ?>
        <!-- end header section -->



        <!-- start セクション１ TABLET ORDER SYSTEM -->
        <section>
            <div class="container">
            <h1>免責事項について</h1>
            <hr>
                <div class="row" >

                    <div class="col-md-9">
                        <p>当サイトへの情報の掲載については注意を払っておりますが、掲載された情報の内容の正確性については一切保証しません。
                        また、当サイトに掲載された情報を利用、使用、ダウンロードするなどの行為に関連して生じたあらゆる損害等についても、理由の如何に関わらず、当社は一切責任を負いません。<br><br>

                        当サイトに掲載されている情報には効果(飲食店の回転率、売上、利益、顧客満足度の向上）に関する情報が含まれている場合がありますが、
                        その内容には個人差や一定のリスクなどが含まれております。<br><br>
                        予告なく当サイトに掲載された情報を変更することがあります。
                        </p>
                    </div><!-- col-md-9 -->

                    <div class="col-md-3">
                        <?php include("./common_info.php"); ?>
                    </div><!-- col-md-3 -->

                </div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end セクション１ TABLET ORDER SYSTEM -->

        <hr>

        <?php include("./common_footer_index.php"); ?>

        </div>
        <!-- end main-wrapper section -->

        <!-- start scroll to top -->
        <a href="javascript:void(0)" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>
        <!-- end scroll to top -->

        <!-- all js include start -->
        <!-- jquery -->
        <script src="js/jquery.min.js"></script>
        <!-- modernizr js -->
        <script src="js/modernizr.js"></script>
        <!-- bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        <!-- navigation -->
        <script src="js/nav-menu.js"></script>
        <!-- serch -->
        <script src="search/search.js"></script>
        <!-- tab -->
        <script src="js/easy.responsive.tabs.js"></script>
        <!-- owl carousel -->
        <script src="js/owl.carousel.js"></script>
        <!-- jquery.counterup.min -->
        <script src="js/jquery.counterup.min.js"></script>
        <!-- stellar js -->
        <script src="js/jquery.stellar.min.js"></script>
        <!-- waypoints js -->
        <script src="js/waypoints.min.js"></script>
        <!-- tab js -->
        <script src="js/tabs.min.js"></script>
        <!-- countdown js -->
        <script src="js/countdown.js"></script>
        <!-- jquery.magnific-popup js -->
        <script src="js/jquery.magnific-popup.min.js"></script>
        <!-- isotope.pkgd.min js -->
        <script src="js/isotope.pkgd.min.js"></script>
        <!--  chart js -->
        <script src="js/chart.min.js"></script>
        <!-- thumbs js -->
        <script src="js/owl.carousel.thumbs.js"></script>
        <!-- animated js -->
        <script src="js/animated-headline.js"></script>
        <!--  clipboard js -->
        <script src="js/clipboard.min.js"></script>
        <!--  prism js -->
        <script src="js/prism.js"></script>

        <!-- map js -->
        <script src="js/map.js"></script>
        <!-- custom scripts -->
        <script src="js/main.js"></script>
        <!-- contact form scripts -->
        <script src="js/mailform/jquery.form.min.js"></script>
        <script src="js/mailform/jquery.rd-mailform.min.c.js"></script>
        <!-- all js include end -->

    </body>



</html>
