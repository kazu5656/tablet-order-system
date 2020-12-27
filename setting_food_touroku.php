<?php

require_once('config.php');
require_once('functions.php');

session_start();
$pdo = connectDb();

if (!isset($_SESSION['tablet_order_system_setting'])) {
		header('Location: '.SITE_URL.'login_setting.php');
		exit;
}

$user = $_SESSION['tablet_order_system_setting'];
$photo_directory = $user['photo_directory'];
define( "FILE_DIR", "images/test/$photo_directory/");


$group = array();
$sql5 = "SELECT * FROM `group_setting` where user_id = :user_id ORDER BY `group_setting`.`group_id` ASC";
$stmt5 = $pdo->prepare($sql5);
$stmt5->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt5->execute();
foreach ($stmt5->fetchAll() as $row) {
		array_push($group, $row);
}

if(!$group){
		$no_group = 'グループが1つも登録されていません。グループを登録してください。';
}

// 16個のグループネームを取得する
for ($i = 1; $i  <= 16; $i =$i +1){
		$sql = "SELECT group_name FROM `group_setting` where user_id = :user_id and group_id =:group_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':group_id',$i, PDO::PARAM_INT);
    $stmt->execute();
		${'g'.$i} = $stmt->fetch();
		${'group'.$i} = ${'g'.$i} ['group_name'];
}


$group_id_array = array(
		"1" => "$group1",
		"2" => "$group2",
		"3" => "$group3",
		"4" => "$group4",
		"5" => "$group5",
		"6" => "$group6",
		"7" => "$group7",
		"8" => "$group8",
		"9" => "$group9",
		"10" => "$group10",
		"11" => "$group11",
		"12" => "$group12",
		"13" => "$group13",
		"14" => "$group14",
		"15" => "$group15",
		"16" => "$group16",
);

$i = 0;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
// 登録ボタンを押されていない場合　スタート

		// CSRF対策↓
		setToken();

		// パラメータで渡されたアイテムIDを取得
		$id = $_GET['id'];
		$_SESSION['food_id']=$_GET['id'];
		$group_id = $_GET['group_id'];
		$display_position = $_GET['position'];

		$sql = "select * from food where id = :id and user_id = :user_id limit 1";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id',$id, PDO::PARAM_INT);
		$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
		$stmt->execute();
		$item0 = $stmt->fetch();

		if($id){
				if($item0){
						// データがあったら変数に入れる
						$food_name = $item0['food_name'];
						$comment = $item0['comment'];
						$price = $item0['price'];
						$group_id = $item0['group_id'];
						$display_position = $item0['display_position'];
				}else {
						// データが取得出来なかったら404エラーページに遷移
						error_log(date("Y/m/d H:i:s"). basename(__FILE__)." アイテムid＝"."$id"."で404エラーが発生しました。".PHP_EOL, 3, "../logs/error_log");
						error_log(date("Y/m/d H:i:s"). basename(__FILE__)."で404エラーが発生しました。", 1, "goalhunter.kazu@gmail.com");
						header('Location: '.SITE_URL.'404.php');
						exit;
				}
		}

