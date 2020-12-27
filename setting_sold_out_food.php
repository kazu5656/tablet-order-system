 <?php

require_once('config.php');
require_once('functions.php');

session_start();

// セッションからユーザ情報を取得
$user = $_SESSION['tablet_order_system_setting'];

$pdo = connectDb();

// メニューのI'dがない場合はエラー表示
if(!$_GET['id']){
    echo "この表示位置にはメニューが登録されていないため削除できません。<br/>";
    echo ("<a href=\"setting_food.php\">戻る</a><br/>");
    exit(1);
}

$id = $_GET['id'];

// idのメニューを削除
$sql = "UPDATE food SET
sold_out  = :sold_out,
updated_at = now()
where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':sold_out','売り切れ', PDO::PARAM_STR);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$stmt->execute();

unset($pdo);

// setting_food_menu.phpに画面遷移する。
header('Location: '.SITE_URL.'setting_food.php');

?>
