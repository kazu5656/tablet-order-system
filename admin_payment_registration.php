<?php
require_once('config.php');
require_once('functions.php');
session_start();


if (!isset($_SESSION['tablet_order_system_admin'])) {
    header('Location: '.SITE_URL.'login_admin.php');
    exit;
}

$pdo = connectDb();
$id = $_GET['id'];

//表形式用
$user = array();
$sql = "select * from user where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();


if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();

} else {

    // CSRF対策↓
    checkToken();

    // フォームからサブミットされた時の処理
    // 入力されたニックネーム、メールアドレス、パスワードを受け取り、変数に入れる。

    $payment = $_POST['payment'];
    $user_id = $user['id'];
    $user_name = $user['user_name'];

    $pdo = connectDb();

    // 入力チェックを行う。
    $err = array();



    if ($payment == '') {
        $err['payment'] = '入金額を入力して下さい。';
    }


    // もし$err配列に何もエラーメッセージが保存されていなかったら
    if (empty($err)) {
        // データベース（paymentテーブル）に新規登録する。
        $sql = "insert into payment
            (user_id,user_name,payment,created_at,updated_at)
            values
            (:user_id,:user_name,:payment ,now(), now())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id',$user_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_name',$user_name, PDO::PARAM_STR);
        $stmt->bindValue(':payment',$payment, PDO::PARAM_INT);
        $stmt->execute();

        unset($pdo);
    }
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
        <title>入金登録 | TABLET ORDER SYSTEM</title>
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

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            #テーブル{margin-top:-150px;padding-top:150px;}

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

            }

        </style>

    </head>


    <body>

        <!-- start main-wrapper section -->
        <div class="main-wrapper">

            <?php include("./common_header_admin.php"); ?>
            <br><br><br><br><br>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h6>入金登録</h6>
                        <p><?php echo h($user['user_name']); ?> 様</p>

                        <form id="demo_form"method="POST" class="panel panel-default panel-body" >
                              <div class="form-group <?php if ($err['payment'] != '') echo 'has-error'; ?>">
                                  <label class="label">入金額</label>
                                  <?php echo arrayToSelect("payment", $payment_array, $payment); ?>
                                  <span class="help-block"><?php echo h($err['payment']); ?></span>
                              </div>

                              <div class="form-group">
                                  <input class="btn btn-success btn-block" type="submit" value="登録">
                              </div>
                                  <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                        </form>

                    </div>
                </div>
            </div>

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
