<?php

require_once('config.php');
require_once('functions.php');

session_start();



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();

} else {

    // CSRF対策↓
    checkToken();


    // フォームからサブミットされた時の処理
    // 入力されたニックネーム、メールアドレス、パスワードを受け取り、変数に入れる。

    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_phone_number = $_POST['user_phone_number'];
    $Question = $_POST['Question'];

    $pdo = connectDb();

    // 入力チェックを行う。
    $err = array();

    // [氏名]未入力チェック
    if ($user_name == '') {
        $err['user_name'] = '氏名を入力して下さい。';
    }else {
        // 文字数チェック
        if (strlen(mb_convert_encoding($user_name, 'SJIS', 'UTF-8')) > 30) {
            $err['user_name'] = '氏名は15文字以内で入力して下さい。';
        }
    }

    // [メールアドレス]未入力チェック
    if ($user_email == '') {
        $err['user_email'] = 'メールアドレスを入力して下さい。';
    } else {
        // [メールアドレス]形式チェック
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $err['user_email'] = 'メールアドレスが不正です。';
        }
    }

    // [パスワード]未入力チェック
    if ($user_phone_number == '') {
        $err['user_phone_number'] = '電話番号を入力して下さい。';
    }

    // もし$err配列に何もエラーメッセージが保存されていなかったら
    if (empty($err)) {

        $complete_msg = "申込みが完了しました。申込み完了メールをご確認下さい。";

        // 差出人
        $mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

        // 管理者にメールを送信"
        mb_language("japanese");
        mb_internal_encoding("UTF-8");
        $mail_title = '新規申込がありました。';
        $mail_body = '氏名：'. $user_name.PHP_EOL;
        $mail_body.= 'メールアドレス：'.$user_email.PHP_EOL.'電話番号：'.$user_phone_number.PHP_EOL.'ご質問：'.$Question;
        mb_send_mail(kazu_mail, $mail_title, $mail_body, $mailfrom);

        // 申込完了メールを送信"
        mb_language("japanese");
        mb_internal_encoding("UTF-8");
        $mail_title = '新規申込ありがとうございます。';
        $mail_body = $user_name. ' 様'.PHP_EOL.PHP_EOL;
        $mail_body.= 'この度は【TABLET ORDER SYSTEM】にお申込みいただきまして、誠にありがとうございます。'.PHP_EOL.PHP_EOL;
        $mail_body.= '下記のリンクよりPaypalにてご入金いただきまして登録完了となります。'.PHP_EOL.PHP_EOL;
        $mail_body.= 'http://tablet-order-system.com/index_pay1.php';
        mb_send_mail($user_email, $mail_title, $mail_body, $mailfrom);

    }

    unset($pdo);

}

?>


