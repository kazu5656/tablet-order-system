<?php

require_once('config.php');
require_once('functions.php');

session_start();
$pdo = connectDb();

$login_table = $_SESSION['login_table'];
$user = $_SESSION['tablet_order_system_USER'];
$photo_directory = $user['photo_directory'];


$user_logo = array();
$sql = "select * from logo where user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
$user_logo = $stmt->fetch();


$H=1;

// $_SESSION['login_table']のtable_numberと同じものがlogin_tableテーブルにあるか調べてあれば$loginに入れる
$sql = "select * from login_table where user_id = :user_id and table_number = :table_number";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->bindValue(':table_number', $login_table, PDO::PARAM_INT);
$stmt->execute();
$login = $stmt->fetch();

// $loginがなければセッションを破壊する
if(!$login){
		session_destroy();
}

// ログインチェック
if (!isset($_SESSION['tablet_order_system_USER'])) {
		header('Location: '.SITE_URL.'login_order.php');
		exit;
}


$photo_directory = $user['photo_directory'];
define( "FILE_DIR", "images/test/$photo_directory/");


//グループ名とgroup_idを取得する
for ($n = 1; $n <= 16; $n=$n+1){
		$group = array();
		$sql = "select * from group_setting where user_id = :user_id and group_id = :group_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
		$stmt->bindValue(':group_id',$n, PDO::PARAM_INT);
		$stmt->execute();
		$group = $stmt->fetch();
		if($group){
		$group_name[$n]=$group['group_name'];
		$group_id[$n]=$group['group_id'];
		}
}

// group_idの$food_list（メニュー）を取得
$food_list = array();
$sql = "select * from food where user_id = :user_id and group_id = :group_id ORDER BY `display_position` ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id',$id, PDO::PARAM_INT);
$stmt->execute();
foreach ($stmt->fetchAll() as $row) {
		array_push($food_list, $row);
}

//GETでグループidが取得されたらそのグループid、なければグループidは１
if($_GET['id']){
		$id = $_GET['id'];
		$_SESSION['id'] = $_GET['id'];
		$sql = "select group_name from group_setting where user_id = :user_id and group_id = :group_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
		$stmt->bindValue(':group_id',$id, PDO::PARAM_INT);
		$stmt->execute();
		$group_name0 = $stmt->fetch();

}else{
		$id = '1';
		$sql = "select group_name from group_setting where user_id = :user_id and group_id = :group_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
		$stmt->bindValue(':group_id',$id, PDO::PARAM_INT);
		$stmt->execute();
		$group_name0 = $stmt->fetch();

}


//group_idのメニュー１〜６を取得
for ($display_position = 1; $display_position <= 6; $display_position=$display_position+1){
		$sql3 = "select * from food where user_id = :user_id and group_id = :group_id and display_position = :display_position";
		$stmt3 = $pdo->prepare($sql3);
		$stmt3->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
		$stmt3->bindValue(':group_id',$id, PDO::PARAM_INT);
		$stmt3->bindValue(':display_position',$display_position, PDO::PARAM_INT);
		$stmt3->execute();
		${'food_menu'.$display_position} = $stmt3->fetchall();
}



$food_menu1[0]['price']= number_format($food_menu1[0]['price']);
$food_menu2[0]['price']= number_format($food_menu2[0]['price']);
$food_menu3[0]['price']= number_format($food_menu3[0]['price']);
$food_menu4[0]['price']= number_format($food_menu4[0]['price']);
$food_menu5[0]['price']= number_format($food_menu5[0]['price']);
$food_menu6[0]['price']= number_format($food_menu6[0]['price']);
$sum_price= number_format($sum_price);



if ($_SERVER['REQUEST_METHOD'] != 'GET') {

// CSRF対策↓
checkToken();


//メニューを注文カートに入れる処理
for ($display_position = 1; $display_position <= 6; $display_position=$display_position+1){
		${'order'.$display_position} = $_POST['order'.$display_position];
		if(${'order'.$display_position}){
				if(${'food_menu'.$display_position}[0]){
						$_SESSION['order'][]=${'food_menu'.$display_position}[0];
						$foodmenu = ${'food_menu'.$display_position}[0][2];
						$info="'$foodmenu'を注文カートに入れました。";
				}else{
						error_log(date("Y/m/d H:i:s"). basename(__FILE__)."で404エラーが発生しました。", 1, "goalhunter.kazu@gmail.com");
						header('Location: '.SITE_URL.'404_order.php');
				}
		}
}





// スタッフを呼ぶボタンが押されたら
$staff = $_POST['staff'];
if($staff){
		// 管理者にメールを送信"
		mb_language("japanese");
		mb_internal_encoding("UTF-8");
		// 差出人
		$mailfrom="From:" .mb_encode_mimeheader("TABLET ORDER SYSTEM") ."<kazu@tablet-order-system.com>";
		$mail_title = '【'.$login_table.'番テーブル】お客様からの呼び出しがあります。';
		$mail_body = $login_table.'番テーブル'.PHP_EOL.PHP_EOL;
		$mail_body.= 'お客様からの呼び出しがあります。';
		mb_send_mail($user['order_pc_email'], $mail_title, $mail_body, $mailfrom);

		// staff_call テーブルに呼び出し記録を保存"
		$sql = "insert into staff_call
		    (user_id,order_table,order_date,taiou,created_at,updated_at)
		    values
		    (:user_id,:order_table,:order_date,:taiou,now(), now())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':order_table',$login_table, PDO::PARAM_INT);
    $stmt->bindValue(':order_date',date("Y/m/d H:i:s"), PDO::PARAM_STR);
		$stmt->bindValue(':taiou','未対応', PDO::PARAM_STR);
    $stmt->execute();
}


