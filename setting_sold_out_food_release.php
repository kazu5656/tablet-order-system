 <?php

require_once('config.php');
require_once('functions.php');

session_start();

if (!isset($_SESSION['tablet_order_system_setting'])) {
    header('Location: '.SITE_URL.'login_setting.php');
    exit;
}

// セッションからユーザ情報を取得
$user = $_SESSION['tablet_order_system_setting'];

$pdo = connectDb();

// メニューのI'dがない場合はエラー表示
if(!$_GET['id']){
    header('Location: '.SITE_URL.'setting_food.php');
}

$id = $_GET['id'];

// idのメニューの売り切れ状態を解除
$sql = "UPDATE food SET
sold_out  = :sold_out,
updated_at = now()
where id = :id and user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':sold_out',null, PDO::PARAM_STR);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$stmt->bindValue(':user_id',$user['id'], PDO::PARAM_INT);
$stmt->execute();

unset($pdo);

// setting_food_menu.phpに画面遷移する。
header('Location: '.SITE_URL.'setting_food.php');

?>
