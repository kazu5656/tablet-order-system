<?php
require_once('config.php');
require_once('functions.php');
session_start();


if (!isset($_SESSION['tablet_order_system_admin'])) {
    header('Location: '.SITE_URL.'login_admin.php');
    exit;
}

$pdo = connectDb();

if($_GET['id']){
    $_SESSION['user_id']=$_GET['id'];
    $id = $_SESSION['user_id'];
}else{
    $id = $_SESSION['user_id'];
}


$user = array();
$sql = "select * from user where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();


$sql = "select * from payment where user_id = :user_id ORDER BY `created_at` DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$id, PDO::PARAM_INT);
$stmt->execute();


?>

<!DOCTYPE html>
<html lang="ja">

    <head>

        <!-- metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
        <meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。">
        <!-- title  -->
        <title>入金履歴 | TABLET ORDER SYSTEM</title>
        <!-- favicon -->
        <link rel="icon" href="images/tablet_order_system_favicon.ico">
        <!-- plugins -->
        <link rel="stylesheet" href="css/plugins.css" />

        <!-- search css -->
        <link rel="stylesheet" href="search/search.css" />
        <!-- custom css -->
        <link href="css/styles.css" rel="stylesheet" id="colors">
        <!-- analyticsの読み込み -->
        <?php include("./analytics.php"); ?>

        <style>

            @media screen and (max-width: 3000px) {

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            #テーブル{margin-top:-150px;padding-top:150px;}

            }
            /*ipad 横幅*/
            @media screen and (max-width: 1024px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            }

            /*ipad 縦幅*/
            @media screen and (max-width: 768px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            }

            /*iphone 縦幅(横)*/
            @media screen and (max-width: 736px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            }

            /*iphone 横幅(短)*/
            @media screen and (max-width: 414px){

            .br-携帯長 { display:none; }
            .br-携帯短 { display:block; }

            }

        </style>

    </head>



    <body>

        <!-- start main-wrapper section -->
        <div class="main-wrapper">

        <?php include("./common_header_admin.php"); ?>

        <br><br><br><br><br>

          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <h6>入金履歴</h6>
                      <p><?php echo h($user['user_name']); ?> 様</p>

                      <table class="table table-bordered">
                          <tr>
                              <th>登録日</th>
                              <th>入金額</th>
                              <th></th>
                          </tr>
                          <?php
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              echo "<tr>";
                              echo "<td>".h($row['created_at'])."</td>";
                              echo "<td>".h($row['payment'])."</td>";
                              echo"<td>
                                      <a href=\"delete_payment.php?id=".h($row['id'])."\" onclick=\"return confirm('削除しても宜しいですか?')\">[削除]</a>
                                   </td>";

                              echo "</tr>";
                          }
                          unset($pdo);
                          ?>
                      </table>

                  </div>
              </div>
          </div>
        </div>
        <!-- end main-wrapper section -->

        <!-- start scroll to top -->
        <a href="javascript:void(0)" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>
        <!-- end scroll to top -->

        <!-- all js include start -->
        <!-- jquery -->
        <script src="js/jquery.min.js"></script>
        <!-- modernizr js -->
        <script src="js/modernizr.js"></script>
        <!-- bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        <!-- navigation -->
        <script src="js/nav-menu.js"></script>
        <!-- serch -->
        <script src="search/search.js"></script>
        <!-- tab -->
        <script src="js/easy.responsive.tabs.js"></script>
        <!-- owl carousel -->
        <script src="js/owl.carousel.js"></script>
        <!-- jquery.counterup.min -->
        <script src="js/jquery.counterup.min.js"></script>
        <!-- stellar js -->
        <script src="js/jquery.stellar.min.js"></script>
        <!-- waypoints js -->
        <script src="js/waypoints.min.js"></script>
        <!-- tab js -->
        <script src="js/tabs.min.js"></script>
        <!-- countdown js -->
        <script src="js/countdown.js"></script>
        <!-- jquery.magnific-popup js -->
        <script src="js/jquery.magnific-popup.min.js"></script>
        <!-- isotope.pkgd.min js -->
        <script src="js/isotope.pkgd.min.js"></script>
        <!--  chart js -->
        <script src="js/chart.min.js"></script>
        <!-- thumbs js -->
        <script src="js/owl.carousel.thumbs.js"></script>
        <!-- animated js -->
        <script src="js/animated-headline.js"></script>
        <!--  clipboard js -->
        <script src="js/clipboard.min.js"></script>
        <!--  prism js -->
        <script src="js/prism.js"></script>

        <!-- map js -->
        <script src="js/map.js"></script>
        <!-- custom scripts -->
        <script src="js/main.js"></script>
        <!-- contact form scripts -->
        <script src="js/mailform/jquery.form.min.js"></script>
        <script src="js/mailform/jquery.rd-mailform.min.c.js"></script>
        <!-- all js include end -->

    </body>



</html>
