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
        <title>プライバシーポリシー | TABLET ORDER SYSTEM</title>
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

            .lead{
            font-size: 16px;
            font-weight: bold;
            }

            }

        </style>

    </head>

    <body>

        <!-- start main-wrapper section -->
        <div class="main-wrapper">

            <?php include("./common_header_index.php"); ?>



            <section>

                <div class="container">
                    <h1>プライバシーポリシー</h1>
                    <hr>

                    <div class="row" >
                        <div class="col-md-9">

                            <p>
                              当社は、個人情報の保護に関する法律（以下「個人情報保護法」といいます）その他関連法令等を遵守し、
                              個人情報保護法第２条第１項によって定義された個人情報を適正に取り扱うことが、重要な社会的責務であるとの認識に立ち、
                              以下の規定に従い、個人情報の適切な取扱い及び保護に努めます。<br><br>
                              本文中の用語の定義は、個人情報保護法及び関連法令によります。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">1　個人情報の利用目的</p>
                            <p>
                              当社は、取得したお客様の個人情報を、以下の目的のために利用します。<br><br>
                              （1）当社のサービスの提供、維持、保護及び改善のため<br>
                              （2）お客様本人の確認、認証サービスのため<br>
                              （3）当社のサービスに関するお問い合わせ等への対応のため<br>
                              （4）ダイレクトメールの発送等、当社や提携会社等の商品及びサービスに関するご案内のため<br>
                              （5）当社のサービスに関する当社の規約、ポリシー等（以下「規約等」といいます）に違反する行為に対する対応のため<br>
                              （6）当社のサービスに関する規約等の変更などを通知するため<br>
                              （7）料金請求のため<br>
                              （8）新商品及びサービスの研究や開発を目的とする市場調査やデータ分析のため<br>
                              （9）その他個人情報取得時に明示した利用目的<br>
                              （10）その他上記利用目的に付随する目的のため<br>
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">2　個人情報利用目的の変更</p>
                            <p>
                              当社は、個人情報の利用目的を、関連性を有すると合理的に認められる範囲内において変更することがあり、変更した場合にはお客様に通知又は公表します。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">3　個人情報の適正な取得</p>
                            <p>
                              当社は、適法かつ適正な手段により個人情報を取得し、偽りその他不正の手段により取得しません。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">4　個人情報の適正管理</p>
                            <p>
                              （1）データ内容の正確性の確保<br>
                              当社は、取得したお客様の個人データにつき、利用目的の達成に必要な範囲内において、正確かつ最新の内容に保つとともに、利用する必要がなくなったときは、当該個人データを消去するよう努めます。<br><br>
                              （2）安全管理措置<br>
                              当社は、お客様の個人データの漏洩、滅失又は毀損の防止その他の安全管理のために必要かつ適切な措置を講じます。
                            </p>
                            <hr>


                            <p class="lead" style="padding-bottom:0;">5　第三者提供</p>
                            <p>
                              当社は、お客様の個人データについて、個人情報保護法その他の法令に基づき開示が認められる場合を除くほか、あらかじめ当該お客様の同意を得ないで、第三者（委託先を除きます）に提供しません。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">6　個人情報の開示</p>
                            <p>
                              当社は、お客様から、個人情報保護法の定めに基づき個人情報の開示を求められたときは、ご本人からのご請求であることを確認の上で、お客様に対し、遅滞なく開示を行います（当該個人情報が存在しないときにはその旨を通知いたします）。ただし、個人情報保護法その他の法令により、当社が開示の義務を負わない場合は、この限りではありません。なお、個人情報の開示につきましては、手数料（1件あたり500円）を頂戴しておりますので、あらかじめご了承ください。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">7　個人情報の訂正等</p>
                            <p>
                              当社は、お客様から、個人情報が真実でないという理由によって、個人情報保護法の定めに基づきその内容の訂正、追加又は削除（以下「訂正等」といいます）を求められた場合には、お客様本人からのご請求であることを確認の上で、利用目的の達成に必要な範囲内において、遅滞なく必要な調査を行い、その結果に基づき、個人情報の内容の訂正等を行い、その旨をお客様に通知します（訂正等を行わない旨の決定をしたときは、お客様に対しその旨を通知いたします）。ただし、個人情報保護法その他の法令により、当社が訂正等の義務を負わない場合は、この限りではありません。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">8　個人情報の利用停止等</p>
                            <p>
                              当社は、お客様から、お客様の個人情報が、あらかじめ公表された利用目的の範囲を超えて取り扱われているという理由又は偽りその他不正の手段により取得されたものであるという理由により、個人情報保護法の定めに基づきその利用の停止又は消去（以下「利用停止等」といいます）を求められた場合において、そのご請求に理由があることが判明した場合には、お客様本人からのご請求であることを確認の上で、遅滞なく個人情報の利用停止等を行い、その旨をお客様に通知します。ただし、個人情報保護法その他の法令により、当社が利用停止等の義務を負わない場合は、この限りではありません。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">9　Cookie（クッキー）その他の技術の利用</p>
                            <p>
                              当社のサービスは、Cookie及びこれに類する技術を利用することがあります。これらの技術は、当社による当社のサービスの利用状況等の把握に役立ち、サービス向上に資するものです。Cookieを無効化されたいお客様は、ウェブブラウザの設定を変更することによりCookieを無効化することができます。ただし、Cookieを無効化すると、当社のサービスの一部の機能をご利用いただけなくなる場合があります。
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">10　お問い合わせ</p>
                            <p>
                              開示等のお申出、ご意見、ご質問、苦情のお申出その他個人情報の取扱いに関するお問い合わせは、下記の窓口までお願い致します。<br><br>
                            <a href="https://tablet-order-system.com/index_query.php" target="_blank">お問い合わせフォーム</a>
                            </p>
                            <hr>

                            <p class="lead" style="padding-bottom:0;">11　継続的改善</p>
                            <p>
                              当社は、個人情報の取扱いに関する運用状況を適宜見直し、継続的な改善に努めるものとし、必要に応じて、本方針を変更することがあります。
                            </p>
                            <hr>

                        </div><!-- col-md-9 -->

                        <div class="col-md-3">
                            <?php include("./common_info.php"); ?>
                        </div><!-- col-md-3 -->

                    </div><!-- row -->
                </div><!-- container -->

            </section>


            <hr>

            <!-- start footer section -->
            <?php include("./common_footer_index.php"); ?>
            <!-- end footer section -->

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
