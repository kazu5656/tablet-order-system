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

$message="現在、売り切れ状態のメニューはありません。";


if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();

    // ログインされているテーブルを取得
    $sold_out_list = array();
    $sql = "select * from food where user_id = :user_id and sold_out = :sold_out ORDER BY group_id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':sold_out','売り切れ', PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $row) {
        array_push($sold_out_list, $row);
    }

} else {

    // CSRF対策↓
    checkToken();

    // すべてのメニューの売り切れ状態を解除
    $sql = "UPDATE food SET
    sold_out  = :sold_out,
    updated_at = now()
    where  user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':sold_out',null, PDO::PARAM_STR);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->execute();

    unset($pdo);

}


?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>売り切れメニュー | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            }

            @media screen and (max-width: 414px) {

            h1{
            font-size:26px;
            }


            .btn-primary{
            font-size:12px;
            }

            .list-group-item{
            font-size:9px;
            }

            }

        </style>

    </head>



    <body id="main">
        <?php include("./common_header_setting.php"); ?>
        <div class="container-fluid">

            <h1>売り切れメニュー</h1>
             <p><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#メニューを売り切れ状態にする"target="_blank">→メニューを売り切れにする方法</a></p>

              <hr>

              <div class="row">
                    <div class="panel-body">

                        <?php if (!$sold_out_list): ?>
                            <div class="alert alert-info">
                                <?php echo h($message); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <input type="submit" value="全てのメニューの売り切れ状態を解除する" class="btn btn-primary btn-block" onclick="return confirm('全てのメニューの売り切れ状態を解除しても宜しいですか ?') ">
                                <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                            </div>
                        </form>

                        <?php if ($sold_out_list): ?>
                            <?php foreach ($sold_out_list as $item): ?>
                                <li class="list-group-item">
                                    <?php echo h($item['food_name']); ?> <a href="javascript:void(0);" onclick="var ok=confirm('このメニューの売り切れ状態を解除しても宜しいですか?');
                                    if (ok) location.href='setting_sold_out_food_release2.php?id=<?php echo h($item['id']); ?>'; return false;">[売り切れ状態を解除する]</a>
                                </li>
                            <?php endforeach; ?><br>
                        <?php endif; ?>

                    </div><!--/panel-body-->
              </div><!--/row-->

              <hr>

             <?php include("./common_footer.php"); ?>

        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
