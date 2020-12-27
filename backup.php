<?php

require_once('config.php');
require_once('functions.php');


$pdo = connectDb();

$period_day = '1'; // 単位は日

$backup_filename = 'db_bkup_'.date('Y_m_d_H_i').'.sql';

$backup_dirpath = '/var/app/tablet_order_system/web/backup/';

$backup_filepath = $backup_dirpath.$backup_filename;


  # --------------------------------------
#  BACKUP 実行
# --------------------------------------
# 必要であればフォルダのパーミッション適宜変更
system( "chmod 777 ".$backup_dirpath);
# BACKUP 実行
system( "mysqldump --default-character-set=utf8 ".DB_NAME." --host=".DB_HOST." --user=".DB_USER." --password=".DB_PASSWORD." > ".$backup_filepath );
// ※「xserver」の場合

// 例えば「minibird」の場合
// system( "$MYSQLPATH/mysqldump --default-character-set=utf8 --host=\"$DBHOST\" --user=\"$DBUSER\" --password=\"$DBPASS\"  \"$DBNAME\"  > \"$backup_filepath\"" );



# --------------------------------------
#  保管期間より過去のファイル削除 実行
# --------------------------------------
system( "find ".$backup_dirpath." -type f -daystart -mtime +".$period_day." | xargs rm -rv {} \ " );


# --------------------------------------
#  保管期間より過去のファイル削除 実行 -- 上記systemコマンドを使用しない別バージョン --
# --------------------------------------
// $rmTime = time() - 60*60*24*$period_day; // 保管期間日時の時間を求める

// $checkfiles = $backup_dirpath.'*'; // 全てのバックアップgzipファイルをチェックする

// foreach (glob($checkfiles) as $filename)
// {
//     // 指定日より前のファイルなら
//     if( filemtime($filename) < $rmTime )
//     {
//         // 削除実行
//         unlink($filename);
//     }
// }


# 必要であればフォルダのパーミッションを元に戻す

?>
