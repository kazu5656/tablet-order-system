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





//GETでグループidが取得されたらそのグループid、なければグループidは１
if($_GET['id']){
    $id = $_GET['id'];
    $_SESSION['id'] = $_GET['id'];
}else{
    $id = '1';
}


if ($_SERVER['REQUEST_METHOD'] != 'GET') {

    // CSRF対策↓
    checkToken();

} else {

    // CSRF対策↓
    setToken();

    // group_idの$food_list（メニュー）を取得
    $food_list = array();
    $sql = "select * from food where user_id = :user_id and group_id = :group_id ORDER BY `display_position` ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':group_id',$id, PDO::PARAM_INT);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $row) {
        array_push($food_list, $row);
    }

    // group_idの $group_nameを取得
    $group2 = array();
    $sql2 = "select * from group_setting where user_id = :user_id and group_id = :group_id";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt2->bindValue(':group_id',$id, PDO::PARAM_INT);
    $stmt2->execute();
    $group2 = $stmt2->fetch();
    $group_name2 = $group2['group_name'];

     //group_idのメニュー１〜６を取得
    for ($display_position = 1; $display_position <= 6; $display_position=$display_position+1){
        $sql3 = "select * from food where user_id = :user_id and group_id = :group_id and display_position = :display_position";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
        $stmt3->bindValue(':group_id',$id, PDO::PARAM_INT);
        $stmt3->bindValue(':display_position',$display_position, PDO::PARAM_INT);
        $stmt3->execute();
        ${'food_menu'.$display_position} = $stmt3->fetchall();
    }

     // メニュー編集、登録画面へのリンク用に$idを$group_id0に入れる
    $group_id0=$id;

    unset($pdo);

}

?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>メニュー設定 | <?php echo SERVICE_NAME; ?></title>
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
            font-size:8px;
            }

            .btn-info{
            font-size:8px;
            }

            p{
            font-size:12px;
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

                <h1>メニュー設定</h1>
                <p>１つのグループに6個までメニューを登録できます。<br>
                  <a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#グループ・メニュー設定"target="_blank">→メニュー設定の方法 </a>
                  <br>
                  <a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/#メニューを売り切れ状態にする"target="_blank">→メニューを売り切れにする方法 </a>
                </p>
                <hr>

                <div class="btn-group btn-group-justified" role="group">
                    <a href="setting_all_food_list.php" class="btn btn-info" role="button" id="all_menu">全メニュー表示</a>
                </div><!--/btn-group btn-group-justified-->
                <br>

                <div class="btn-group btn-group-justified" role="group">
                    <a href="" class="btn btn-default" role="button" id="group_menu">グループ別メニュー</a>
                </div><!--/btn-group btn-group-justified-->

                <div class="btn-group btn-group-justified" role="group">
                    <?php for($i = 1; $i <= 8; $i=$i+1):?>
                        <a href="setting_food.php?id=<?php echo h($group_id[$i]); ?>"
                        <?php if ($id == $i):?>
                            <?php echo "class=\"btn btn-info\""?>
                        <?php else: ?>
                            <?php  echo "class=\"btn btn-default\"" ?>
                        <?php endif; ?>class="btn btn-default" role="button"><?php echo  h($group_name[$i]); ?></a>
                     <?php endfor ;?>
                </div><!--/btn-group btn-group-justified-->

               <div class="btn-group btn-group-justified" role="group">
                    <?php for($i = 9; $i <= 16; $i=$i+1):?>
                        <a href="setting_food.php?id=<?php echo h($group_id[$i]); ?>"
                        <?php if ($id == $i):?>
                            <?php echo "class=\"btn btn-info\""?>
                        <?php else: ?>
                            <?php  echo "class=\"btn btn-default\"" ?>
                        <?php endif; ?>class="btn btn-default" role="button"><?php echo  h($group_name[$i]); ?></a>
                    <?php endfor ;?>
                </div><!--/btn-group btn-group-justified-->


                <?php if (!$id): ?>
                        <div class="alert" id="message">グループからメニューを検索する場合はグループ名をクリックしてください。</div>
                <?php else: ?>
                        <?php if (!$food_list): ?>
                            <div class="alert" id="message2">「<?php echo h($group_name2); ?>」にはメニューが登録されていません。</div>
                        <?php else: ?>
                            <div class="alert" id="message">「<?php echo h($group_name2); ?>」のメニューリストです。</div>
                        <?php endif; ?>
                <?php endif; ?>


                <div class="row">
                    <div class="col-md-12" id ="grid_setting_food_menu">

                      <?php for($i = 1; $i <= 6; $i=$i+1):?>
                          <div class="item">
                              <table border="1" class="grid_table">
                                  <tr>
                                      <th class="menu_food_name"><?php echo h($i); ?>.<?php echo h(${'food_menu'.$i} [0]['food_name']); ?></th>
                                  </tr>
                                  <tr>
                                      <td id="menu<?php echo h($i); ?>"><br><br><br><br><br><br><br><br><br><br><br></td>
                                  </tr>

                                  <tr>
                                      <td class="price"><?php echo h(${'food_menu'.$i}[0]['price']); ?>円</td>
                                  </tr>
                                  <tr>
                                      <td class="td5"><div class="btn-group btn-group-justified" role="group">

                                          <a href="setting_food_touroku.php?id=<?php echo h(${'food_menu'.$i}[0]['id']); ?>&position=<?php echo h($i); ?>&group_id=<?php echo h($group_id0); ?>"
                                          class="btn btn-default" role="button" id="message3">編集・追加</a>

                                          <a href="javascript:void(5);" onclick="var ok=confirm('削除しても宜しいですか?');
                                          if (ok) location.href='delete_food.php?id=<?php echo h(${'food_menu'.$i}[0]['id']); ?>'; return false;"
                                          class="btn btn-default" role="button" id="message3">削除</a>

                                          <?php if (${'food_menu'.$i}[0]['sold_out']==null):?>
                                               <a href="javascript:void(5);" onclick="var ok=confirm('売り切れにしても宜しいですか?');
                                                if (ok) location.href='setting_sold_out_food.php?id=<?php echo h(${'food_menu'.$i}[0]['id']); ?>'; return false;"
                                                class="btn btn-default" role="button" id="message3">売り切れ</a>
                                          <?php else: ?>
                                               <a href="javascript:void(5);" onclick="var ok=confirm('売り切れを解除しても宜しいですか?');
                                                if (ok) location.href='setting_sold_out_food_release.php?id=<?php echo h(${'food_menu'.$i}[0]['id']); ?>'; return false;"
                                                class="btn btn-danger" role="button" id="message3">売り切れ解除</a>
                                          <?php endif; ?>

                                          </div>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                      <?php endfor ;?>

                    </div><!--/col-md-12-->
                </div><!--/row-->

                </div>

            </div><!--/row-->

            <hr>

            <?php include("./common_footer.php"); ?>

        </div><!--/.container-->
        <?php include("./script.php"); ?>


    </body>



</html>
