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

// パラメータで渡されたアイテムIDを取得
$id = $_GET['id'];


// ユーザーのグループidを取得する
$touroku_group_list = array();
$sql0 = "select group_id from group_setting where user_id = :user_id ORDER BY group_id ASC";
$stmt0 = $pdo->prepare($sql0);
$stmt0->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt0->execute();
foreach ($stmt0->fetchall() as $row){
    array_push($touroku_group_list, $row);
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
		if($group){
    		$group_id_[$n]=$group['group_id'];
    		$group_name_[$n]=$group['group_name'];
		}
}

//プルダウンメニュー用の選択値の設定（登録されていればグループ名を数字の横に表示する）
for ($i = 1; $i <= 16; $i=$i+1){
    if($group_id_[$i]){
        ${'number'.$i}="$i:$group_name_[$i]";
    }else{
        ${'number'.$i}=$i;
    }
}

//登録されていないグループ番号を$no_group_idに入れる
$no_group_id = array();
for ($n = 1; $n <= 16; $n=$n+1){
    if(!$group_id_[$n]){
        $no_group_id[$n]=$n;
    }
}

//プルダウンメニューの初期値（$group_id） に$no_group_idの最小値を入れる
if($no_group_id){
    $group_id = min($no_group_id);
}else{
    $group_id = 1;
}


 // 登録されているグループの数を数える
$sql2 = "SELECT COUNT(*) FROM group_setting where user_id = :user_id";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt2->execute();
$group_count = $stmt2->fetchColumn();

