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
$user_file = $user['user_email'];
define( "FILE_DIR", "images/test/$user_file/thank_you/");

$i = 0;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // 初めて画面にアクセスした時の処理
    $complete_msg = "";

    // CSRF対策
    setToken();

    $sql = "select * from user  where id = :id limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id',$user['id'], PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch();

    if($item['item_color']=='lightskyblue') {
        $item_color = '1';
    }
    if($item['item_color']=='hotpink') {
        $item_color = '2';
    }
    if($item['item_color']=='whitesmoke') {
        $item_color = '3';
    }
    if($item['item_color']=='palegreen') {
        $item_color = '4';
    }
    if($item['item_color']=='gold') {
        $item_color = '5';
    }
    if($item['item_color']=='tan') {
        $item_color = '6';
    }
    if($item['item_color']=='wheat') {
        $item_color = '7';
    }
    if($item['item_color']=='gainsboro') {
        $item_color = '8';
    }
    if($item['item_color']=='thistle') {
        $item_color = '9';
    }


} else {

    // CSRF対策
    checkToken();

    $item_color = $_POST['item_color'];

    if ($item_color == '1') {
        $color = 'lightskyblue';
    }
    if ($item_color == '2') {
        $color = 'hotpink';
    }
    if ($item_color == '3') {
        $color = 'whitesmoke';
    }
    if ($item_color == '4') {
        $color = 'palegreen';
    }
    if ($item_color == '5') {
        $color = 'gold';
    }
    if ($item_color == '6') {
        $color = 'tan';
    }
    if ($item_color == '7') {
        $color = 'wheat';
    }
    if ($item_color == '8') {
        $color = 'gainsboro';
    }
    if ($item_color == '9') {
        $color = 'thistle';
    }


    $sql = "UPDATE user SET
    item_color = :item_color,
    updated_at = now()
    where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt -> bindValue(':item_color',$color, PDO::PARAM_STR);
    $stmt -> bindValue(':id',$user['id'], PDO::PARAM_STR);
    $stmt->execute();

    $complete_msg = "登録が完了しました。";

}


?>


<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>注文ページカラー変更 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            label{
            font-size:15px;
            }

            .touroku_color{
            font-size:15px;
            height:30px;
            }

            .btn-success{
            font-size:16px;
            }


            #color_grid{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            grid-template-rows: 40px 40px 40px;
            margin-bottom: 20px;
            }

            .item1 {
            background: lightskyblue;
            color: black;
            font-size:16px;
            }

            .item2 {
            background: hotpink;
            color: black;
            font-size:16px;
            }

            .item3 {
            background: whitesmoke;
            color: black;
            font-size:16px;
            }

            .item4 {
            background: palegreen;
            color: black;
            font-size:16px;
            }

            .item5 {
            background: gold;
            color: black;
            font-size:16px;
            }

            .item6 {
            background: tan;
            color: black;
            font-size:16px;
            }

            .item7 {
            background: wheat;
            color: black;
            font-size:16px;
            }

            .item8 {
            background: gainsboro;
            color: black;
            font-size:16px;
            }

            .item9 {
            background: thistle;
            color: black;
            font-size:16px;
            }

            }

            @media screen and (max-width: 414px) {

            h1{
            font-size:25px;
            }

            label{
            font-size:10px;
            }

            .touroku_color{
            font-size:10px;
            height:30px;
            }

            }

        </style>

    </head>



    <body id="main">

                <?php include("./common_header_setting.php"); ?>
                <div class="container-fluid">
                      <h1>注文ページカラー変更</h1>
                       <p><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#会計ページ写真・注文ページカラー変更"target="_blank">→注文ページのカラーを変更する方法</a></p>

                      <?php if ($complete_msg): ?>
                          <div class="alert alert-success">
                              <?php echo h($complete_msg); ?>
                          </div>
                      <?php endif; ?>

                       <hr>

                      <div class="row">
      				            <div class="col-md-12">

                                <form method="POST" class="panel panel-default panel-body">

                                    <div class="col-md-12" id ="color_grid">
                                        <div class="item1" >①</div>
                                        <div class="item2" >② </div>
                                        <div class="item3" >③ </div>
                                        <div class="item4" >④</div>
                                        <div class="item5" >⑤</div>
                                        <div class="item6" >⑥</div>
                                        <div class="item7" >⑦ </div>
                                        <div class="item8" >⑧</div>
                                        <div class="item9" >⑨</div>
                                    </div><!--/col-md-12-->

                                    <div class="form-group <?php if ($err['item_color'] != '') echo 'has-error'; ?>">
                                        <label>お好きな色を①〜⑨の中から選択して下さい。</label>
                                        <span class="pulldown_menu"><?php echo arrayToSelect("item_color", $item_color_array, $item_color); ?></span>
                                        <span class="help-block"><?php echo h($err['item_color']); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="登録" class="btn btn-success btn-block">
                                        <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                                    </div>

                                    <div class="touroku_color" >
                                        現在登録中の色
                                    </div>

                                </form>

      				            </div><!--/col-md-12-->
                     </div><!--/row-->

                      <hr>

                      <?php include("./common_footer.php"); ?>

                </div><!--/.container-->
                <?php include("./script.php"); ?>

    </body>



</html>
