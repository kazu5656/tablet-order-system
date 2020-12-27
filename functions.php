<?php

// データベースに接続する
function connectDb() {
    $param = "mysql:dbname=".DB_NAME.";host=".DB_HOST;

    try {

    $pdo = new PDO($param, DB_USER, DB_PASSWORD);

    $pdo->query('SET NAMES utf8;');

    return $pdo;

} catch (PDOException $e) {

    echo $e->getMessage();

    $bt = debug_backtrace();
    $filename = $bt[0]['file'];
    $line = $bt[0]['line'];
    echo "$filename $line\n";

    error_log(date("Y/m/d H:i:s")."$filename $line"." で\n500 Internal Server Errorが発生しました。\n".$e->getMessage().PHP_EOL, 3, "logs/error_log");
    error_log(date("Y/m/d H:i:s")."$filename $line"." で500 Internal Server Errorが発生しました。".$e->getMessage(), 1, "goalhunter.kazu@gmail.com");

    if($_SESSION['tablet_order_sysytem_order']){
      header('Location: '.SITE_URL.'500_order.php');
    }else{
      header('Location: '.SITE_URL.'500.php');
    }

    exit;

}

}

// ログを出力する共通ファンクション

function logging($filename, $line, $message) {

    error_log(date("Y/m/d H:i:s")." ".$message."[".$filename.":".$line."]".PHP_EOL, 3, 'https://tablet-order-system.com/logs/error_log');

}

// ランダム文字列生成 (英数字)
function makeRandStr($length) {
    $str = array_merge(range('a', 'z'), range('0', '9'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
        $r_str .= $str[rand(0, count($str))];
    }
    return $r_str;
}

// 自動ログアウトチェック
function autoLogoutCheck ($login_table, $user_id,$pdo) {
    // 対象のユーザーを取得
    $sql = 'SELECT * FROM login_table WHERE table_number = :table_number and user_id  = :user_id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':table_number',$login_table, PDO::PARAM_STR);
    $stmt->bindValue(':user_id',$user_id, PDO::PARAM_STR);
    $stmt->execute();
    $user3 = $stmt->fetch();
    // 直近のアクション日時をチェックし、last_action_timeから2分経過していれば自動ログアウト
    if (((strtotime('now') - strtotime($user3['last_action_time']))/60) > 1) {
        header('Location:'.SITE_URL.'order.php?type=auto');
        exit();
    } else {
        // 経過していなければlast_action_timeを現在時刻に更新
        $sql = 'UPDATE login_table SET last_action_time = now() WHERE table_number = :table_number';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':table_number', $login_table, PDO::PARAM_STR);
        $stmt->execute();
    }
}


// メールアドレスからuserを検索する
function getUserByEmail($user_email, $pdo) {
    $sql = "SELECT * FROM user WHERE user_email = :user_email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_email" => $user_email));
    $user = $stmt->fetch();
    return $user ? $user : false;
}


// メールアドレスの存在チェック(新規登録用）
function checkEmail0($user_email,$pdo) {
    $sql = "select * from user where user_email = :user_email  limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_email" => $user_email));
    $user = $stmt->fetch();
    return $user ? true : false;
}


// メールアドレスの存在チェック(更新用）

function checkEmail($user_email, $user_id,$pdo) {
    $sql = "select * from user where user_email = :user_email and id  !==  :id limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_email" => $user_email,":id" => $user_id));
    $user = $stmt->fetch();
    return $user ? true : false;
}

// 受注PCメールアドレスの存在チェック(新規登録用）
function checkorder_pc_email0($order_pc_email,$pdo) {
    $sql = "select * from user where order_pc_email = :order_pc_email  limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":order_pc_email" => $order_pc_email));
    $user = $stmt->fetch();
    return $user ? true : false;
}

// 受注PCメールアドレスの存在チェック(更新用）
function checkorder_pc_email($user_email, $user_id,$pdo) {
    $sql = "select * from user where order_pc_email = :order_pc_email and id  !==  :id limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":order_pc_email" => $order_pc_email,":id" => $user_id));
    $user = $stmt->fetch();
    return $user ? true : false;
}

// メールアドレスとパスワードからuserを検索する
function getUser($user_email, $user_password, $pdo) {
    $sql = "select * from user where user_email = :user_email and user_password = :user_password limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_email" => $user_email, ":user_password" => $user_password));
    $user = $stmt->fetch();
    return $user ? $user : false;
}

// 配列からプルダウンメニューを生成する
function arrayToSelect($inputName, $srcArray, $selectedIndex = "") {
    $temphtml = '<select class="form-control" name="'. $inputName. '">'. "\n";
    foreach ($srcArray as $key => $val) {
        if ($selectedIndex == $key) {
            $selectedText = ' selected="selected"';
        } else {
            $selectedText = '';
        }
    $temphtml .= '<option value="'. $key. '"'. $selectedText. '>'. $val. '</option>'. "\n";
    }
    $temphtml .= '</select>'. "\n";
    return $temphtml;
}


// HTMLエスケープ処理
function h($original_str) {
    return htmlspecialchars($original_str, ENT_QUOTES, "UTF-8");
}

// トークンを発行する処理
function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['sstoken'] = $token;
}



// トークンをチェックする処理
function checkToken() {
    if (empty($_SESSION['sstoken']) || ($_SESSION['sstoken'] != $_POST['token'])) {

        $bt = debug_backtrace();
        $filename = $bt[0]['file'];
        $line = $bt[0]['line'];
        echo "$filename $line\n";

        error_log(date("Y/m/d H:i:s")."$filename $line"." で\n403 Error Forbiddenが発生しました。\n".PHP_EOL, 3, "logs/error_log");
        error_log(date("Y/m/d H:i:s")."$filename $line"." で403 Error Forbiddenが発生しました。", 1, "goalhunter.kazu@gmail.com");

        if($_SESSION['tablet_order_sysytem_order']){
            header('Location: '.SITE_URL.'403_order.php');
        }else{
            header('Location: '.SITE_URL.'403.php');
        }

    exit;
    }
}

// ユーザIDからuserを検索する
function getUserbyUserId($user_id, $pdo) {
    $sql = "select * from user where id = :user_id limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_id" => $user_id));
    $user = $stmt->fetch();
    return $user ? $user : false;
}


?>