<!DOCTYPE html>
<html lang="ja">

    <head>

        <!-- metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
        <meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。">

        <!-- レスポンシブWebデザインを使うために必要なmeta-->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- title  -->
        <title>申し込みフォーム｜TABLET ORDER SYSTEM</title>

        <!-- favicon -->
        <link rel="icon" href="images/tablet_order_system_favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="images/tablet_order_system_favicon.ico">

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

            h6{
            text-align: center;
            }

            #申し込みフォーム{
            color: black;
            font-size: 32px;
            text-align: center;
            font-weight: bold;
            }



            #お名前{
            color: black;
            font-size: 16px;
            font-weight: bold;
            }

            #メールアドレス{
            color: black;
            font-size: 16px;
            font-weight: bold;
            }

            #電話番号{
            color: black;
            font-size: 16px;
            font-weight: bold;
            }




            #TABLETORDERSYSTEM {
            color: white;
            }

            #HOMEに戻るボタン{
            color: white;
            font-size: 22px;
            font-weight: bold;
            width: 100%;
            }



            #申し込みボタン{
            color: white;
            font-weight: bold;
            font-size: 22px;
            }

            #お問い合わせはこちらボタン{
            color: white;
            font-weight: bold;
            font-size: 20px;
            width: 100%;
            }

            .申込みセクション{
            background-color: #e6e8ff;
            }

            #新タイトルsection{
            height: 400px;
            background-color: black;
            }

            @media screen and (max-width: 3000px) {

            h4{
            color: black;
            font-weight: bold;
            font-size: 16px;
            }

            .help-block{
            color:red;
            float: right;
            font-weight: bold;
            }

            }

            /*ipad 横幅*/
            @media screen and (max-width: 1024px) {

            h4{
            color: black;
            font-weight: bold;
            font-size: 14px;
            }

            p{
            font-size: 12px;
            }

            }

            /*ipad 縦幅*/
            @media screen and (max-width: 768px) {

            h4{
            color: black;
            font-weight: bold;
            font-size: 16px;
            }

            p{
            font-size: 12px;
            }

            }

            /*iphone 縦幅(横)*/
            @media screen and (max-width: 736px) {

            h4{
            color: black;
            font-weight: bold;
            font-size: 14px;
            }

            p{
            font-size: 13px;
            }

            }

            /*iphone 横幅(短)*/
            @media screen and (max-width: 414px) {

            #申し込みフォーム{
            color: black;
            font-size: 20px;
            text-align: center;
            font-weight: bold;
            }

            #申し込みページ{
            color: black;
            font-size: 20px;
            text-align: center;
            font-weight: bold;
            }

            h4{
            color: black;
            font-weight: bold;
            font-size: 14px;
            }

            }

        </style>

    </head>

    <body>


        <!-- start main-wrapper section -->
        <div class="main-wrapper">

            <div class="section-heading margin-50px-top md-margin-70px-top sm-margin-50px-top">
                <h1 id="申し込みページ">申し込みページ</h1>
            </div>

            <hr>

            <div class="container">
            <br>
            <h6>申し込みの流れ</h6>

                <div class="row feature-boxes-container">

                    <div class="col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04">
                        <div class="feature-box-inner">
                            <i class=""></i>
                            <h4>申し込み</h4>
                            <div class="sepratar"></div>
                            <p>このページの申し込みフォームから名前、メールアドレス、電話番号を入力して申し込みます。</p>
                            <br>
                        </div><!-- feature-box-inner -->
                    </div><!-- col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04 -->

                    <div class="col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04">
                        <div class="feature-box-inner">
                            <i class=""></i>
                            <h4>入金</h4>
                            <div class="sepratar"></div>
                            <p>入力したメールアドレスに入金ページへのリンク付きのメールが届くので、そこから入金を行います。</p>
                            <br>
                        </div><!-- feature-box-inner -->
                    </div><!-- col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04 -->

                    <div class="col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04">
                        <div class="feature-box-inner">
                            <i class=""></i>
                            <h4>新規登録</h4>
                            <div class="sepratar"></div>
                            <p>入金後、新規登録ページへのリンク付きメールが届くので、必要事項を入力して新規登録を行います。</p>
                            <br>
                        </div><!-- feature-box-inner -->
                    </div><!-- col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04 -->

                    <div class="col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04">
                        <div class="feature-box-inner">
                            <i class=""></i>
                            <h4>利用開始</h4>
                            <div class="sepratar"></div>
                            <p>登録後、設定ページと注文ページへのリンク付きメールが届くので、設定ページから各種設定を行い利用開始です。</p>
                        </div><!-- feature-box-inner -->
                    </div><!-- col-lg-3 col-md-12 sm-margin-20px-bottom feature-box-04 -->

                </div><!-- row feature-boxes-container -->

            <br>

            </div><!-- container -->
            <br>

            <!-- start contact section -->
            <section class="申込みセクション">
                <div class="container">
                <h1 id="申し込みフォーム">申し込みフォーム</h1>

                    <div class="row">
                        <div class="col-md-12">

                            <?php if ($complete_msg): ?>
                                <div class="alert alert-success">
                            <?php echo h($complete_msg); ?>
                                </div>
                            <?php endif; ?>

                            <div class="panel-body">

                                <form id="demo_form" method="POST">

                                    <div class="form-group <?php if ($err['user_email'] != '') echo 'has-error'; ?>">
                                        <label id="お名前">お名前</label><br>
                                        <input type="text" class="validate[required]" name="user_name"size="50" value="<?php echo h($user_name); ?>" placeholder=お名前 />
                                        <span class="help-block" id="エラー表示"><?php echo h($err['user_name']); ?></span>
                                    </div>


                                    <div class="form-group <?php if ($err['user_email'] != '') echo 'has-error'; ?>">
                                        <label id="メールアドレス">メールアドレス</label><br>
                                        <input type="text" class="validate[required,custom[email]" name="user_email" size="50"value="<?php echo h($user_email); ?>" placeholder="メールアドレス" />
                                        <span class="help-block" id="エラー表示"><?php echo h($err['user_email']); ?></span>
                                    </div>

                                    <div class="form-group <?php if ($err['user_phone_number'] != '') echo 'has-error'; ?>">
                                        <label id="電話番号">電話番号</label><br>
                                        <input type="text" class="validate[required,custom[phone]]" name="user_phone_number" size="50"value="<?php echo h($user_phone_number); ?>"placeholder="電話番号" />
                                        <span class="help-block" id="エラー表示"><?php echo h($err['user_phone_number']); ?></span>
                                    </div><br>

                                    <div class="form-group">
                                        <input type="submit" onclick="ring();" value="申し込み" id="申し込みボタン" class="btn btn-primary btn-block">
                                        <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                                    </div>


                                </form>

                            </div><!--/panel-body -->


                            <a href="index.php" class="btn btn-info" role="button" id="HOMEに戻るボタン">
                              HOMEに戻る
                            </a>

                        </div><!--/col-md-12 -->
                    </div><!--/row-->

                </div><!--/container-->
            </section>
            <!-- end contact section -->

            <?php include("./common_footer_index.php"); ?>

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