// 登録ボタンを押されていない場合　終了
} else {
// 登録ボタンを押された場合（POST)　スタート

		// CSRF対策↓
		checkToken();
		$str_rand = makeRandStr(12);
		// フォームからサブミットされた時の処理
		// 入力されたニックネーム、メールアドレス、パスワードを受け取り、変数に入れる。
		$food_name = $_POST['food_name'];
		$price = $_POST['price'];
		$group_id = $_POST['group_id'];
		$display_position = $_POST['display_position'];



		if (isset($_FILES['upfile']['error'][$i])
		&& is_int($_FILES['upfile']['error'][$i]) && $_FILES["upfile"]["name"][$i] !== ""){
// ファイルアップロードがある場合 開始

				//ファイルアップロードがあったとき
		    //エラーチェック
		    switch ($_FILES['upfile']['error'][$i]) {
		    case UPLOAD_ERR_OK: // OK
		    break;
		    case UPLOAD_ERR_NO_FILE:   // 未選択
		    throw new RuntimeException('ファイルが選択されていません', 400);
		    case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
		    throw new RuntimeException('ファイルサイズが大きすぎます', 400);
		    default:
		    throw new RuntimeException('その他のエラーが発生しました', 500);
		    }
		    //画像・動画をバイナリデータにする．
		    $raw_data = file_get_contents($_FILES['upfile']['tmp_name'][$i]);
		    //拡張子を見る
		    $tmp = pathinfo($_FILES["upfile"]["name"][$i]);
		    $extension = $tmp["extension"];
				if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
		        $extension = "jpeg";
		        $image_name = $str_rand.".jpg";
		    }
		    elseif($extension === "png" || $extension === "PNG"){
		        $extension = "png";
		        $image_name = $str_rand.".png";
		    }
		    elseif($extension === "gif" || $extension === "GIF"){
		        $extension = "gif";
		        $image_name = $str_rand.".gif";
		    }
		    else{
		        echo "非対応ファイルです．<br/>";
		        echo ("<a href=\"setting_food_touroku.php\">戻る</a><br/>");
		        exit(1);
		    }
		    //DBに格納するファイルネーム設定
		    //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
		    $date = getdate();
		    $fname = $_FILES["upfile"]["tmp_name"][$i].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
		    $fname = hash("sha256", $fname);
		  	$id=$_SESSION['food_id'];

		     // メニューのidがあれば更新、なければ新規登録
		    if(!$id){

						//$idがないので
						//フードメニュー新規登録開始
						// 入力チェックを行う。
						$err = array();
						// [food_name]未入力チェック
						if ($food_name == '') {
								$err['food_name'] = 'メニュー名を入力して下さい。';
						}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($food_name, 'SJIS', 'UTF-8')) > 30) {
										$err['food_name'] = 'メニュー名は15文字以内で入力して下さい。';
								}
						}
						// [price]未入力チェック
						if ($price == '') {
								$err['price'] = '価格（税抜）を入力して下さい。';
						}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($price, 'SJIS', 'UTF-8')) > 30) {
										$err['price'] = '価格（税抜）は30バイト以内で入力して下さい。';
								}
						}
						// [group]未入力チェック
						if ($group_id == '') {
								$err['group_id'] = 'グループを選択して下さい。';
						}
						// [display_position]未入力チェック
						if ($display_position == '') {
								$err['display_position'] = '表示位置を選択して下さい。';
						}
						$group = array();
						$sql5 = "SELECT * FROM `group_setting` where user_id = :user_id ORDER BY `group_setting`.`group_id` ASC";
						$stmt5 = $pdo->prepare($sql5);
						$stmt5->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
						$stmt5->execute();
						foreach ($stmt5->fetchAll() as $row) {
								array_push($group, $row);
						}
						if(!$group){
								$no_group = 'グループが1つも登録されていません。グループを登録してください。';
						}
						// $group_idと$display_positionのメニューを取得する
						$sql = "select * from food where group_id = :group_id and display_position = :display_position
						and user_id = :user_id  limit 1";
						$stmt = $pdo->prepare($sql);
						$stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
						$stmt->bindValue(':display_position',$display_position, PDO::PARAM_INT);
						$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
						$stmt->execute();
						$item = $stmt->fetch();
						// もし$err配列に何もエラーメッセージが保存されていなかったら
						if (empty($err)) {
								// データベース（foodテーブル）に新規登録する。
								$sql = "insert into food
								(user_id,food_name,image_name,fname,extension,raw_data,price,group_id,display_position,created_at,updated_at)
								values
								(:user_id,:food_name,:image_name,:fname,:extension,:raw_data,:price,:group_id,:display_position,now(),now())";
								$stmt = $pdo->prepare($sql);
								$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
								$stmt->bindValue(':food_name',$food_name, PDO::PARAM_STR);
								$stmt -> bindValue(':image_name',$image_name, PDO::PARAM_STR);
								$stmt -> bindValue(':fname',$fname, PDO::PARAM_STR);
								$stmt -> bindValue(':extension',$extension, PDO::PARAM_STR);
								$stmt -> bindValue(':raw_data',$raw_data, PDO::PARAM_STR);
								$stmt->bindValue(':price',$price, PDO::PARAM_INT);
								$stmt->bindValue(':group_id',$group_id, PDO::PARAM_STR);
								$stmt->bindValue(':display_position',$display_position, PDO::PARAM_INT);
								$stmt->execute();
								//move_uploaded_file
								$upload_res = move_uploaded_file( $_FILES['upfile']['tmp_name'][$i], FILE_DIR.$image_name);
								// セッション・ハイジャック対策
								session_regenerate_id(true);
								$complete_msg = "メニューが登録できました。";
						}
						//フードメニュー新規登録完了

		    }else{

						//$idがあるので
						//フードメニュー更新開始
						// 入力チェックを行う。
						$err = array();
						// [food_name]未入力チェック
						if ($food_name == '') {
								$err['food_name'] = 'メニュー名を入力して下さい。';
						}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($food_name, 'SJIS', 'UTF-8')) > 30) {
										$err['food_name'] = 'メニュー名は15文字以内で入力して下さい。';
								}
						}
						// [price]未入力チェック
						if ($price == '') {
								$err['price'] = '価格（税抜）を入力して下さい。';
						}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($price, 'SJIS', 'UTF-8')) > 30) {
										$err['price'] = '価格（税抜）は30バイト以内で入力して下さい。';
								}
						}
						// [group]未入力チェック
						if ($group_id == '') {
								$err['group_id'] = 'グループを選択して下さい。';
						}
						// [display_position]未入力チェック
						if ($display_position == '') {
								$err['display_position'] = '表示位置を選択して下さい。';
						}
						$group = array();
						$sql5 = "SELECT * FROM `group_setting` where user_id = :user_id ORDER BY `group_setting`.`group_id` ASC";
						$stmt5 = $pdo->prepare($sql5);
						$stmt5->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
						$stmt5->execute();
						foreach ($stmt5->fetchAll() as $row) {
								array_push($group, $row);
						}
						if(!$group){
								$no_group = 'グループが1つも登録されていません。グループを登録してください。';
						}
						// もし$err配列に何もエラーメッセージが保存されていなかったら
						if (empty($err)) {
								// データベース（foodテーブル）にアップデートする。
								$sql = "UPDATE food SET
								user_id = :user_id,
								food_name = :food_name,
								image_name = :image_name,
								fname = :fname,
								extension = :extension,
								raw_data = :raw_data,
								price = :price,
								group_id = :group_id,
								display_position = :display_position,
								updated_at = now()
								where id = :id";
								$stmt = $pdo->prepare($sql);
								$stmt -> bindValue(':user_id',$user['id'], PDO::PARAM_STR);
								$stmt -> bindValue(':food_name',$food_name, PDO::PARAM_STR);
								$stmt -> bindValue(':image_name',$image_name, PDO::PARAM_STR);
								$stmt -> bindValue(':fname',$fname, PDO::PARAM_STR);
								$stmt -> bindValue(':extension',$extension, PDO::PARAM_STR);
								$stmt -> bindValue(':raw_data',$raw_data, PDO::PARAM_STR);
								$stmt -> bindValue(':price',$price, PDO::PARAM_INT);
								$stmt -> bindValue(':group_id',$group_id, PDO::PARAM_INT);
								$stmt -> bindValue(':display_position',$display_position, PDO::PARAM_INT);
								$stmt->bindValue(':id',$id, PDO::PARAM_INT);
								$stmt->execute();
								//move_uploaded_file
								$upload_res = move_uploaded_file( $_FILES['upfile']['tmp_name'][$i], FILE_DIR.$image_name);
								// セッション・ハイジャック対策
								session_regenerate_id(true);
								$complete_msg = "メニューが更新されました。";
						}
						//フードメニュー更新終了

		    }


