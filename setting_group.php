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

$id = $_GET['id'];

if($id){

    if($id == '更新'){
        $message = 'グループが更新されました。';
    }

    if($id == '新規登録'){
        $message = 'グループが新規登録されました。';
    }

}



//グループ名とgroup_idを取得する
for ($n = 1; $n <= 16; $n=$n+1){
    $group = array();
    $sql = "select * from group_setting where user_id = :user_id and group_id = :group_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':group_id',$n, PDO::PARAM_INT);
    $stmt->execute();
    $group = $stmt->fetch();
    $gid[$n]=$group['id'];
    $group_name[$n]=$group['group_name'];
    $group_id[$n]=$group['group_id'];
}


$group_list = array();
$sql = "select * from group_setting where user_id = :user_id ORDER BY group_id ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();
foreach ($stmt->fetchAll() as $row) {
    array_push($group_list, $row);
}


unset($pdo);



?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>グループ設定 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <style>

            @media screen and (max-width: 3000px) {

            h1{
            font-size:28px;
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

            .btn-default{
            font-size:14px;
            }



            .btn-success{
            margin-left: :0ppx;
            margin-top: :0ppx;
            margin-right: :0ppx;
            margin-bottom: :0ppx;
            width:100%;
            }


            #message3{
            font-size:12px;
            }


            #grid_setting_food_menu{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            grid-template-rows: 340px 340px;
            margin-right: 0px;
            margin-left: 0px;
            }

            .price{
            font-size: 18px;
            font-weight: bold;
            }

            .menu_food_name{
            color: black;
            font-size:18px;
            font-weight: bold;
            }
            }/* smax-width: 3000px*/

            @media screen and (max-width: 768px) {

            .btn-default{
            font-size: 9px;
            }

            .btn-info{
            font-size: 9px;
            }

            }

            @media screen and (max-width: 736px) {


            .btn-default{
            font-size:8px;
            }

            btn-group-justified{
            font-size:7px;
            color:red;
            }



            .btn-primary{
            font-size:8px;
            }

            .btn-info{
            font-size:8px;
            }




            p{
            font-size:17px;
            }





            .btn-group btn-group-justified{
            font-size:5px;
            }

            #message3{
            font-size:12px;
            }


            #grid_setting_food_menu{
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            grid-template-rows: 350px;
            margin-right: 0px;
            margin-left: 0px;
            }

            .price{
            font-size: 18px;
            font-weight: bold;
            }

            .menu_food_name{
            color: black;
            font-size:18px;
            font-weight: bold;
            }
            }/* smax-width: 736px*/

            @media screen and (max-width: 414px) {


            h1{
            font-size:26px;
            }


            .btn-default{
            font-size:8px;

            }



            .btn-primary{
            font-size:5px;
            }

            .btn-info{
            font-size:6px;
            }



            p{
            font-size:15px;
            }

            #不具合注意書き{
            font-size:10px;
            }


            .btn-group btn-group-justified{
            font-size:5px;
            }

            #message3{
            font-size:12px;
            }


            #grid_setting_food_menu{
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            grid-template-rows: 350px;
            margin-right: 0px;
            margin-left: 0px;
            }

            .price{
            font-size: 18px;
            font-weight: bold;
            }

            .menu_food_name{
            color: black;
            font-size:18px;
            font-weight: bold;
            }

            }/* smax-width: 414px*/

        </style>

    </head>



    <body id="main">

        <?php include("./common_header_setting.php"); ?>

        <div class="container-fluid">
            <div class="row">
                <div class="panel-body">

                <h1>グループ設定</h1>
                <p>グループは16個まで登録できます。<br>
                    <a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#グループ・メニュー設定"target="_blank">
                      →グループ設定の方法をビデオで見る。
                    </a>
                </p>

                <?php if ($message): ?>
                    <div class="alert alert-success">
                    <?php echo h($message); ?>
                    </div>
                <?php endif; ?>
                <hr>

                <h4>注文画面でのグループ表示</h4>

                <div class="btn-group btn-group-justified" role="group">
                    <?php for($i = 1; $i <= 8; $i=$i+1):?>
                        <a class="btn btn-default" role="button"><b><?php echo  h($group_name[$i]); ?></b></a>
                    <?php endfor ;?>
                </div>

                <div class="btn-group btn-group-justified" role="group">
                    <?php for($i = 9; $i <= 16; $i=$i+1):?>
                        <a class="btn btn-default" role="button"><b><?php echo  h($group_name[$i]); ?></b></a>
                    <?php endfor ;?>
                </div>
                <br>

                <p id="不具合注意書き">※携帯で見ると画面幅の都合で文字がはみ出すことがあります。
                  <br>タブレットでの表示には問題ありませんのでご安心ください。
                </p>

                <hr>

                <div class="btn-group btn-group-justified" role="group">
                    <a href="setting_group_touroku.php" class="btn btn-success" role="button" id="menu_insert">グループ新規登録</a>
                </div>

                <br>
                <?php if ($group_list): ?>
                    <?php foreach ($group_list as $item): ?>
                        <li class="list-group-item">
                            <?php echo h($item['group_id']); ?> <?php echo h($item['group_name']); ?>
                            <a href="setting_group_touroku.php?id=<?php echo  h($item['id']); ?>">[編集]</a>
                            <a href="javascript:void(0);" onclick="var ok=confirm('削除しても宜しいですか?');
     											  if (ok) location.href='delete_group.php?id=<?php echo  h($item['id']); ?>'; return false;">[削除]</a>
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
