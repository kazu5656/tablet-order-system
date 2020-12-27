<?php

require_once('config.php');
require_once('functions.php');

session_start();

?>

<!DOCTYPE html>
<html lang="ja">

    <head>

        <title>退会完了 | <?php echo SERVICE_NAME; ?></title>
        <?php include("./head_meta.php"); ?>

    </head>

    <body id="main">
        <div class="nav navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?php echo SITE_URL; ?>"><?php echo SERVICE_SHORT_NAME; ?></a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <h1>退会完了</h1>
            <div class="alert alert-success">
                退会が完了しました。ご利用ありがとうございました。
            </div>
            <hr>
            <?php include("./common_footer.php"); ?>
        </div><!--/.container-->
        <?php include("./script.php"); ?>
    </body>



</html>