// 一度に１１品以上注文されたらエラー表示
if($_SESSION['order']['10']){
		$limit10 ='一度に注文できるのは10品までです。';
		$info='';
}

//合計金額
$sum_price =
$_SESSION['order']['0']['8']+$_SESSION['order']['1']['8']+$_SESSION['order']['2']['8']
+$_SESSION['order']['3']['8']+$_SESSION['order']['4']['8']+$_SESSION['order']['5']['8']
+$_SESSION['order']['6']['8']+$_SESSION['order']['7']['8']+$_SESSION['order']['8']['8']+$_SESSION['order']['9']['8'];

$sum_price= number_format($sum_price);

} else {

// CSRF対策↓
setToken();

//合計金額
$sum_price =
$_SESSION['order']['0']['8']+$_SESSION['order']['1']['8']+$_SESSION['order']['2']['8']
+$_SESSION['order']['3']['8']+$_SESSION['order']['4']['8']+$_SESSION['order']['5']['8']
+$_SESSION['order']['6']['8']+$_SESSION['order']['7']['8']+$_SESSION['order']['8']['8']+$_SESSION['order']['9']['8'];

$sum_price= number_format($sum_price);

unset($pdo);

}


?>

<!DOCTYPE html>

<html lang="ja">

		<head>
				<title>注文画面 | <?php echo SERVICE_NAME; ?></title>
				<?php include("./head_meta.php"); ?>

				<style>

						@media screen and (max-width: 3000px) {

						#logo{
						float: right;
						margin-right: 0px;
						}

						#logo_area{
						float: right;
						margin-right: 0px;
						width: 140px;
						height: 70px;

						}

						#logo_area_td{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/logo/<?php echo h($user_logo['image_name']); ?>");
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}


						.menu_food_name{
						color: black;
						font-size:18px;
						font-weight: bold;
						}

						#menu1{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/<?php echo h($food_menu1[0]['image_name']); ?>");
						color: black;
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}
						#menu2{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/<?php echo h($food_menu2[0]['image_name']); ?>");
						color: black;
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}
						#menu3{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/<?php echo h($food_menu3[0]['image_name']); ?>");
						color: black;
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}
						#menu4{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/<?php echo h($food_menu4[0]['image_name']); ?>");
						color: black;
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}
						#menu5{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/<?php echo h($food_menu5[0]['image_name']); ?>");
						color: black;
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}
						#menu6{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/<?php echo h($food_menu6[0]['image_name']); ?>");
						color: black;
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}

						#注文する{
						font-size:16px;
						margin-bottom:20px;
						font-weight: bold;
						}
						#注文履歴{
						font-size:16px;
						margin-top:10px;
						margin-bottom:10px;
						font-weight: bold;
						}

						#スタッフを呼ぶ{
						font-size:16px;
						font-weight: bold;

						}

						#group_and_menu{
						font-size:20px;
						font-weight: bold;
						margin-bottom:30px;
						}

						#１０品まで{
						font-size:14px;
						font-weight: bold;
						}

						#limit10{
						font-size:10px;
						font-weight: bold;
						}

						#info{
						font-size:16px;
						font-weight: bold;
						}

						#group_name{
						font-size:20px;
						font-weight: bold;
						}


						.panel-heading{
						font-size:14px;
						}

						.panel-body{
						font-size:14px;
						}

						#group_list1{
						margin-bottom:0px;
						}

						#NO_MENU {
						font-size: 28px;
						color: white;
						font-weight: bold;
						display: flex;
						align-items: center;
						justify-content: center;
						padding: 0;
						margin: 0;
						list-style: none;
						}

						.price{
						font-size: 18px;
						font-weight: bold;
						}

						.売切れです。{
						font-size: 20px;
						color: red;
						}

						#売切れ表示{
						font-size: 16px;
						font-weight: bold;
						color: red;
						}

						#grid1{
						display: grid;
						grid-template-columns: 1fr 1fr 1fr;
						gap: 10px;
						margin-right: 0px;
						margin-left: 0px;
						}
						}

						/*ipad 長*/
						@media screen and (max-width: 1024px){

						#１０品まで{
						font-size:12px;
						font-weight: bold;
						}

						.menu_food_name{
						color: black;
						font-size:13px;
						font-weight: bold;
						}

						#グループ名{
						color: black;
						font-size:10px;
						font-weight: bold;
						}

						}

						@media screen and (max-width: 768px) {

						.menu_food_name{
						color: black;
						font-size:12px;
						font-weight: bold;
						}

						.btn-default{
						font-size: 9px;
						}

						.btn-info{
						font-size: 9px;
						}



						#logo{
						float: right;
						margin-right: 0px;
						}

						#logo_area{
						float: right;
						margin-right: 0px;
						margin-top: 10px;
						width: 120px;
						height: 60px;

						}

						#logo_area_td{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/logo/<?php echo h($user_logo['image_name']); ?>");
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}

						#grid1{
						display: grid;
						gap: 5px;
						margin-right: 0px;
						margin-left: 0px;
						}

						#グループ名{
						color: black;
						font-size:7px;
						font-weight: bold;
						}

						}

						/*iphone 縦幅(横)*/
						@media screen and (max-width: 736px){

						.br-携帯長 { display:none; }
						.br-携帯短 { display:none; }

						.menu_food_name{
						color: black;
						font-size:10px;
						font-weight: bold;
						}

						#グループ名{
						color: black;
						font-size:6px;
						font-weight: bold;
						}

						#logo{
						float: right;
						margin-right: 0px;
						}

						#logo_area{
						float: left;
						margin-right: 0px;
						width: 150px;
						height: 75px;
						}

						#logo_area_td{
						background-image: url("https://tablet-order-system.com/images/test/<?php echo h($photo_directory); ?>/logo/<?php echo h($user_logo['image_name']); ?>");
						background-repeat:no-repeat;
						background-size: cover;
						background-position: center center;
						}

						}

						@media screen and (max-width: 414px){

						.menu_food_name{
						color: black;
						font-size:14px;
						font-weight: bold;
						}

						#logo_area{
						float: left;
						margin-right: 0px;
						width: 100px;
						height: 50px;
						}

						#grid1{
						display: grid;
						grid-template-columns: 1fr;
						gap: 10px;
						margin-right: 0px;
						margin-left: 0px;
						}

						h1{
						font-size: 24px;
						margin-top: 5px;
						margin-bottom: 0px;
						}

						#info{
						font-size: 12px;
						}

						}

				</style>

		</head>



		<body id="main">

				<div class="container-fluid">

								<div class="nav navbar-inverse navbar-fixed-top">
										<div class="navbar-inner">
												<a class="navbar-brand" href="" id="table_number">テーブル番号:<?php echo h($login_table); ?></a>
										</div>
								</div>


							<div class="row">
											<div class="col-sm-6">
													<h1><b>注文画面</b></h1>
											</div>

											<div class="col-sm-6" >
													<?php if ($user_logo):?>
														<table id="logo_area"border="0">
																<td id="logo_area_td"></td>
														</table>
													<?php endif; ?>
											</div>
							</div>


							<div class="row">
										<div class="col-md-12">
												<hr>

													<div class="btn-group btn-group-justified" role="group">
															<?php for($i = 1; $i <= 8; $i=$i+1):?>
																	<a href="order.php?id=<?php echo h($group_id[$i]); ?>"
																	<?php if ($id == $i):?>
																			<?php echo "class=\"btn btn-info\""?>
																	<?php else: ?>
																			<?php  echo "class=\"btn btn-default\"" ?>
																	<?php endif; ?>class="btn btn-default" role="button" id="グループ名"><?php echo  h($group_name[$i]); ?></a>
															<?php endfor ;?>
				                  </div><!--/btn-group btn-group-justified-->

													<div class="btn-group btn-group-justified" role="group">
															<?php for($i = 9; $i <= 16; $i=$i+1):?>
																	<a href="order.php?id=<?php echo h($group_id[$i]); ?>"
																	<?php if ($id == $i):?>
																			<?php echo "class=\"btn btn-info\""?>
																	<?php else: ?>
																			<?php  echo "class=\"btn btn-default\"" ?>
																	<?php endif; ?>class="btn btn-default" role="button" id="グループ名"><?php echo  h($group_name[$i]); ?></a>
															<?php endfor ;?>
													</div><!--/btn-group btn-group-justified-->

													<br>
										</div><!--/col-md-12-->
								</div><!--/row-->





								<div class="row">

											<form method="POST" class="panel-body">

											<div class="col-md-9">

													<div class="row">

															<?php if ($info): ?>
																		<div id="info" class="alert alert-success">
																					<?php echo h($info); ?>
																		</div>
															<?php endif; ?>

															<?php if ($limit10): ?>
																		<div id="info" class="alert alert-danger">
																					<?php echo h($limit10); ?>
																		</div>
															<?php endif; ?>


														　<div class="col-md-12" id ="grid1">

																	<?php for($i = 1; $i <= 6; $i=$i+1):?>
																				<?php if (!${'food_menu'.$i}[0]['food_name']==null):?>
																						<!--/メニューがある-->
																						<?php if (${'food_menu'.$i}[0]['sold_out']==null):?>
																								<!--/売切れじゃない場合-->
																								<div  class="item">
																										<table border="1" class="grid_table">
																													<tr>
																															<th class="menu_food_name"><?php echo h(${'food_menu'.$i}[0]['food_name']); ?></th>
																													</tr>
																													<tr>
																															<td id="menu<?php echo h($i); ?>"><br><br><br><br><br><br><br><br><br></td>
																													</tr>

																													<tr>
																															<td class="price"><?php echo h(${'food_menu'.$i}[0]['price']); ?>円</td>
																													</tr>
																													<tr>
																															<td><form action="order.php">
																															<input type="submit" onclick="order_cart();" value="注文カートに送る" name="order<?php echo h($i); ?>"class="btn-group btn-group-justified">
																															</td>
																													</tr>
																										</table>
																								</div>
																						<?php else: ?>
																								<!--/売切れの場合-->
																								<div  class="item">
																										<table border="1" class="grid_table">
																													<tr>
																															<th class="menu_food_name"><?php echo h(${'food_menu'.$i}[0]['food_name']); ?></th>
																													</tr>
																													<tr>
																															<td id="menu<?php echo h($i); ?>"><br><br><br><br><br><br><br><br><br></td>
																													</tr>

																													<tr>
																															<td class="price"><?php echo h(${'food_menu'.$i}[0]['price']); ?>円</td>
																													</tr>
																													<tr>
																															<td>
																															<input type="button" value="売切れ" class="btn-group btn-group-justified" id="売切れ表示">
																															</td>
																															</td>
																													</tr>
																										</table>
																								</div>
																						<?php endif; ?>
																				<?php else: ?>
																						<!--/メニューがない-->
																						<div class="item" id="NO_MENU">NO MENU
																						</div>
																				<?php endif; ?>
																		<?php endfor ;?>

																</div><!--/col-md-12-->
														</div><!--/row-->      <br>

											</div><!--/col-md-9-->

											<div class="col-md-3">

													<div class="panel panel-default">
																<div class="panel-heading">
																		注文カート
																</div>

																<div class="panel-body">
																			<p id="１０品まで">一度に１０品まで注文できます。<br>メニューをキャンセルする場合は<br>緑色の注文するボタンを押して<br>注文確認画面で削除して下さい。</p>
																			<?php echo h($_SESSION['order']['0']['2']); ?><br>
																			<?php echo h($_SESSION['order']['1']['2']); ?><br>
																			<?php echo h($_SESSION['order']['2']['2']); ?><br>
																			<?php echo h($_SESSION['order']['3']['2']); ?><br>
																			<?php echo h($_SESSION['order']['4']['2']); ?><br>
																			<?php echo h($_SESSION['order']['5']['2']); ?><br>
																			<?php echo h($_SESSION['order']['6']['2']); ?><br>
																			<?php echo h($_SESSION['order']['7']['2']); ?><br>
																			<?php echo h($_SESSION['order']['8']['2']); ?><br>
																			<?php echo h($_SESSION['order']['9']['2']); ?><br>
																			<br>
																</div>
													</div>

													<div class="panel panel-default">
																<div class="panel-heading">
																		合計金額
																</div>
																<div class="panel-body">
																		<?php echo h($sum_price); ?>円
																</div>
													</div>


													<div class="btn-group btn-group-justified">
															<a href="order_kakunin.php" id="注文する" class="btn btn-success btn-block" role="button" >注文する</a>
													</div>

													<a href="order_rireki.php" id="注文履歴" class="btn btn-primary btn-block" role="button" >注文履歴を見る/会計する</a>


													<form action="order.php">
															<input type="submit" id="スタッフを呼ぶ" value="スタッフを呼ぶ" name="staff" class="btn btn-info btn-block">
															<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
													</form>


											</div><!--/col-md-3-->

								</div><!--/row-->


								<hr>

								<!-- start footer section -->
		            <?php include("./common_footer_order.php"); ?>
		            <!-- end footer section -->

								</div><!--/.container-->
								<?php include("./script.php"); ?>


		</body>



</html>
