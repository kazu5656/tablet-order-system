
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
        <title>特定商取引法に基づく表示 | TABLET ORDER SYSTEM</title>
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

            @media screen and (max-width: 3000px) {

            h1{
            margin-top: 50px;
            font-weight: bold;
            }

            .各セクション見出し{
            font-size: 24px;
            text-align: left;
            margin-bottom: 10px;
            }

            #販売者情報{
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 20px;
            }

            }

            /*ipad 横幅*/
            @media screen and (max-width: 1024px){

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

            #各セクション見出し下_説明{
            color: black;
            font-weight: bold;
            font-size: 14px;
            }

            h1{
            margin-top: 80px;
            }

            }

            /*iphone 横幅(短)*/
            @media screen and (max-width: 414px){

            #各セクション見出し下_説明{
            color: black;
            font-weight: bold;
            font-size: 12px;
            }

            h1{
            font-size: 22px;
            font-weight: bold;
            margin-top: 80px;
            }

            .各セクション見出し{
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
        <!-- end header section -->

        <!-- start セクション１ TABLET ORDER SYSTEM -->
        <section>
            <div class="container">
            <h1>特定商取引法に基づく表示</h1>
            <hr>
                <div class="row" >

                    <div class="col-md-9">

                    <p class="各セクション見出し">運営者・販売者責任者について</p>
                    <p>本ページ右側に記載</p>
                    <hr>

                    <p class="各セクション見出し">商品以外の必要料金</p>
                    <p>
                      銀行振込決済をご利用の場合、商品代金（消費税額含む）相当額のほかに、<br />
                      代金お振込みにかかる振込手数料、ご利用されるタブレット端末代などをご負担頂けますようお願い申し上げます。<br />
                      また、ご注文およびwebサービスの利用（飲食店でタブレットオーダーシステムを利用する）に係る<br />
                      通信費（通話料、プロバイダ料金、電力等）はお客様のご負担となります。<br /><br />
                      <a href="https://tablet-order-system.com/#初期費用はどれくらいかかる？"target="_blank">初期費用の目安はこちら</a>
                    </p>
                    <hr>

                    <p class="各セクション見出し">お支払い方法</p>
                    <p>
                      商品代金のお支払い方法は、下記の二種類をご用意しております。<br />
                      <br />
                      [1]「クレジットカード決済」<br />
                      [2]「銀行振込決済」<br />
                      <br />
                      [1]「クレジットカード決済」をご利用の場合、商品代金のお支払いには<br />
                      クレジットカードをご利用頂け、クレジットカード情報のご入力はセキュリティに<br />
                      配慮されたクレジットカード決済代行会社のWebサイト上で行って頂きます。<br />
                      <br />
                      クレジット分割決済をご利用の場合、各決済金額は商品代金を回数分で均等に割った<br />
                      金額が請求されます。商品代金を回数分で割った際に発生した代金の端数は<br />
                      初回決済時に請求されます。初回のご注文日が毎月の決済日となります。<br />
                      <br />
                      [2]「銀行振込決済」をご利用の場合、ご注文後に折り返し当社銀行口座情報が<br />
                      記載されたメールをお届けしますので、最寄の金融機関窓口またはATM端末より<br />
                      商品代金お振込みのお手続きをお願いいたします。<br />
                    </p>
                    <hr>

                    <p class="各セクション見出し">お支払い期限</p>
                    <p>
                      「クレジットカード決済」をご利用の場合、ご注文確定後にクレジット決済代行会社の<br />
                      Webサイトにてシームレスにご決済のお手続きを行って頂けます。<br />
                      <br />
                      「銀行振込決済」をご利用の場合、原則として商品代金のお支払い期限は<br />
                      ご注文時より7日間とし、この期限を超過したご注文はキャンセル扱いとさせて頂きます。<br />
                    </p>
                    <hr>

                    <p class="各セクション見出し">TABLET ORDER SYSTEM 利用開始時期</p>
                    <p>
                      「クレジットカード決済」をご利用の場合、決済完了後に折り返し<br />
                      新規登録をご案内するメールをお届けいたしますので、<br />
                      登録を完了して頂けますようお願いいたします。<br />
                      新規登録完了後、設定ページと注文ページへのリンク付きメールが<br />
                      届くので設定ページから各種設定を行い TABLET ORDER SYSTEM 利用開始です。

                      <br /><br />
                      「銀行振込決済」をご利用の場合、TABLET ORDER SYSTEM の利用開始は<br />
                      当社にてお客様からのご入金を確認できた後となります。<br />
                      このため、金融機関営業日等の兼ね合いで、実際のお振込み手続きを<br />
                      行って頂いたタイミングよりも多少のお時間を頂戴する場合がございます。<br />
                      ご入金確認後、速やかに新規登録をご案内するメールを<br />
                      お届けできるよう心がけておりますが、注文の混雑状況等により多少のお時間を<br />
                      頂戴する場合もございますので予めご了承下さい。<br />
                      <br />
                      「クレジットカード決済」「銀行振込決済」の別に関わらず、<br />
                      お振込手続き（またはクレジットカード決済お手続き完了）後3日以内に<br />
                      当社より新規登録ご案内のメールが届かない場合、<br />
                      お手数ですが、本ページ右側の当社連絡先までご連絡をお願いいたします。<br />
                    </p>
                    <hr>

                    <p class="各セクション見出し">不正決済に関して</p>
                    <p>
                      クレジットカード決済に関して、不正にデータを改ざんされた疑いのある<br />
                      お取引に関しては、一時的に TABLET ORDER SYSTEM の利用ができない状態(ログイン不可)で<br />
                      調査を行わせて頂く場合がございますので、ご理解とご協力をお願いいたします。<br />
                      <br />
                      また、不正が疑われるお取引に関しましては新規登録ご案内のメールが正常に<br />
                      お手元にお届けできない場合がございますので、予めご了承下さい。<br />
                      <br />
                      これらの疑いが「明らかな不正決済」であることが明確であるとの判断に<br />
                      いたった場合、当社は事前の通告無しに当該ご注文およびご決済を取り消<br />
                      させて頂く場合がございます。（この場合、TABLET ORDER SYSTEM の利用ができません）<br />
                      <br />
                      もちろん、銀行振込決済でのお取引や、正常なご購入手続きによって<br />
                      進められたクレジットカード決済でのお取引に関しましては<br />
                      上記のような状況は発生いたしませんので、何卒ご安心下さい。<br />
                    </p>
                    <hr>

                    <p class="各セクション見出し">返品交換特約</p>
                    <p>
                      TABLET ORDER SYSTEM は、誠に恐れ入りますがWebアプリケーションという<br />
                      性質上、返品交換はお受けできかねますので予めご了承下さい。<br />
                      <br />
                      お客様のご都合による返品は堅くお断り申し上げており、一切ご返金には<br />
                      応じかねますので予めご了承下さい。<br />
                      <hr>
                      ご注文頂きました時点で、本「特定商取引法に基づく表示」に関して<br />
                      ご理解・ご同意頂けたものと見なします。<br />
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
