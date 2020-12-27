<?php

require_once('config.php');
require_once('functions.php');

session_start();



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();

    // 初めて画面にアクセスした時の処理

} else {

    // CSRF対策↓
    checkToken();

    // フォームからサブミットされた時の処理
    // 入力されたニックネーム、メールアドレス、パスワードを受け取り、変数に入れる。

    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];


    $pdo = connectDb();

    // 入力チェックを行う。
    $err = array();

    // [パスワード]未入力チェック
    if ($user_password == '') {
        $err['user_password'] = 'パスワードを入力して下さい。';
    }


    // [メールアドレス]未入力チェック
    if ($user_email == '') {
        $err['user_email'] = 'メールアドレスを入力して下さい。';
    } else {
        // [メールアドレス]形式チェック
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $err['user_email'] = 'メールアドレスが不正です。';
        } else {
            // ログイン認証
            $user = getUserByEmail($user_email, $pdo);
            if (!$user || !password_verify($user_password, $user['user_password'])) {
                $err['user_password'] = 'パスワードが正しくありません。';
            }
        }
    }

    $seven_days_ago = date('Y-m-d', strtotime("-7 day", time()));



    if($user['experience'] == '体験' && $user['created_at'] < $seven_days_ago){

        $experience_user_message = '無料体験期間が終了しているためログインできません。';

    }else{

        // もし$err配列に何もエラーメッセージが保存されていなかったら
        if (empty($err)) {
            // セッションハイジャック対策
            session_regenerate_id(true);

            // ログインに成功したのでセッションにユーザデータを保存する。
            $_SESSION['tablet_order_system_USER'] = $user;
            $_SESSION['tablet_order_system_order'] = 'order';

            // signup_complete.phpに画面遷移する。
            header('Location: '.SITE_URL.'login_order_table.php');

            unset($pdo);
            exit;
        }


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
        <title>注文メニューログイン| <?php echo SERVICE_NAME; ?></title>

        <!-- favicon -->
        <link rel="icon" href="images/tablet_order_system_favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon_tablet-order-system_order.JPG">
        <link rel="apple-touch-icon" href="images/apple-touch-icon_tablet-order-system_order.JPG">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon_tablet-order-system_order.JPG">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon_tablet-order-system_order.JPG">

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

            @media screen and (max-width: 414px) {

            h1{
            font-size:22px;
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
                <h1>注文メニューログイン</h1>
                <?php echo h($experience_user_message); ?>
            </div>

            <!-- start advice section -->
            <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">
                                <form id="demo_form"method="POST" class="panel panel-default panel-body" >

                                    <div class="form-group <?php if (isset($err['user_email']) && $err['user_email'] != '') echo 'has-error'; ?>">
                                        <label class="label">メールアドレス</label><br>
                                        <input class="validate[required,custom[email]" size="80" type="text" name="user_email" value="<?php echo h($user_email) ?>" placeholder="メールアドレス" />
                                        <span class="help-block"><?php if (isset($err['user_email'])) echo h($err['user_email']); ?></span>
                                    </div>

                                    <div class="form-group <?php if (isset($err['user_password']) && $err['user_password'] != '') echo 'has-error'; ?>">
                                        <label class="label">パスワード</label> <br>
                                        <input class="validate[required]" type="password" name="user_password" size="80"value="<?php echo h($user_password) ?>" placeholder="パスワード" />
                                        <span class="help-block"><?php if (isset($err['user_password'])) echo h($err['user_password']); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <input class="btn btn-success btn-block" type="submit" value="ログイン">
                                        <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                                    </div>

                                </form>
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
