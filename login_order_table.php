<?php

require_once('config.php');
require_once('functions.php');

session_start();


$user = $_SESSION['tablet_order_system_USER'];
 $pdo = connectDb();

for ($n = 1; $n <= 60; $n=$n+1){
    $login_table_number_list =  array();
    $sql = "select * from login_table where user_id = :user_id and table_number = :table_number";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':table_number', $n, PDO::PARAM_INT);
    $stmt->execute();
    $login_table_number_list = $stmt->fetch();
    if ($login_table_number_list) {
        $login_table_number_list_[$n]=$login_table_number_list['table_number'];
    }
}

for ($i = 1; $i <= 60; $i=$i+1){
    if($login_table_number_list_[$i]){
        ${'number'.$i}="$i:[ログイン中]";
    }else{
        ${'number'.$i}=$i;
    }
}

//登録されていないグループ番号を$no_group_idに入れる
$no_login_table = array();
for ($n = 1; $n <= 60; $n=$n+1){
    if(!$login_table_number_list_[$n]){
        $no_login_table[$n]=$n;
    }
}

//プルダウンメニューの初期値（$group_id） に$no_group_idの最小値を入れる
if($no_login_table){
    $table_number = min($no_login_table);
}else{
    $table_number = 1;
}



$table_number_array = array(
    "1" => "$number1",
    "2" => "$number2",
    "3" => "$number3",
    "4" => "$number4",
    "5" => "$number5",
    "6" => "$number6",
    "7" => "$number7",
    "8" => "$number8",
    "9" => "$number9",
    "10" => "$number10",
    "11" => "$number11",
    "12" => "$number12",
    "13" => "$number13",
    "14" => "$number14",
    "15" => "$number15",
    "16" => "$number16",
    "17" => "$number17",
    "18" => "$number18",
    "19" => "$number19",
    "20" => "$number20",
    "21" => "$number21",
    "22" => "$number22",
    "23" => "$number23",
    "24" => "$number24",
    "25" => "$number25",
    "26" => "$number26",
    "27" => "$number27",
    "28" => "$number28",
    "29" => "$number29",
    "30" => "$number30",
    "31" => "$number31",
    "32" => "$number32",
    "33" => "$number33",
    "34" => "$number34",
    "35" => "$number35",
    "36" => "$number36",
    "37" => "$number37",
    "38" => "$number38",
    "39" => "$number39",
    "40" => "$number40",
    "41" => "$number41",
    "42" => "$number42",
    "43" => "$number43",
    "44" => "$number44",
    "45" => "$number45",
    "46" => "$number46",
    "47" => "$number47",
    "48" => "$number48",
    "49" => "$number49",
    "50" => "$number50",
    "51" => "$number51",
    "52" => "$number52",
    "53" => "$number53",
    "54" => "$number54",
    "55" => "$number55",
    "56" => "$number56",
    "57" => "$number57",
    "58" => "$number58",
    "59" => "$number59",
    "60" => "$number60",


);



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();

    // 初めて画面にアクセスした時の処理

} else {

    // CSRF対策↓
    checkToken();

    // フォームからサブミットされた時の処理
    // 入力されたニックネーム、メールアドレス、パスワードを受け取り、変数に入れる。

    $table_number = $_POST['table_number'];

    $pdo = connectDb();

    // 入力チェックを行う。
    $err = array();




  // login_tableに同じテーブル番号でログインされていないかチェックする
    $sql = "select * from login_table where user_id = :user_id and table_number = :table_number limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_id" => $user['id'], ":table_number" => $table_number));
    $login_table_number = $stmt->fetch();

    if ($login_table_number) {
        $err['table_number'] = 'このテーブル番号はログインされています。';
    }



    // もし$err配列に何もエラーメッセージが保存されていなかったら
    if (empty($err)) {
        // セッションハイジャック対策
        session_regenerate_id(true);


        // login_tableテーブルにuser_idとテーブル番号を保存する
        $sql = "insert into login_table
      	    (user_id,table_number,last_action_time,created_at,updated_at)
      	    values
      	    (:user_id,:table_number, now(), now(), now())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
        $stmt->bindValue(':table_number',$table_number, PDO::PARAM_INT);
        $stmt->execute();

        // テーブル番号をセッションに保存する。
        $_SESSION['login_table'] = $table_number;

        // ログインに成功したのでセッションにユーザデータを保存する。
        $_SESSION['tablet_order_system_USER'] = $user;

        // signup_complete.phpに画面遷移する。
        header('Location: '.SITE_URL.'order.php');


        unset($pdo);
        exit;

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
        <title>ログインテーブル選択| <?php echo SERVICE_NAME; ?></title>

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

            .item {
            background: #red;
            color: #eb4034;
            padding: 5px;
            }


            .footer-bar {
            padding-top: 20px;
            padding-bottom: 20px;
            margin-top: 180px;
            margin-bottom: 0;
            text-align: center;
            background: #191919;
            color: #939393;
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
                <h4>ログインテーブル選択</h4>
            </div>

            <!-- start advice section -->
            <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
                <div class="container text-center">
                <br>
                    <div class="row">
                        <div class="col-md-12">

                            <form id="demo_form"method="POST" class="panel panel-default panel-body" >

                                <div class="form-group <?php if ($err['table_number'] != '') echo 'has-error'; ?>">
                                    <label class="label">テーブル番号</label>
                                    <?php echo arrayToSelect("table_number", $table_number_array, $table_number); ?>
                                    <span class="help-block"><?php echo h($err['table_number']); ?></span>
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-success btn-block" type="submit" value="注文画面へ">
                                    <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                                </div>

                            </form>

                        </div><!-- col-md-12 -->
                    </div><!-- row -->
                 <br>
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
