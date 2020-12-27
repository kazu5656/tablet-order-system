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
    $order_pc_email	 = $_POST['order_pc_email'];
    $name_restaurant = $_POST['name_restaurant'];
    $zip = $_POST['zip'];
    $addr1 = $_POST['addr1'];
    $addr2 = $_POST['addr2'];
    $user_password = $_POST['user_password'];
    $str_rand = makeRandStr(14);
    $photo_directory = $str_rand;



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

    // [氏名]未入力チェック
    if ($name_restaurant == '') {
        $err['name_restaurant'] = '店舗名を入力して下さい。';
    }else {
        // 文字数チェック
        if (strlen(mb_convert_encoding($name_restaurant, 'SJIS', 'UTF-8')) > 30) {
            $err['name_restaurant'] = '店舗名は15文字以内で入力して下さい。';
        }
    }

    // [メールアドレス]未入力チェック
    if ($user_email == '') {
        $err['user_email'] = 'メールアドレスを入力して下さい。';
    } else {
        // [メールアドレス]形式チェック
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $err['user_email'] = 'メールアドレスが不正です。';
        } else {
            // [メールアドレス]存在チェック
            if (checkEmail0($user_email, $pdo)) {
                $err['user_email'] = 'このメールアドレスは既に登録されています。';
            }
        }
    }

    // [受注PCメールアドレス]未入力チェック
    if ($order_pc_email == '') {
        $err['order_pc_email'] = 'メールアドレスを入力して下さい。';
    } else {
        // [メールアドレス]形式チェック
        if (!filter_var($order_pc_email, FILTER_VALIDATE_EMAIL)) {
            $err['order_pc_email'] = 'メールアドレスが不正です。';
        } else {
            // [メールアドレス]存在チェック
            if (checkorder_pc_email0($order_pc_email, $pdo)) {
                $err['order_pc_email'] = 'このメールアドレスは既に登録されています。';
            }
        }
    }

    // [電話番号]未入力チェック
    if ($user_phone_number == '') {
        $err['user_phone_number'] = '電話番号を入力して下さい。';
    }

    // [パスワード]未入力チェック
    if ($user_password == '') {
        $err['user_password'] = 'パスワードを入力して下さい。';
    }else{
        // 文字数チェック
        if (strlen(mb_convert_encoding($user_password, 'SJIS', 'UTF-8')) < 6) {
            $err['user_password'] = 'パスワードは6文字以上で入力して下さい。';
        }
    }

    // もし$err配列に何もエラーメッセージが保存されていなかったら
    if (empty($err)) {
        // データベース（vt_userテーブル）に新規登録する。
        $sql = "insert into user
                    (user_name,user_email,order_pc_email,user_phone_number,name_restaurant,zip,addr1,addr2,user_password,photo_directory,created_at,updated_at)
                    values
                    (:user_name,:user_email,:order_pc_email,:user_phone_number,:name_restaurant,:zip,:addr1,:addr2,:user_password,:photo_directory,now(), now())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_name',$user_name, PDO::PARAM_STR);
        $stmt->bindValue(':user_email',$user_email, PDO::PARAM_STR);
        $stmt->bindValue(':order_pc_email',$order_pc_email, PDO::PARAM_STR);
        $stmt->bindValue(':user_phone_number',$user_phone_number, PDO::PARAM_INT);
        $stmt->bindValue(':name_restaurant',$name_restaurant, PDO::PARAM_STR);
        $stmt->bindValue(':zip',$zip, PDO::PARAM_INT);
        $stmt->bindValue(':addr1',$addr1, PDO::PARAM_STR);
        $stmt->bindValue(':addr2',$addr2, PDO::PARAM_STR);
        $stmt->bindValue(':user_password',password_hash($user_password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':photo_directory',$photo_directory, PDO::PARAM_STR);
        $stmt->execute();

        // 差出人
        $mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

        // 管理者にメールを送信"
        mb_language("japanese");
        mb_internal_encoding("UTF-8");
        $mail_title = '新規ユーザー登録がありました。';
        $mail_body = '氏名：'.$user_name.PHP_EOL;
        $mail_body.= 'メールアドレス：'.$user_email;
        mb_send_mail(kazu_mail, $mail_title, $mail_body, $mailfrom);

         // 登録完了メールを送信"
        mb_language("japanese");
        mb_internal_encoding("UTF-8");
        $mail_title = 'ユーザー登録ありがとうございます。';

        $mail_body = $user_name. ' 様'.PHP_EOL.PHP_EOL;

        $mail_body.= 'この度は【TABLET ORDER SYSTEM】にご登録いただきまして、誠にありがとうございます。'.PHP_EOL.PHP_EOL;
        $mail_body.= '下記の設定メニューのリンクより設定を行い、その後、注文メニューにログインして下さい。'.PHP_EOL.PHP_EOL;
        $mail_body.= '各メニューにログインするにはご登録頂いた【メールアドレス】と【パスワード】が必要です。'.PHP_EOL.PHP_EOL;


        $mail_body.= '設定メニュー:https://tablet-order-system.com/login_setting.php'.PHP_EOL.PHP_EOL;
        $mail_body.= '注文メニュー:https://tablet-order-system.com/login_order.php'.PHP_EOL.PHP_EOL;
        $mail_body.= '使用方法がわからない方はヘルプサイトを参考にして下さい。'.PHP_EOL.PHP_EOL;
        $mail_body.= 'ヘルプサイト:http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/';

        mb_send_mail($user_email, $mail_title, $mail_body, $mailfrom);

        // testフォルダの中に$user_emailという名前のフォルダを作る
        mkdir("images/test/$photo_directory", 0777);

        // $user_emailフォルダの中にthank_youという名前のフォルダを作る
        mkdir("images/test/$photo_directory/thank_you", 0777);

        // $user_emailフォルダの中にthank_youという名前のフォルダを作る
        mkdir("images/test/$photo_directory/logo", 0777);


        // signup_complete.phpに画面遷移する。
        header('Location: '.SITE_URL.'index_signup_complete.php');

        unset($pdo);
        exit;
    }
}

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
        <title>新規ユーザー登録 | <?php echo SERVICE_NAME; ?></title>

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

        <!-- 郵便番号から住所を出すjavascriptファイルの読み込み -->
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>


        <style>

            @media screen and (max-width: 3000px) {

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            h1{
            font-size:28px;
            }

            .help-block{
            color:red;
            float: right;
            font-weight: bold;
            }

            .label{
            font-size: 18px;
            font-weight: bold;
            color: black;
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

            #申し込みフォーム{
            background-color: #e6e8ff;
            }

            }
            /*ipad 横幅*/
            @media screen and (max-width: 1024px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            }

            /*ipad 縦幅*/
            @media screen and (max-width: 768px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            }

            /*iphone 縦幅(横)*/
            @media screen and (max-width: 736px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            }

            /*iphone 横幅(短)*/
            @media screen and (max-width: 414px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:block; }

            h1{
            font-size:25px;
            }

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
                <h1>新規ユーザー登録</h1>
            </div>

            <!-- start advice section -->
            <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom" id="申し込みフォーム">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">

                            <form id="demo_form"method="POST" class="panel panel-default panel-body" >

                                <div class="form-group <?php if (isset($err['user_name']) && $err['user_name'] != '') echo 'has-error'; ?>">
                                    <label class="label">氏名</label><br>
                                    <input class="validate[required]" type="text" name="user_name" size="80" value="<?php echo h($user_name) ?>" placeholder="氏名" />
                                    <span class="help-block"><?php if (isset($err['user_name'])) echo h($err['user_name']); ?></span>
                                </div>

                                <div class="form-group <?php if (isset($err['user_email']) && $err['user_email'] != '') echo 'has-error'; ?>">
                                    <label class="label">メールアドレス</label><br>
                                    <input class="validate[required,custom[email]"size="80" type="text" name="user_email" value="<?php echo h($user_email) ?>" placeholder="メールアドレス" />
                                    <span class="help-block"><?php if (isset($err['user_email'])) echo h($err['user_email']); ?></span>
                                </div>

                                <div class="form-group <?php if (isset($err['order_pc_email']) && $err['order_pc_email'] != '') echo 'has-error'; ?>">
                                    <label class="label">受注PCメールアドレス</label><br>
                                    <input class="validate[required,custom[email]" type="text" name="order_pc_email" size="80"value="<?php echo h($order_pc_email) ?>" placeholder="受注PCメールアドレス" />
                                    <span class="help-block"><?php if (isset($err['order_pc_email'])) echo h($err['order_pc_email']); ?></span>
                                </div>

                                <div class="form-group <?php if ($err['user_phone_number'] != '') echo 'has-error'; ?>">
                                    <label class="label">電話番号</label><br>
                                    <input type="tel" class="validate[required,custom[phone]]" name="user_phone_number" size="80"value="<?php echo h($user_phone_number) ?>"placeholder="電話番号" />
                                    <span class="help-block"><?php echo h($err['user_phone_number']); ?></span>
                                </div>

                                <div class="form-group <?php if (isset($err['name_restaurant']) && $err['name_restaurant'] != '') echo 'has-error'; ?>">
                                    <label class="label">店舗名</label><br>
                                    <input class="validate[required]" type="text" name="name_restaurant" size="80" value="<?php echo h($name_restaurant) ?>" placeholder="店舗名" />
                                    <span class="help-block"><?php if (isset($err['name_restaurant'])) echo h($err['name_restaurant']); ?></span>
                                </div>

                                <div class="form-group <?php if ($err['zip'] != '') echo 'has-error'; ?>">
                                    <label class="label">店舗の郵便番号</label><br>
                                    <input type="text" class="validate[required,custom[onlyNumberSp],maxSize[7]]"name="zip" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','addr1','addr1');"value="<?php echo h($Zip) ?>"placeholder="郵便番号(ハイフンなしで入力)" />
                                    <span class="help-block"><?php echo h($err['zip']); ?></span>
                                </div>


                                <div class="form-group <?php if ($err['addr1'] != '') echo 'has-error'; ?>">
                                    <label class="label">店舗の住所1</label><br>
                                    <input type="text" class="validate[required]"name="addr1" size="60"value="<?php echo h($addr1) ?>"placeholder="都道府県 市区町村 (郵便番号を入力すると自動表示されます。)" />
                                    <span class="help-block"><?php echo h($err['addr1']); ?></span>
                                </div>

                                <div class="form-group <?php if ($err['addr2'] != '') echo 'has-error'; ?>">
                                    <label class="label">店舗の住所2</label><br>
                                    <input type="text" class="validate[required]"name="addr2" size="60"value="<?php echo h($addr1) ?>"placeholder="○丁目○番○ 建物名" />
                                    <span class="help-block"><?php echo h($err['addr2']); ?></span>
                                </div>

                                <div class="form-group <?php if (isset($err['user_password']) && $err['user_password'] != '') echo 'has-error'; ?>"><span class="help-block"><?php echo h($err['user_phone_number']); ?></span>
                                    <label class="label">パスワード</label> <br>
                                    <input class="validate[required,minSize[6],custom[onlyLetterNumber],maxSize[15]]" type="password" name="user_password" size="80"value="<?php echo h($user_password) ?>" placeholder="パスワード(半角英数で6文字以上15文字以下)" />
                                    <span class="help-block"><?php if (isset($err['user_password'])) echo h($err['user_password']); ?></span>
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-success btn-block" type="submit" value="新規登録">
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
