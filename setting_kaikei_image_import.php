<?php

require_once('config.php');
require_once('functions.php');
session_start();

$pdo = connectDb();

// エラー出力しない場合
ini_set('display_errors', 0);

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}

// セッションからユーザ情報を取得
$user = $_SESSION['tablet_order_system_setting'];
$photo_directory = $user['photo_directory'];
define( "FILE_DIR", "images/test/$photo_directory/thank_you/");



// 会計ページの写真があるかチェック
$user_okaikei_photo = array();
$sql = "select * from user where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
$user_okaikei_photo = $stmt->fetch();



$i = 0;


if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // 初めて画面にアクセスした時の処理
    $complete_msg = "";

    // CSRF対策
    setToken();


} else {

    // CSRF対策
    checkToken();

    $str_rand = makeRandStr(8);

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
            echo ("<a href=\"setting_kaikei_image_import.php\">戻る</a><br/>");
            exit(1);
        }

        //DBに格納するファイルネーム設定
        //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
        $date = getdate();
        $fname = $_FILES["upfile"]["tmp_name"][$i].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
        $fname = hash("sha256", $fname);

        unlink("/home/kazu0520/www/tablet_order_system/web/images/test/$photo_directory/thank_you/$user[image_name]");

        //画像・動画をDBに格納．
        $sql = "UPDATE user SET
        image_name = :image_name,
        fname = :fname,
        extension = :extension,
        raw_data = :raw_data,
        updated_at = now()
        where id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(':image_name',$image_name, PDO::PARAM_STR);
        $stmt -> bindValue(':fname',$fname, PDO::PARAM_STR);
        $stmt -> bindValue(':extension',$extension, PDO::PARAM_STR);
        $stmt -> bindValue(':raw_data',$raw_data, PDO::PARAM_STR);
        $stmt -> bindValue(':id',$user['id'], PDO::PARAM_STR);
        $stmt->execute();

        //move_uploaded_file
        $upload_res = move_uploaded_file( $_FILES['upfile']['tmp_name'][$i], FILE_DIR.$image_name);

        $sql2 = "select * from user where id = :id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2 -> bindValue(':id',$user['id'], PDO::PARAM_STR);
        $stmt2->execute();
        $user2 = $stmt2->fetch();

        // ログインに成功したのでセッションにユーザデータを保存する。
        $_SESSION['tablet_order_system_setting'] = $user2;

        $user = $_SESSION['tablet_order_system_setting'];

        $complete_msg = "インポートが完了しました。";

        
    }

}
?>


<!DOCTYPE html>

<html lang="ja">

    <head>

        <?php include("./head_meta.php"); ?>
        <title>会計ページ写真登録 | <?php echo SERVICE_NAME; ?></title>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            p{
            font-size:15px;
            }

            }

            @media screen and (max-width: 414px) {

            h1{
            font-size:24px;
            }

            p{
            font-size:12px;
            }

            }

        </style>

    </head>



    <body id="main">

                <?php include("./common_header_setting.php"); ?>
                <div class="container-fluid">

                      <h1>会計ページ写真登録</h1>

                      <p><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#会計ページ写真・注文ページカラー変更"target="_blank">→会計ページ用写真を登録する方法</a></p>

                      <?php if ($complete_msg): ?>
                          <div class="alert alert-success">
                              <?php echo h($complete_msg); ?>
                          </div>
                      <?php endif; ?>

                       <hr>

                       <div class="row">

        									<div class="col-md-12">
            									<div id="panel"class="panel panel-default panel-body">

                                  <form action="setting_kaikei_image_import.php" enctype="multipart/form-data" method="POST">
                                      <input type="file" name="upfile[]">
                                      <br>
                                      <p>※写真はjpg、png、gifをインポートできます。</p>
                                      <input type="submit" value="写真を登録する" class="btn btn-primary btn-block">
                                      <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                                  </form>

            									</div><!--/panel panel-default panel-body-->
        									</div><!--/col-md-12-->

                      </div><!--/row-->
                      <hr>
                      <?php include("./common_footer.php"); ?>

                </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
