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

$message="現在、ログインしているテーブルはありません。";


if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();

    // ログインされているテーブルを取得
    $login_table_list = array();
    $sql = "select * from login_table where user_id = :user_id ORDER BY table_number ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $row) {
        array_push($login_table_list, $row);
    }

} else {

    // CSRF対策↓
    checkToken();

    // DB情報をクリア
    $sql = "delete from login_table where user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->execute();

    unset($pdo);

}


?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>テーブル管理 | <?php echo SERVICE_NAME; ?></title>
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

            }

        </style>

    </head>



    <body id="main">
          <?php include("./common_header_setting.php"); ?>
          <div class="container-fluid">

                <h1>テーブル管理</h1>
                <p><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#テーブル管理"target="_blank">→テーブル管理の方法</a></p>
                <hr>

                <div class="row">
                    <div class="panel-body">

                          <?php if (!$login_table_list): ?>
                              <div class="alert alert-info">
                                   <?php echo h($message); ?>
                              </div>
                          <?php endif; ?>

                          <form method="POST">
                              <div class="form-group">
                                  <input type="submit" value="全てのテーブルのタブレットをログアウトする" class="btn btn-primary btn-block" onclick="return confirm('全てのテーブルのタブレットをログアウトしても宜しいですか ?') ">
                                  <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                              </div>
                          </form>

                          <?php if ($login_table_list): ?>
                              <?php foreach ($login_table_list as $item): ?>
                                  <li class="list-group-item">
                                      テーブル番号：<?php echo h($item['table_number']); ?> <a href="javascript:void(0);" onclick="var ok=confirm('このテーブルのタブレットをログアウトしても宜しいですか?');
                                      if (ok) location.href='logout_order.php?id=<?php echo h($item['id']); ?>'; return false;">[ログアウトする]</a>
                                  </li>
                              <?php endforeach; ?><br>
                          <?php endif; ?>

                    </div>
                </div><!--/row-->

                <hr>

               <?php include("./common_footer.php"); ?>

          </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
