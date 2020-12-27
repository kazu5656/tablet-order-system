
<div class="nav navbar-inverse navbar-fixed-top">

    <div class="container-fluid">

      <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
      </div><!-- navbar-header -->

      <div class="collapse navbar-collapse" id="navbar1">

            <ul class="nav navbar-nav" >
                <li class="dropdown">
                    <a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">グループ・メニュー設定 <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu"
                            <?php if (
                                  basename($_SERVER['SCRIPT_NAME']) == 'setting_group.php'
                                  || basename($_SERVER['SCRIPT_NAME']) == 'setting_group_touroku.php'
                                  || basename($_SERVER['SCRIPT_NAME']) == 'setting_food.php'
                                  || basename($_SERVER['SCRIPT_NAME']) == 'setting_food_touroku.php'
                                  || basename($_SERVER['SCRIPT_NAME']) == 'setting_all_food_list.php'
                            ) echo "class=\"active\"" ?>>
                            <li><a href="./setting_group.php">グループ設定</a></li>
                            <li><a href="./setting_food.php">メニュー設定</a></li>
                        </ul>
                </li>

                <li class="dropdown">
                    <a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">売上分析 <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu"
                            <?php if (
                                basename($_SERVER['SCRIPT_NAME']) == 'setting_Sales_monthly_graff.php'
                                || basename($_SERVER['SCRIPT_NAME']) == 'setting_Sales_monthly_sales.php'
                                || basename($_SERVER['SCRIPT_NAME']) == 'setting_Sales_day_sales.php'
                            ) echo "class=\"active\"" ?>>
                            <li><a href="./setting_Sales_monthly_graff.php">月次売上</a></li>
                            <li><a href="./setting_Sales_monthly_sales.php">月別データ</a></li>
                            <li><a href="./setting_Sales_day_sales.php">日別データ</a></li>
                        </ul>
                </li>

                <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_table.php') echo "class=\"active\"" ?>>
                    <a href="./setting_table.php">テーブル管理</a>
                </li>

                <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_today_order.php'|| basename($_SERVER['SCRIPT_NAME']) == 'setting_today_table_order_list.php') echo "class=\"active\"" ?>>
                    <a href="./setting_today_order.php">今日の注文</a>
                </li>

                <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_today_kaikei_list.php'|| basename($_SERVER['SCRIPT_NAME']) == 'setting_today_kaikei_list.php') echo "class=\"active\"" ?>>
                    <a href="./setting_today_kaikei_list.php">今日のお会計</a>
                </li>

                <li <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_sold_out_list.php'|| basename($_SERVER['SCRIPT_NAME']) == 'setting_sold_out_list.php') echo "class=\"active\"" ?>>
                    <a href="./setting_sold_out_list.php">売り切れ</a>
                </li>

                <li class="dropdown">
                    <a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">その他 <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu"
                            <?php if (basename($_SERVER['SCRIPT_NAME']) == 'setting_kaikei_image_import.php'
                            || basename($_SERVER['SCRIPT_NAME']) == 'setting_item_color.php'
                            || basename($_SERVER['SCRIPT_NAME']) == 'setting_account_update.php'
                            ) echo "class=\"active\"" ?>>
                            <li><a href="./setting_kaikei_image_import.php">会計ページ写真登録</a></li>
                            <li><a href="./setting_logo_import.php">注文ページロゴ登録</a></li>
                            <li><a href="./setting_item_color.php">注文ページカラー変更</a></li>
                            <li><a href="./setting_account_update.php">アカウント設定</a></li>
                            <li><a href="http://kazu0520.sakura.ne.jp/wordpress/tabletordersystem-helpsite/tablet-order-system/"target="_blank">ヘルプサイト</a></li>
                        </ul>
                </li>

                <li>
                    <a href="./logout_setting.php">ログアウト</a>
                </li>

            </ul>
        </div><!-- collapse navbar-collapse -->
    </div><!-- container-fluid -->
</div><!-- nav navbar-inverse navbar-fixed-top -->
