<?php


// エラー出力しない場合
ini_set('display_errors', 0);

require_once('config.php');
require_once('functions.php');

session_start();

$pdo = connectDb();

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}



$user = $_SESSION['tablet_order_system_setting'];
$user_file1 = $user['user_email'];


// 会計時の写真の名前を取得
$kaikei_image_name = array();
$sql = "select image_name from user where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":id" => $user['id']));
$stmt->execute();
foreach ($stmt->fetchAll() as $row) {
    array_push($kaikei_image_name, $row);
}


// メニューの写真の名前を取得
$food_image_name = array();
$sql = "select image_name from food where user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":user_id" => $user['id']));
$stmt->execute();
foreach ($stmt->fetchAll() as $row) {
    array_push($food_image_name, $row);
}



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策
    setToken();

    $user_name = $user['user_name'];
    $user_email = $user['user_email'];
    $order_pc_email = $user['order_pc_email'];
    $user_phone_number = $user['user_phone_number'];
    $name_restaurant = $user['name_restaurant'];
    $zip = $user['zip'];
    $addr1 = $user['addr1'];
    $addr2 = $user['addr2'];
    $user_password = $user['user_password'];


} else {
    // CSRF対策
    checkToken();

    $user_id = $user['id'];


    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_phone_number = $_POST['user_phone_number'];
    $order_pc_email	 = $_POST['order_pc_email'];
    $name_restaurant = $_POST['name_restaurant'];
    $zip = $_POST['zip'];
    $addr1 = $_POST['addr1'];
    $addr2 = $_POST['addr2'];
    $user_password = $_POST['user_password'];

    $err = array();
    $complete_msg = "";

    // [氏名]未入力チェック

    if ($user_name == '') {
        $err['user_name'] = '氏名を入力して下さい。';
    }else {
        // 文字数チェック
        if (strlen(mb_convert_encoding($user_name, 'SJIS', 'UTF-8')) > 30) {
            $err['user_name'] = '氏名は30バイト以内で入力して下さい。';
        }
    }


    // [店舗名]未入力チェック
    if ($name_restaurant == '') {
        $err['name_restaurant'] = '店舗名を入力して下さい。';
    }else {
        // 文字数チェック
        if (strlen(mb_convert_encoding($name_restaurant, 'SJIS', 'UTF-8')) > 30) {
            $err['name_restaurant'] = '店舗名は30バイト以内で入力して下さい。';
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
            if (checkEmail($user_email, $user_id,$pdo)) {
                $err['user_email'] = 'このメールアドレスは既に登録されています。';
            }
        }
    }

    // [受注PCメールアドレス]未入力チェック

    if ($order_pc_email == '') {
        $err['order_pc_email'] = 'メールアドレスを入力して下さい。';
    } else {
        // [受注PCメールアドレス]形式チェック
        if (!filter_var($order_pc_email, FILTER_VALIDATE_EMAIL)) {
            $err['order_pc_email'] = 'メールアドレスが不正です。';
        } else {
            // [受注PCメールアドレス]存在チェック
            if (checkorder_pc_email($order_pc_email, $user_id,$pdo)) {
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
    }

    if (empty($err)) {

        // アドレスが変更されるかどうかで条件分岐
        if($user_email==$user['user_email']){

            // アドレスが変更されていない（ビデオが入ったフォルダ名の変更やビデオの移動なし）

                // userテーブルの更新
                $sql = "UPDATE user SET
                    user_name = :user_name,
                    user_email = :user_email,
                    order_pc_email = :order_pc_email,
                    user_phone_number = :user_phone_number,
                    name_restaurant = :name_restaurant,
                    zip = :zip,
                    addr1 = :addr1,
                    addr2 = :addr2,
                    user_password = :user_password,
                    updated_at = now()
                    where id = :id";

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
                $stmt->bindValue(':id',$user['id'], PDO::PARAM_STR);
                $stmt->execute();

                // セッション上のユーザデータを更新
                $user['user_name'] = $user_name;
                $user['user_email'] = $user_email;
                $user_file2 = $user_email;
                $user['order_pc_email'] = $order_pc_email;
                $user['user_phone_number'] = $user_phone_number;
                $user['name_restaurant'] = $name_restaurant;
                $user['zip'] = $zip;
                $user['addr1'] = $addr1;
                $user['addr2'] = $addr2;
                $user['user_password'] = $user_password;
                $_SESSION['tablet_order_system_setting'] = $user;


                // 完了メッセージ表示
                $complete_msg = "修正が完了しました。";

        }else{

            // アドレスが変更されている（ビデオが入ったフォルダ名の変更やビデオの移動あり）

                // userテーブルの更新
                $sql = "UPDATE user SET
                    user_name = :user_name,
                    user_email = :user_email,
                    order_pc_email = :order_pc_email,
                    user_phone_number = :user_phone_number,
                    name_restaurant = :name_restaurant,
                    zip = :zip,
                    addr1 = :addr1,
                    addr2 = :addr2,
                    user_password = :user_password,
                    updated_at = now()
                    where id = :id";

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
                $stmt->bindValue(':id',$user['id'], PDO::PARAM_STR);
                $stmt->execute();

                // セッション上のユーザデータを更新
                $user['user_name'] = $user_name;
                $user['user_email'] = $user_email;
                $user_file2 = $user_email;
                mkdir("images/test/$user_file2", 0777);
                mkdir("images/test/$user_file2/thank_you", 0777);
                $user['order_pc_email'] = $order_pc_email;
                $user['user_phone_number'] = $user_phone_number;
                $user['name_restaurant'] = $name_restaurant;
                $user['zip'] = $zip;
                $user['addr1'] = $addr1;
                $user['addr2'] = $addr2;
                $user['user_password'] = $user_password;
                $_SESSION['tablet_order_system_setting'] = $user;

                // 変更前のフォルダから変更後のフォルダに会計写真をコピー。コピー後元のフォルダの写真を削除する。
                foreach ($kaikei_image_name as $file) {
                    copy("/home/kazu0520/www/tablet_order_system/web/images/test/$user_file1/thank_you/$file[image_name]","/home/kazu0520/www/tablet_order_system/web/images/test/$user_file2/thank_you/$file[image_name]");
                    unlink("/home/kazu0520/www/tablet_order_system/web/images/test/$user_file1/thank_you/$file[image_name]");
                }

                // 変更前のフォルダを削除する。
                rmdir("/home/kazu0520/www/tablet_order_system/web/images/test/$user_file1/thank_you");



                // 変更前のフォルダから変更後のフォルダにメニューの写真をコピー。コピー後元のフォルダの写真を削除する。
                foreach ($food_image_name as $file2) {
                    copy("/home/kazu0520/www/tablet_order_system/web/images/test/$user_file1/$file2[image_name]","/home/kazu0520/www/tablet_order_system/web/images/test/$user_file2/$file2[image_name]");
                    unlink("/home/kazu0520/www/tablet_order_system/web/images/test/$user_file1/$file2[image_name]");
                }

                // 変更前のフォルダを削除する。
                rmdir("/home/kazu0520/www/tablet_order_system/web/images/test/$user_file1");

                // 完了メッセージ表示
                $complete_msg = "修正が完了しました。";

        }

    }

    unset($pdo);
}
?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <meta charset="utf-8">
        <title>アカウント設定 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <!-- 郵便番号から住所を出すjavascriptファイルの読み込み -->
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            #入力欄{
            width: 100%;
            font-size:14px;
            }


            }/* smax-width: 414px*/



            @media screen and (max-width: 414px) {

            h1{
            font-size:26px;
            }

            #入力欄{
            width: 100%;
            font-size:10px;
            }

            }/* smax-width: 414px*/

        </style>

    </head>


    <body id="main">

        <?php include("./common_header_setting.php"); ?>
        <div class="container-fluid">

        <div class="panel-body">

            <h1><b>アカウント設定</b></h1>

            <?php if ($complete_msg): ?>
              <div class="alert alert-success">
                <?php echo h($complete_msg); ?>
              </div>
            <?php endif; ?>

            <form  id="demo_form" method="POST" class="panel panel-default panel-body">

                <div class="form-group <?php if ($err['user_name'] != '') echo 'has-error'; ?>">
                    <label>氏名</label><br>
                    <input type="text" class="validate[required,maxSize[15]]" id="入力欄" has-error name="user_name" value="<?php echo h($user_name); ?>" placeholder="氏名" />
                    <span class="help-block"><?php echo h($err['user_name']); ?></span>
                </div>

                <div class="form-group <?php if ($err['user_email'] != '') echo 'has-error'; ?>">
                    <label>メールアドレス</label><br>
                    <input type="text" class="validate[required,custom[email]"id="入力欄" name="user_email" value="<?php echo h($user_email); ?>" placeholder="メールアドレス" />
                    <span class="help-block"><?php echo h($err['user_email']); ?></span>
                </div>

                <div class="form-group <?php if ($err['order_pc_email'] != '') echo 'has-error'; ?>">
                    <label>受注PCメールアドレス</label><br>
                    <input type="text"  class="validate[required,custom[email]"id="入力欄" name="order_pc_email" value="<?php echo h($order_pc_email); ?>" placeholder="受注PCメールアドレス" />
                    <span class="help-block"><?php echo h($err['order_pc_email']); ?></span>
                </div>

                <div class="form-group <?php if ($err['user_phone_number'] != '') echo 'has-error'; ?>">
                    <label>電話番号</label><br>
                    <input type="text" class="validate[required,custom[phone]]" id="入力欄" name="user_phone_number" value="<?php echo h($user_phone_number); ?>" placeholder="電話番号" />
                    <span class="help-block"><?php echo h($err['user_phone_number']); ?></span>
                </div>

                <div class="form-group <?php if (isset($err['name_restaurant']) && $err['name_restaurant'] != '') echo 'has-error'; ?>">
                    <label>店舗名</label><br>
                    <input class="validate[required]" type="text" name="name_restaurant" id="入力欄" value="<?php echo h($name_restaurant) ?>" placeholder="店舗名" />
                    <span class="help-block"><?php if (isset($err['name_restaurant'])) echo h($err['name_restaurant']); ?></span>
                </div>

                <div class="form-group <?php if ($err['zip'] != '') echo 'has-error'; ?>">
                    <label>店舗の郵便番号</label><br>
                    <input type="text" class="validate[required,custom[onlyNumberSp],maxSize[7]]"name="zip" id="入力欄" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','addr1','addr1');"value="<?php echo h($zip) ?>"placeholder="郵便番号(ハイフンなしで入力)" />
                    <span class="help-block"><?php echo h($err['zip']); ?></span>
                </div>

                <div class="form-group <?php if ($err['addr1'] != '') echo 'has-error'; ?>">
                    <label>店舗の住所1</label><br>
                    <input type="text" class="validate[required]"name="addr1" id="入力欄"value="<?php echo h($addr1) ?>"placeholder="都道府県 市区町村 (郵便番号を入力すると自動表示されます。)" />
                    <span class="help-block"><?php echo h($err['addr1']); ?></span>
                </div>

                <div class="form-group <?php if ($err['addr2'] != '') echo 'has-error'; ?>">
                    <label>店舗の住所2</label><br>
                    <input type="text" class="validate[required]"name="addr2" id="入力欄"value="<?php echo h($addr2) ?>"placeholder="○丁目○番○ 建物名" />
                    <span class="help-block"><?php echo h($err['addr2']); ?></span>
                </div>

                <div class="form-group <?php if ($err['user_password'] != '') echo 'has-error'; ?>">
                    <label>パスワード</label><br>
                    <input type="password" class="validate[required,minSize[6],custom[onlyLetterNumber],maxSize[15]]" id="入力欄" name="user_password" placeholder="パスワード(半角英数で6文字以上15文字以下)" />
                    <span class="help-block"><?php echo h($err['user_password']); ?></span>
                </div>

                <div class="form-group">
                    <input class="btn btn-success btn-block" type="submit" value="修正">
                    <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                </div>

            </form>
            <a href="./setting_taikai.php" class="btn btn-danger btn-block" onclick="return confirm('全てのデータが削除されます。退会しても宜しいですか ?') " >退会する</a>

        </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="./js/jquery.validationEngine.js"></script>
            <script src="./js/languages/jquery.validationEngine-ja.js"></script>
            <script>
            $(function(){
            $("#demo_form").validationEngine();
            });
            </script>

            <hr>

            <?php include("./common_footer.php"); ?>

        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
