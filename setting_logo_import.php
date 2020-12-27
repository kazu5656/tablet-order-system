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
define( "FILE_DIR", "images/test/$photo_directory/logo/");

$user_logo = array();
$sql = "select * from logo where user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
$user_logo = $stmt->fetch();


$i = 0;


if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // 初めて画面にアクセスした時の処理
    $complete_msg = "";

    // CSRF対策
    setToken();


} else {

    // CSRF対策
    checkToken();

    // 会計ページの写真があるかチェック
    $user_logo = array();
    $sql = "select * from logo where user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->execute();
    $user_logo = $stmt->fetch();

    $str_rand = makeRandStr(8);

    //ファイルアップロードがあったとき スタート
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

        $user_logo2 = $user_logo['image_name'];

        if($user_logo){

            unlink("/var/app/tablet_order_system/web/images/test/$photo_directory/logo/$user_logo2");

            //更新
            $sql = "UPDATE logo SET
            image_name = :image_name,
            fname = :fname,
            extension = :extension,
            raw_data = :raw_data,
            updated_at = now()
            where user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt -> bindValue(':image_name',$image_name, PDO::PARAM_STR);
            $stmt -> bindValue(':fname',$fname, PDO::PARAM_STR);
            $stmt -> bindValue(':extension',$extension, PDO::PARAM_STR);
            $stmt -> bindValue(':raw_data',$raw_data, PDO::PARAM_STR);
            $stmt -> bindValue(':user_id',$user['id'], PDO::PARAM_STR);
            $stmt->execute();

            //move_uploaded_file
            $upload_res = move_uploaded_file( $_FILES['upfile']['tmp_name'][$i], FILE_DIR.$image_name);


        }else{

            //新規登録
            $sql = "insert into logo
            (user_id,image_name,fname,extension,raw_data,created_at,updated_at)
            values
            (:user_id,:image_name,:fname,:extension,:raw_data,now(),now())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
            $stmt -> bindValue(':image_name',$image_name, PDO::PARAM_STR);
            $stmt -> bindValue(':fname',$fname, PDO::PARAM_STR);
            $stmt -> bindValue(':extension',$extension, PDO::PARAM_STR);
            $stmt -> bindValue(':raw_data',$raw_data, PDO::PARAM_STR);
            $stmt->execute();

            //move_uploaded_file
            $upload_res = move_uploaded_file( $_FILES['upfile']['tmp_name'][$i], FILE_DIR.$image_name);

        }

        $complete_msg = "インポートが完了しました。";

    }//ファイルアップロードがあったとき 終了

}

?>


<!DOCTYPE html>

<html lang="ja">

    <head>

        <?php include("./head_meta.php"); ?>
        <title>注文ページロゴ登録 | <?php echo SERVICE_NAME; ?></title>

        <style>

            @media screen and (max-width: 3000px) {

            .br-pc { display:none; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            h1{
            font-size:28px;
            }

            p{
            font-size:15px;
            }

            #ロゴを削除ボタン{
            margin-top: 5px;
            }

            }

            @media screen and (max-width: 414px) {

            .br-pc { display:none; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:block; }

            h1{
            font-size:26px;
            }

            p{
            font-size:12px;
            }

            }

        </style>

    </head>



    <body>

        <?php include("./common_header_setting.php"); ?>
        <div class="container-fluid">
              <h1>注文ページロゴ登録</h1>
              <p><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#注文画面にお店のロゴを表示する"target="_blank">→注文ページにロゴを登録する方法をビデオで見る。</a></p>
              <p>
                注文画面に飲食店のロゴを表示する場合は<br class="br-携帯短" />登録して下さい。
              </p>

              <?php if ($complete_msg): ?>
                  <div class="alert alert-success">
                      <?php echo h($complete_msg); ?>
                  </div>
              <?php endif; ?>

               <hr>

               <div class="row">
                  <div class="col-md-12">
                      <div id="panel"class="panel panel-default panel-body">
                          <form action="setting_logo_import.php" enctype="multipart/form-data" method="POST">
                              <input type="file" name="upfile[]">
                              <br>
                              <p>※縦横比2:1のロゴ写真（jpg、png、gif）をインポートして下さい。<br>
                                例 横幅140px・高さ70px
                              </p>
                              <input type="submit" value="ロゴを登録する" class="btn btn-primary btn-block">
                              <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                              <a href="./delete_logo.php" class="btn btn-danger btn-block" id="ロゴを削除ボタン"
                              onclick="return confirm('登録中のロゴが削除されます。削除しても宜しいですか ?') " >登録中のロゴを削除する</a>
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