$group_id_array = array(
    "1" => "$number1",
    "2" => "$number2",
    "3" => "$number3",
    "4" => "$number4",
    "5" => "$number5",
    "6" => "$number6",
    "7" => "$number7",
    "8" => "$number8",
    "9" => "$number9",
    "10" => "$number10",
    "11" => "$number11",
    "12" => "$number12",
    "13" => "$number13",
    "14" => "$number14",
    "15" => "$number15",
    "16" => "$number16",
);



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // CSRF対策↓
    setToken();


    // $idのデータを検索し$itemに入れる
    $sql = "select * from group_setting where id = :id and user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch();


    // $idがあって $item がなければ404エラー、あれば$group_name、$group_id にデータを入れる
    if($id){
        if (!$item) {
            // データが取得出来なかったら404エラーページに遷移
            error_log(date("Y/m/d H:i:s"). basename(__FILE__)." アイテムid＝"."$id"."で404エラーが発生しました。".PHP_EOL, 3, "../logs/error_log");
            error_log(date("Y/m/d H:i:s"). basename(__FILE__)."で404エラーが発生しました。", 1, "goalhunter.kazu@gmail.com");
            header('Location: '.SITE_URL.'404.php');
            exit;
        }else{
            // データが取得出来たら変数に入れる
            $group_name = $item['group_name'];
            $group_id = $item['group_id'];
        }
    }

} else {

    // CSRF対策↓
    checkToken();

    // フォームからサブミットされた時の処理

    $group_name = $_POST['group_name'];
    $group_id = $_POST['group_id'];


    if(!$id){

        // $idがなかったら新規登録 スタート
        // 入力チェックを行う。
        $err = array();

        // [氏名]未入力チェック
        if ($group_name == '') {
            $err['group_name'] = 'グループ名を入力して下さい。';
        }else {
            // 文字数チェック
            if (strlen(mb_convert_encoding($group_name, 'SJIS', 'UTF-8')) > 20) {
                $err['group_name'] = 'グループ名は10文字以内で入力して下さい。';
            }
        }

        // [グループ順序]未入力チェック
        if ($group_id == '') {
            $err['group_id'] = 'グループ番号を入力して下さい。';
        }else{
            $sql = "select * from group_setting where user_id = :user_id and group_id = :group_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
            $stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
            $stmt->execute();
            $item = $stmt->fetch();
        }

        if($item){

            if (empty($err)) {

                // データベース（groupテーブル）に更新する。
                $sql = "UPDATE group_setting SET group_name = :group_name, updated_at = now() where user_id = :user_id and group_id = :group_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
                $stmt->bindValue(':group_name',$group_name, PDO::PARAM_STR);
                $stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
                $stmt->execute();

                $update_group = array();
                $sql = "select * from group_setting where user_id = :user_id and group_name = :group_name and group_id = :group_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
                $stmt->bindValue(':group_name',$group_name, PDO::PARAM_STR);
                $stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
                $stmt->execute();
                $update_group = $stmt->fetch();

                //グループ名とgroup_idを取得する
                for ($n = 1; $n <= 16; $n=$n+1){
                    $group = array();
                    $sql = "select * from group_setting where user_id = :user_id and group_id = :group_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
                    $stmt->bindValue(':group_id',$n, PDO::PARAM_INT);
                    $stmt->execute();
                    $group = $stmt->fetch();
                    if($group){
                        $group_id_[$n]=$group['group_id'];
                        $group_name_[$n]=$group['group_name'];
                    }
                }

                //プルダウンメニュー用の選択値の設定（登録されていればグループ名を数字の横に表示する）
                for ($i = 1; $i <= 16; $i=$i+1){
                    if($group_id_[$i]){
                        ${'number'.$i}="$i:$group_name_[$i]";
                    }else{
                        ${'number'.$i}=$i;
                    }
                }

                $group_id_array = array(
                "1" => "$number1",
                "2" => "$number2",
                "3" => "$number3",
                "4" => "$number4",
                "5" => "$number5",
                "6" => "$number6",
                "7" => "$number7",
                "8" => "$number8",
                "9" => "$number9",
                "10" => "$number10",
                "11" => "$number11",
                "12" => "$number12",
                "13" => "$number13",
                "14" => "$number14",
                "15" => "$number15",
                "16" => "$number16",
                );


                // セッション・ハイジャック対策
                session_regenerate_id(true);

                header('Location: '.SITE_URL.'setting_group.php?id=更新');


            }

        }else{


            // もし$err配列に何もエラーメッセージが保存されていなかったら
            if (empty($err)) {

                // データベース（groupテーブル）に新規登録する。
                $sql = "insert into group_setting
                (user_id,group_name,group_id,created_at,updated_at)
                values
                (:user_id,:group_name,:group_id,now(),now())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
                $stmt->bindValue(':group_name',$group_name, PDO::PARAM_STR);
                $stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
                $stmt->execute();

                $insert_group = array();
                $sql = "select * from group_setting where user_id = :user_id and group_name = :group_name and group_id = :group_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
                $stmt->bindValue(':group_name',$group_name, PDO::PARAM_STR);
                $stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
                $stmt->execute();
                $insert_group = $stmt->fetch();

                //グループ名とgroup_idを取得する
                for ($n = 1; $n <= 16; $n=$n+1){
                    $group = array();
                    $sql = "select * from group_setting where user_id = :user_id and group_id = :group_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
                    $stmt->bindValue(':group_id',$n, PDO::PARAM_INT);
                    $stmt->execute();
                    $group = $stmt->fetch();
                    if($group){
                        $group_id_[$n]=$group['group_id'];
                        $group_name_[$n]=$group['group_name'];
                    }
                }

                //プルダウンメニュー用の選択値の設定（登録されていればグループ名を数字の横に表示する）
                for ($i = 1; $i <= 16; $i=$i+1){
                    if($group_id_[$i]){
                        ${'number'.$i}="$i:$group_name_[$i]";
                    }else{
                        ${'number'.$i}=$i;
                    }
                }

                $group_id_array = array(
                    "1" => "$number1",
                    "2" => "$number2",
                    "3" => "$number3",
                    "4" => "$number4",
                    "5" => "$number5",
                    "6" => "$number6",
                    "7" => "$number7",
                    "8" => "$number8",
                    "9" => "$number9",
                    "10" => "$number10",
                    "11" => "$number11",
                    "12" => "$number12",
                    "13" => "$number13",
                    "14" => "$number14",
                    "15" => "$number15",
                    "16" => "$number16",
                );


                // セッション・ハイジャック対策
                session_regenerate_id(true);
                header('Location: '.SITE_URL.'setting_group.php?id=新規登録');

            }

        }

        // $idがなかったら新規登録 終了


    }else{


        // $idがあったらデータ更新　スタート

        // 入力チェックを行う。
        $err = array();

        // [氏名]未入力チェック
        if ($group_name == '') {
            $err['group_name'] = 'グループ名を入力して下さい。';
        }else {
            // 文字数チェック
            if (strlen(mb_convert_encoding($group_name, 'SJIS', 'UTF-8')) > 20) {
                $err['group_name'] = 'グループ名は10字以内で入力して下さい。';
            }
        }

        // [グループ番号]未入力チェック
        if ($group_id == '') {
            $err['group_id'] = 'グループ番号を選択して下さい。';
        }


        // もし$err配列に何もエラーメッセージが保存されていなかったら
        if (empty($err)) {

            // データベース（groupテーブル）に更新する。
            $sql = "UPDATE group_setting SET user_id = :user_id, group_name = :group_name, group_id = :group_id,updated_at = now() where id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
            $stmt->bindValue(':group_name',$group_name, PDO::PARAM_STR);
            $stmt->bindValue(':group_id',$group_id, PDO::PARAM_INT);
            $stmt->bindValue(':id',$id, PDO::PARAM_INT);
            $stmt->execute();

            $update_group = array();
            $sql = "select * from group_setting where id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id',$id, PDO::PARAM_INT);
            $stmt->execute();
            $update_group = $stmt->fetch();

            //グループ名とgroup_idを取得する
            for ($n = 1; $n <= 16; $n=$n+1){
                $group = array();
                $sql = "select * from group_setting where user_id = :user_id and group_id = :group_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
                $stmt->bindValue(':group_id',$n, PDO::PARAM_INT);
                $stmt->execute();
                $group = $stmt->fetch();
                if($group){
                    $group_id_[$n]=$group['group_id'];
                    $group_name_[$n]=$group['group_name'];
                }
            }

            //プルダウンメニュー用の選択値の設定（登録されていればグループ名を数字の横に表示する）
            for ($i = 1; $i <= 16; $i=$i+1){
                if($group_id_[$i]){
                    ${'number'.$i}="$i:$group_name_[$i]";
                }else{
                    ${'number'.$i}=$i;
                }
            }

            $group_id_array = array(
                "1" => "$number1",
                "2" => "$number2",
                "3" => "$number3",
                "4" => "$number4",
                "5" => "$number5",
                "6" => "$number6",
                "7" => "$number7",
                "8" => "$number8",
                "9" => "$number9",
                "10" => "$number10",
                "11" => "$number11",
                "12" => "$number12",
                "13" => "$number13",
                "14" => "$number14",
                "15" => "$number15",
                "16" => "$number16",
            );

            // セッション・ハイジャック対策
            session_regenerate_id(true);
            header('Location: '.SITE_URL.'setting_group.php?id=更新');

        }

        // $idがあったらデータ更新　終了

    }

    unset($pdo);

}



