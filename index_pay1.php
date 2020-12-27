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
        <title>お支払い前ページ| <?php echo SERVICE_NAME; ?></title>

        <!-- favicon -->
        <link rel="icon" href="images/tablet_order_system_favicon.ico">


        <!-- plugins -->
        <link rel="stylesheet" href="templates/css/plugins.css" />

        <!-- search css -->
        <link rel="stylesheet" href="search/search.css" />


        <!-- custom css -->
        <link href="templates/css/styles.css" rel="stylesheet" id="colors">

        <!-- validationEngine -->
        <link rel="stylesheet" href="./css/validationEngine.jquery.css">

        <!-- analyticsの読み込み -->
        <?php include("./analytics.php"); ?>


        <style>

            #背景色{
            background-color: #e6e8ff;
            }


            .footer-bar {
            padding-top: 20px;
            padding-bottom: 20px;
            margin-top: 10px;
            margin-bottom: 0;
            text-align: center;
            background: #191919;
            color: #939393;
            }

            #受講価格{
            color: red;
            text-align: left;
            font-weight: bold;
            font-size: 22px;
            }

            #サービス名{
            color: black;
            text-align: left;
            font-weight: bold;
            font-size: 32px;
            }

            #講座を受講する{
            color: white;
            font-weight: bold;
            font-size: 22px;
            }

            h3{
            text-align: center;
            margin-top: 40px;
            margin-bottom: 0px;
            font-size: 22px;
            font-weight: bold;
            }

            h1{
            font-weight: bold;
            font-size: 28px;
            }

            h2{
            color: white;
            font-weight: bold;
            font-size: 34px;
            }

            h4{
            color: white;
            font-weight: bold;
            font-size: 24px;
            }


            #サービス内容{
            color: white;
            font-weight: bold;
            font-size: 16px;
            padding-bottom: 10px;
            margin-bottom: 10px;
            padding-top: 10px;
            margin-top: 10px;
            }

            #サービス内容section{
            height: 200px;
            background-color: black;
            margin: 10px;
            }

            #タイトルsection{
            height: 50px;
            margin-top: 10px;
            }


            #年一括払い{
            font-size: 15px;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            list-style: none;
            }

            #年一括払いgrid1{
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 10px;
            grid-template-rows: 150px;
            }

            #月払い{
            font-size: 35px;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            list-style: none;
            }

            #月払いgrid1{
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            grid-template-rows: 150px;
            }

            #HOMEへ{
            margin-top: 10px;
            width: 100%;
            }

        </style>

    </head>



    <body>

        <?php include("./common_header_index.php"); ?>
        <br><br><br><br><br>

        <!-- start pricing table -->
        <section class="bg-light-gray" id="背景色">
            <div class="container">

                <div class="section-heading">
                    <h1 class="font-weight-600">お支払いページ</h1>
                    <p>PAYPALでお支払いの方は<br class="br-pc" />「今すぐ購入」ボタンを押して下さい。<br>銀行振り込みの場合は<br class="br-pc" />振込先口座にご入金をお願い致します。</p>
                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-12 sm-margin-25px-bottom">
                        <div class="price-table-style3">
                            <div class="price-table-header">
                                <div class="title-item margin-30px-bottom sm-margin-20px-bottom padding-20px-tb sm-padding-15px-tb bg-theme border-radius-5">
                                    <h5>paypal月払い</h5>
                                </div>
                                <h6>1,000円(税抜)</h6>
                                <div class= "item" id="年一括払い">
                                    <form action="https://www.paypal.com/cgi-bin/webscr"target="_blank" method="post" target="_top">
                                        <input type="hidden" name="cmd" value="_s-xclick">
                                        <input type="hidden" name="hosted_button_id" value="2F7NJ2Z9K4TDS">
                                        <input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
                                        <img alt="" border="0" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 sm-margin-25px-bottom">
                          <div class="price-table-style3">
                              <div class="price-table-header">
                                  <div class="title-item margin-30px-bottom sm-margin-20px-bottom padding-20px-tb sm-padding-15px-tb bg-theme border-radius-5">
                                      <h5>paypal年一括払い</h5>
                                  </div>
                                  <h6>10,000円(税抜)</h6>
                                  <div class= "item" id="年一括払い">
                                       <form action="https://www.paypal.com/cgi-bin/webscr"target="_blank" method="post" target="_top">
                                            <input type="hidden" name="cmd" value="_s-xclick">
                                            <input type="hidden" name="hosted_button_id" value="MYBRVDDGV3T38">
                                            <input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
                                            <img alt="" border="3" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-4 col-md-12 sm-margin-25px-bottom">
                            <div class="price-table-style3">
                                <div class="price-table-header">
                                    <div class="title-item margin-30px-bottom sm-margin-20px-bottom padding-20px-tb sm-padding-15px-tb bg-theme border-radius-5">
                                        <h5>銀行振り込み</h5>
                                    </div>
                                    <h6>振込先口座</h6>
                                    <p>福岡銀行 金田支店 <br>（普）1325621<br>名義 佐竹和明<br><br></p>
                                </div>
                            </div>
                      </div>

                      <div class="col-md-12">
                          <a href="index.php" class="btn btn-primary" role="button" id="HOMEへ">
            								HOMEへ
            							</a>
                      </div>

                </div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end pricing table -->


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
