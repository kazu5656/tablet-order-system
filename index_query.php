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
            $err['user_name'] = '氏名は30バイト以内で入力して下さい。';
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

        $complete_msg = "問い合わせが完了しました。問い合わせ完了メールをご確認下さい。";

        // 差出人
        $mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

        // 管理者にメールを送信"
        mb_language("japanese");
        mb_internal_encoding("UTF-8");
        $mail_title = 'お問い合わせがありました。';
        $mail_body = '氏名：'. $user_name.PHP_EOL;
        $mail_body.= 'メールアドレス：'.$user_email.PHP_EOL.'電話番号：'.$user_phone_number.PHP_EOL.'ご質問：'.$Question;
        mb_send_mail(kazu_mail, $mail_title, $mail_body, $mailfrom);

        // 申込完了メールを送信"
        mb_language("japanese");
        mb_internal_encoding("UTF-8");
        $mail_title = 'お問い合わせありがとうございます。';
        $mail_body = $user_name. ' 様'.PHP_EOL.PHP_EOL;
        $mail_body.= 'この度は【TABLET ORDER SYSTEM】についてのお問い合わせをいただきありがとうございます。'.PHP_EOL.PHP_EOL;
        $mail_body.= 'お問い合わせ内容を確認次第、返信いたしますのでしばらくお待ち下さい。'.PHP_EOL.PHP_EOL;
        $mail_body.= '※本メールアドレスは返信用ではありません。本メールの返信でのお問い合わせは受け付けておりません。';
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
        <meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。">

        <!-- title  -->
        <title>お問い合わせ| <?php echo SERVICE_NAME; ?></title>

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
            margin-top: 110px;
            margin-bottom: 0;
            text-align: center;
            background: #191919;
            color: #939393;
            }

            #お名前{
            color: white;
            font-size: 16px;
            font-weight: bold;
            float: left;
            }

            #メールアドレス{
            color: white;
            font-size: 16px;
            font-weight: bold;
            float: left;
            }

            #電話番号{
            color: white;
            font-size: 16px;
            font-weight: bold;
            float: left;
            }

            #ご質問など{
            color: white;
            font-size: 16px;
            font-weight: bold;
            float: left;
            }

            #HOMEに戻るボタン{
            color: white;
            font-weight: bold;
            font-size: 20px;
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
                <h1>お問い合わせ</h1>
            </div>

            <!-- start advice section -->
            <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">

                            <?php if ($complete_msg): ?>
                                <div class="alert alert-success">
                            <?php echo h($complete_msg); ?>
                                </div>
                            <?php endif; ?>

                            <form id="demo_form"method="POST" class="panel panel-default panel-body" >

                                <div class="form-group <?php if ($err['user_email'] != '') echo 'has-error'; ?>">
                                    <label id="お名前">お名前</label><br>
                                    <input type="text" class="validate[required]" name="user_name"size="50" value="<?php echo h($user_name); ?>" placeholder=お名前 />
                                    <span class="help-block"><?php echo h($err['user_name']); ?></span>
                                </div>

                                <div class="form-group <?php if ($err['user_email'] != '') echo 'has-error'; ?>">
                                    <label id="メールアドレス">メールアドレス</label><br>
                                    <input type="text" class="validate[required,custom[email]" name="user_email" size="50"value="<?php echo h($user_email); ?>" placeholder="メールアドレス" />
                                    <span class="help-block"><?php echo h($err['user_email']); ?></span>
                                </div>

                                <div class="form-group <?php if ($err['user_phone_number'] != '') echo 'has-error'; ?>">
                                    <label id="電話番号">電話番号</label><br>
                                    <input type="text" class="validate[required,custom[phone]]" name="user_phone_number" size="50"value="<?php echo h($user_phone_number); ?>"placeholder="電話番号" />
                                    <span class="help-block"><?php echo h($err['user_phone_number']); ?></span>
                                </div>


                                <div class="form-group <?php if ($err['Question'] != '') echo 'has-error'; ?>">
                                    <label id="ご質問など">ご質問など</label>  <br>
                                    <textarea name="Question" cols="55" rows="8" ><?php echo h($Question); ?></textarea><span class="help-block"><?php echo h($err['Question']); ?></span>
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-success btn-block" type="submit" value="送信">
                                    <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                                </div>

                            </form>
                            <a href="index.php"><input type="" value="HOMEに戻る" id="HOMEに戻るボタン" class="btn btn-info btn-block"></a>

                        </div><!-- col-md-12 -->
                    </div><!-- row -->
                </div><!-- container -->
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