?>

<!DOCTYPE html>

<html lang="ja">

    <head>

        <title>グループ登録 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

        <style>

            #登録{
            font-size:16px;
            }


            #グループ名テキストボックス{
            width:100%;
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

            #グループ名テキストボックス{
            width:100%;
            }

            }/* smax-width: 414px*/

        </style>

    </head>



    <body id="main">

        <?php include("./common_header_setting.php"); ?>
        <div class="container-fluid">

        <h1>グループ登録</h1>
        <p>グループは16個まで登録できます。</p>

        <?php if ($complete_msg): ?>
            <div class="alert alert-success">
                <?php echo h($complete_msg); ?>
            </div>
        <?php endif; ?>


            <div class="row">

                <div class="panel-body">

                    <form id="demo_form" method="POST" class="panel panel-default panel-body">

                        <div class="form-group <?php if (isset($err['group_name']) && $err['group_name'] != '') echo 'has-error'; ?>">
                            <label>グループ名</label>   <br>
                            <input id="グループ名テキストボックス" class="validate[required,maxSize[10]]" type="text" name="group_name" value="<?php echo h($group_name) ?>" placeholder="例:ごはん (10文字以内)" />
                            <span class="help-block"><?php if (isset($err['group_name'])) echo h($err['group_name']); ?></span>
                        </div>

                        <div class="form-group <?php if ($err['group_id'] != '') echo 'has-error'; ?>">
                            <label>グループ番号</label>
                            <?php echo arrayToSelect("group_id", $group_id_array, $group_id); ?>
                            <span class="help-block"><?php echo h($err['group_id']); ?></span>
                        </div>

                        <br>
                        <div class="form-group">
                            <input type="submit" id="登録"value="登録" class="btn btn-primary btn-block">
                            <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                        </div>

                       <div class="btn-group btn-group-justified" role="group">
                           <a href="setting_group.php" class="btn btn-info" role="button" id="メニュー設定に戻る">グループ設定に戻る</a>
                           <a href="setting_food.php" class="btn btn-success" role="button" id="メニュー設定に戻る">メニュー設定に戻る</a>
                       </div>

                    </form>

                </div><!--/panel-body-->

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                <script src="./js/jquery.validationEngine.js"></script>
                <script src="./js/languages/jquery.validationEngine-ja.js"></script>
                <script>
                $(function(){
                $("#demo_form").validationEngine();
                });
                </script>


            </div><!--/row-->

        <hr>
        <?php include("./common_footer.php"); ?>

        </div><!--/.container-->
        <?php include("./script.php"); ?>

    </body>



</html>
