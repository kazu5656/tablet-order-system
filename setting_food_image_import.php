<?php

require_once('config.php');
require_once('functions.php');
session_start();



$pdo = connectDb();

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}

// セッションからユーザ情報を取得
$user = $_SESSION['tablet_order_system_setting'];
$photo_directory = $user['photo_directory'];
define( "FILE_DIR", "images/test/$photo_directory/");

$i = 0;


if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // 初めて画面にアクセスした時の処理
    $complete_msg = "";

    // CSRF対策
    setToken();

    if(!$_GET['id']){
        echo "この表示位置にはメニューが登録されていません。メニュー登録後に写真を登録してください。<br/>";
        echo ("<a href=\"setting_food_menu.php\">戻る</a><br/>");
        exit(1);
    }

    $id = $_GET['id'];
    $_SESSION['id'] = $id;

    $sql0 = "select * from food where id = :id limit 1";
    $stmt0 = $pdo->prepare($sql0);
    $stmt0->bindValue(":id",$_SESSION['id'], PDO:: PARAM_INT);
    $stmt0->execute();
    $item0 = $stmt0->fetch();

} else {

    // CSRF対策
    checkToken();

    $str_rand = makeRandStr(12);

    //ファイルアップロードがあったとき
    if (isset($_FILES['upfile']['error'][$i]) && is_int($_FILES['upfile']['error'][$i]) && $_FILES["upfile"]["name"][$i] !== ""){

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
            echo ("<a href=\"image_import.php\">戻る</a><br/>");
            exit(1);
    }

    //DBに格納するファイルネーム設定
    //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
    $date = getdate();
    $fname = $_FILES["upfile"]["tmp_name"][$i].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
    $fname = hash("sha256", $fname);


    $id =  $_SESSION['id'];
    $sql = "select * from food where id = :id limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":id"=>$id));
    $item = $stmt->fetch();

    $food_name = $item['food_name'];
    $comment = $item['comment'];
    $price = $item['price'];
    $group_id = $item['group_id'];
    $display_position = $item['display_position'];

    //画像・動画をDBに格納．
    $sql = "UPDATE food SET
                user_id = :user_id,
                food_name = :food_name,
                image_name = :image_name,
                fname = :fname,
                extension = :extension,
                raw_data = :raw_data,
                comment = :comment,
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
    $stmt -> bindValue(':comment',$comment, PDO::PARAM_STR);
    $stmt -> bindValue(':price',$price, PDO::PARAM_INT);
    $stmt -> bindValue(':group_id',$group_id, PDO::PARAM_INT);
    $stmt -> bindValue(':display_position',$display_position, PDO::PARAM_INT);
    $stmt->bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->execute();

    //move_uploaded_file
    $upload_res = move_uploaded_file( $_FILES['upfile']['tmp_name'][$i], FILE_DIR.$image_name);
    $complete_msg = "インポートが完了しました。";
    }
}
?>


<!DOCTYPE html>

<html lang="ja">

    <head>
        <title>新規登録 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>
    </head>



    <body id="main">

        <?php include("./common_header_setting.php"); ?>
        <div class="container-fluid">
            <h1><b>写真を登録</b></h1>
            <h4>メニュー名：<?php echo h($item0['food_name']); ?><h4>

            <?php if ($complete_msg): ?>
                <div class="alert alert-success">
                <?php echo h($complete_msg); ?>
                </div>
            <?php endif; ?>

            <div class="panel panel-default panel-body">
                <form action="setting_food_image_import.php" enctype="multipart/form-data" method="POST">
                    <input type="file" name="upfile[]">
                    <br>
                    ※写真はjpg、png、gifをインポートできます。<br>
                    <br>
                    <input type="submit" value="インポート" class="btn btn-primary btn-block">
                    <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                </form>
            </div>
            <hr>

            <?php include("./common_footer.php"); ?>

        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
