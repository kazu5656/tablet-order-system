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

$food_list = array();
$sql = "select * from food where user_id = :user_id ORDER BY `group_id`,`display_position` ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();

?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>全メニュー表示 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <style>

            #メニュー設定に戻る{
            font-size:18px;
            font-weight: bold;
            }

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
            }

            }

            @media screen and (max-width: 414px) {

            h1{
            font-size:26px;
            }

            .btn-success{
            font-size:12px;

            }

            .btn-primary{
            font-size:12px;
            }

            .btn-info{
            font-size:12px;
            }

            table{
            font-size:8px;
            }

            }/* smax-width: 414px*/

        </style>

    </head>



    <body id="main">

        <?php include("./common_header_setting.php"); ?>

        <div class="container-fluid">
            <div class="row">
            <div class="panel-body">

            <h1>全メニュー表示</h1>
            <hr>

            <div class="btn-group btn-group-justified" role="group">
              <a href="setting_group.php" class="btn btn-info" role="button">グループ設定に戻る</a>
              <a href="setting_food.php" class="btn btn-success" role="button">メニュー設定に戻る</a>
            </div>

            <br>

            <table width="100%" border="1">
                <tr>
                    <th>メニュー名</th>
                    <th>価格</th>
                    <th>グループ番号</th>
                    <th>表示位置</th>
                    <th></th>
                </tr>

                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>".h($row['food_name'])."</td>";
                    echo "<td>".h($row['price'])."</td>";
                    echo "<td>".h($row['group_id'])."</td>";
                    echo "<td>".h($row['display_position'])."</td>";
                    echo "<td>
                            <a href=\"setting_food_touroku.php?id=".h($row['id'])."\">[変更]</a>
                            &nbsp;
                            <a href=\"delete_food.php?id=".h($row['id'])."\" onclick=\"return confirm('削除しても宜しいですか?')\">[削除]</a>
                         </td>";

                    echo "</tr>";
                }
                unset($pdo);
                ?>
            </table>

            <br>
            </div>
            <hr>

        <?php include("./common_footer.php"); ?>
        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