// ファイルアップロードがある場合 終了
		}else{
// ファイルアップロードがない場合 スタート

			$id=$_SESSION['food_id'];

			if(!$id){

					// ファイルアップロードがない、かつ、$idがない（登録メニューがない）場合は写真をアップロードのエラー表示　開始
					// 入力チェックを行う。
					$err = array();
			  	//写真アップロードがなかったら
			  	$err['upfile[]'] = '写真をアップロードして下さい。';
					// [food_name]未入力チェック
					if ($food_name == '') {
							$err['food_name'] = 'メニュー名を入力して下さい。';
					}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($food_name, 'SJIS', 'UTF-8')) > 30) {
										$err['food_name'] = 'メニュー名は15文字以内で入力して下さい。';
								}
					}
					// [price]未入力チェック
					if ($price == '') {
							$err['price'] = '価格（税抜）を入力して下さい。';
					}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($price, 'SJIS', 'UTF-8')) > 30) {
										$err['price'] = '価格（税抜）は30バイト以内で入力して下さい。';
								}
					}
					// ファイルアップロードがない、かつ、$idがない（登録メニューがない）場合は写真をアップロードのエラー表示 終了

			}else{

					// ファイルアップロードがないが、$idがある（登録メニューがある）場合は、その他のデータを更新 開始
					// 入力チェックを行う。
					$err = array();
					// [food_name]未入力チェック
					if ($food_name == '') {
							$err['food_name'] = 'メニュー名を入力して下さい。';
					}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($food_name, 'SJIS', 'UTF-8')) > 30) {
										$err['food_name'] = 'メニュー名は15文字以内で入力して下さい。';
								}
					}
					// [price]未入力チェック
					if ($price == '') {
							$err['price'] = '価格（税抜）を入力して下さい。';
					}else {
								// 文字数チェック
								if (strlen(mb_convert_encoding($price, 'SJIS', 'UTF-8')) > 30) {
										$err['price'] = '価格（税抜）は30バイト以内で入力して下さい。';
								}
					}
					// [group]未入力チェック
					if ($group_id == '') {
							$err['group_id'] = 'グループを選択して下さい。';
					}
					// [display_position]未入力チェック
					if ($display_position == '') {
							$err['display_position'] = '表示位置を選択して下さい。';
					}
					$group = array();
					$sql5 = "SELECT * FROM `group_setting` where user_id = :user_id ORDER BY `group_setting`.`group_id` ASC";
					$stmt5 = $pdo->prepare($sql5);
					$stmt5->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
					$stmt5->execute();
					foreach ($stmt5->fetchAll() as $row) {
					array_push($group, $row);
					}
					if(!$group){
							$no_group = 'グループが1つも登録されていません。グループを登録してください。';
					}
					// もし$err配列に何もエラーメッセージが保存されていなかったら
					if (empty($err)) {
							// データベース（foodテーブル）にアップデートする。
							$sql = "UPDATE food SET
							user_id = :user_id,
							food_name = :food_name,
							price = :price,
							group_id = :group_id,
							display_position = :display_position,
							updated_at = now()
							where id = :id";
							$stmt = $pdo->prepare($sql);
							$stmt -> bindValue(':user_id',$user['id'], PDO::PARAM_STR);
							$stmt -> bindValue(':food_name',$food_name, PDO::PARAM_STR);
							$stmt -> bindValue(':price',$price, PDO::PARAM_INT);
							$stmt -> bindValue(':group_id',$group_id, PDO::PARAM_INT);
							$stmt -> bindValue(':display_position',$display_position, PDO::PARAM_INT);
							$stmt->bindValue(':id',$id, PDO::PARAM_INT);
							$stmt->execute();
							// セッション・ハイジャック対策
							session_regenerate_id(true);
							$complete_msg = "メニューが更新されました。";
					}
					// ファイルアップロードがないが、$idがある（登録メニューがある）場合は、その他のデータを更新 終了

			}

