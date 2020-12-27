<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (!isset($_SESSION['tablet_order_system_USER'])) {
		header('Location: '.SITE_URL.'login_order.php');
		exit;
}


$pdo = connectDb();
$login_table = $_SESSION['login_table'];
$user = $_SESSION['tablet_order_system_USER'];
$user_id = $user ['id'];

$photo_directory = $user['photo_directory'];
define( "FILE_DIR", "images/test/$photo_directory/");

// 会計ページの写真があるかチェック
$user_okaikei_photo = array();
$sql = "select * from user where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$user_id, PDO::PARAM_INT);
$stmt->execute();
$user_okaikei_photo = $stmt->fetch();


// 自動ログアウトチェック
autoLogoutCheck ($login_table, $user_id,$pdo);

// 合計金額を出す
$sum_price = 0;
for ($i = 0; $i <= 500; $i=$i+1){
		$sum_price = $sum_price+$_SESSION['order_kakutei'][$i]['8'];
}
// 税込
$sum_price_tax = $sum_price*1.1;

$sum_price= number_format($sum_price);
$sum_price_tax= number_format($sum_price_tax);

if($sum_price_tax==0){
		// $sum_price_taxが０ならメールしない
}else{

		// 管理者にメールを送信
		mb_language("japanese");
		mb_internal_encoding("UTF-8");

		// 差出人
		$mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";

		$mail_title = '【'.$login_table.'番テーブル】お会計です。';
		$mail_body.= '合計'.$sum_price_tax.'円(税込)'.PHP_EOL.PHP_EOL;

		// 注文履歴を添付
		for ($n = 0; $n <= 500; $n=$n+1){
				$mail_body.= $_SESSION['order_kakutei'][$n]['2'].$_SESSION['order_kakutei'][$n]['8'].PHP_EOL;
		}
		mb_send_mail($user['order_pc_email'], $mail_title, $mail_body, $mailfrom);

		$sum_price_tax=str_replace(',','',$sum_price_tax);

		$sql = "insert into okaikei
		    (user_id,price,order_table,order_date,created_at,updated_at)
		    values
		    (:user_id,:price,:order_table,:order_date, now(), now())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':price',$sum_price_tax, PDO::PARAM_INT);
    $stmt->bindValue(':order_table',$login_table, PDO::PARAM_INT);
    $stmt->bindValue(':order_date',date("Y/m/d H:i:s"), PDO::PARAM_STR);
    $stmt->execute();

}

$_SESSION['order']=array();
$_SESSION['order_kakutei']=array();


?>




<!DOCTYPE html>
<html lang="ja">

		<head>

				<!-- metas -->
				<meta charset="utf-8">
				<meta http-equiv="refresh" content="65; URL="https://tablet-order-system.com/order_complete.php>
				<meta http-equiv="X-UA-Compatible" content="IE=edge" />
				<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
				<meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
				<meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。">

				<!-- title  -->
				<title>お会計画面| <?php echo SERVICE_NAME; ?></title>

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

						/*パソコン*/
						@media screen and (max-width: 3000px) {

						.br-pc { display:none; }
						.br-携帯長 { display:none; }
						.br-携帯短 { display:none; }

						.label{
						font-size: 18px;
						font-weight: bold;
						color: white;
						float: left;
						}

						.btn-success{
						font-weight: bold;
						font-size: 20px;
						margin-top:10px;
						}

						.footer-bar {
						padding-top: 20px;
						padding-bottom: 20px;
						margin-top: 110px;
						margin-bottom: 0;
						text-align: center;
						background: white;
						color: black;
						}

						body {
						padding-top: 10px;
						padding-bottom: 10px;
						}

						#合計金額{
						font-size:16px;
						text-align:right;
						color: black;
						font-weight: bold;
						}

						#税込金額{
						font-size:18px;
						text-align:right;
						color: black;
						font-weight: bold;
						}

						#注文内容{
						font-size:20px;
						text-align:left;
						color: black;
						font-weight: bold;
						}



						#ご来店頂き、ありがとうございました。{
						font-size:18px;
						color: black;
						font-weight: bold;
						}

						}

						/*iphone 短*/
						@media screen and (max-width: 414px){

						.br-pc { display:none; }
						.br-携帯長 { display:none; }
						.br-携帯短 { display:block; }

						#ご来店頂き、ありがとうございました。{
						font-size:13px;
						color: black;
						font-weight: bold;
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
		            <h1>お会計</h1>
		            <div id="ご来店頂き、ありがとうございました。">ご来店頂き、ありがとうございました。<br>スタッフ一同、またのお越しを<br class="br-携帯短" />お待ち致しております。 </div>
		        </div>

		        <!-- start advice section -->
		        <section class="box-hover bg-black margin-90px-bottom md-margin-70px-bottom sm-margin-50px-bottom">
		            <div class="container text-center">
				            <div class="row">

												<div class="col-md-2">
												</div>

												<div class="col-md-8">
														<!--  会計ページの写真がなければdemo写真を表示する -->
														<?php if ($user_okaikei_photo['image_name']):?>
																<img src="images/test/<?php echo h($photo_directory); ?>/thank_you/<?php echo h($user['image_name']); ?>" alt="写真を登録していない場合は登録して下さい。" />
														<?php else: ?>
																<img src="images/KAIKEIPHOTO_DEMO.JPG" alt="写真を登録していない場合は登録して下さい。" />
														<?php endif; ?>
														<br><br>
														<a id="注文ページに戻る" href="order.php" class="btn btn-success btn-block" role="button" >注文ページに戻る</a>
												</div><!-- col-md-8 -->

												<div class="col-md-2">
												</div>

				            </div><!-- row -->
		            </div><!-- container -->
		        </section>
		        <!-- end advice section -->


						<!-- start footer section -->
            <?php include("./common_footer_order.php"); ?>
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