// ファイルアップロードがない場合 終了
	  }

unset($pdo);

// 登録ボタンを押された場合（POST) 終了
}

?>

<!DOCTYPE html>

<html lang="ja">

		<head>

				<meta charset="utf-8">
				<title>メニュー登録 | <?php echo  SERVICE_NAME ; ?></title>
				<?php include("./head_meta.php"); ?>

				<style>

						#登録{
						font-size:16px;

						}
						#メニュー設定に戻る{
						font-size:16px;

						}
						.help-block{
						color:red;
						}

						#入力欄{
						width:100%;
						}

						#グループ新規登録する{
						width:100%;
						margin-top: 0px;
						}

						@media screen and (max-width: 414px) {

						.btn-success{
						font-size:12px;

						}

						.btn-primary{
						font-size:12px;
						}

						.btn-info{
						font-size:12px;
						}

						}

				</style>

		</head>


		<body id="main">
				<?php include("./common_header_setting.php"); ?>
				<div class="container-fluid">

				<h1>メニュー登録</h1>
				<?php if ($complete_msg): ?>
				    <div class="alert alert-success">
				    <?php echo h($complete_msg); ?>
				    </div>
				<?php endif; ?>



				<?php if ($no_group): ?>
				    <div class="alert alert-danger">
				    <?php echo h($no_group); ?>
				    </div>
						<a href="setting_group_touroku.php" class="btn btn-success" id= "グループ新規登録する"role="button">グループ新規登録する</a>
				<?php endif; ?>




				<div class="panel-body">
						<div id="demo_form">
								<div class="form-group <?php if (isset($err['upfile[]']) && $err['upfile[]'] != '') echo 'has-error'; ?>">

										<form action="setting_food_touroku.php" enctype="multipart/form-data" method="POST"class="panel panel-default panel-body">
										<label>写真</label> <br>
										<input type="file" name="upfile[]">
										※写真はjpg、png、gifをインポートできます。
										<span class="help-block"><?php if (isset($err['upfile[]'])) echo h($err['upfile[]']); ?></span>

				            <form class="demo_form" method="POST" class="panel panel-default panel-body">

						            <div class="form-group <?php if (isset($err['food_name']) && $err['food_name'] != '') echo 'has-error'; ?>">
						                <label>名前</label> <br>
						                <input class="validate[required,maxSize[15]]" type="text" name="food_name" id="入力欄" value="<?php echo h($food_name) ?>" placeholder="例:サーロインステーキ(15文字以内)" />
														<span class="help-block"><?php if (isset($err['food_name'])) echo h($err['food_name']); ?></span>
						            </div>

						            <div class="form-group <?php if (isset($err['price']) && $err['price'] != '') echo 'has-error'; ?>">
						                <label>価格（税抜）</label>   <br>
						                <input class="validate[required,max[1000000]]" type="text" name="price" id="入力欄" value="<?php echo h($price) ?>" placeholder="例:2000" />
														<span class="help-block"><?php if (isset($err['price'])) echo h($err['price']); ?></span>
						            </div>

						            <div class="form-group <?php if ($err['group_id'] != '') echo 'has-error'; ?>" >
						                <label>グループ</label>
						                <?php echo arrayToSelect("group_id", $group_id_array, $group_id); ?>
						            </div>



						            <div class="form-group <?php if ($err['display_position'] != '') echo 'has-error'; ?>">
						                <label>表示位置</label>
						                <?php echo arrayToSelect("display_position", $display_position_array, $display_position); ?>
						                <span class="help-block"><?php echo h($err['display_position']); ?></span>
						            </div>

						            <br>

						            <div class="form-group">
						            		<input type="submit"  id="登録" value="登録" class="btn btn-primary btn-block">
														<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
						            </div>



												<div class="btn-group btn-group-justified" role="group">
														<a href="setting_group.php" class="btn btn-info" role="button">グループ設定に戻る</a>
														<a href="setting_food.php" class="btn btn-success" role="button">メニュー設定に戻る</a>
												</div>

				        		</form>

				        </div><!--/form-group-->
				    </div><!--/demo_form-->
				</div><!--/.panel-body-->

				<hr>
				<?php include("./common_footer.php"); ?>

				</div><!--/.container-fluid-->
				<?php include("./script.php"); ?>


		</body>



</html>
