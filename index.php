<?php
require_once('config.php');
require_once('functions.php');
?>

<!DOCTYPE html>
<html lang="ja">





    <head>

        <!-- metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="keywords" content="TABLET ORDER SYSTEM,タブレットでメニューを注文,タブレットオーダーシステム" />
        <meta name="description" content="タブレットでメニューを注文。飲食店の業務効率化に。タブレットを何台使っても月額1000円で始められます。">
        <!-- title  -->
        <title>HOME | TABLET ORDER SYSTEM</title>

        <!-- favicon -->
        <link rel="icon" href="images/tablet_order_system_favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon_tablet-order-system2.JPG">
        <link rel="apple-touch-icon" href="images/apple-touch-icon_tablet-order-system2.JPG">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon_tablet-order-system2.JPG">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon_tablet-order-system2.JPG">
        <!-- plugins -->
        <link rel="stylesheet" href="css/plugins.css" />

        <!-- search css -->
        <link rel="stylesheet" href="search/search.css" />
        <!-- custom css -->
        <link href="css/styles.css" rel="stylesheet" id="colors">
        <!-- analyticsの読み込み -->
        <?php include("./analytics.php"); ?>

        <style>

            /*パソコン*/
            @media screen and (max-width: 3000px) {

            #無料体験{margin-top:-150px;padding-top:150px;}
            #カスタマイズ機能{margin-top:-150px;padding-top:150px;}
            #注文確認{margin-top:-150px;padding-top:150px;}
            #売上分析{margin-top:-150px;padding-top:150px;}
            #お支払い方法{margin-top:-150px;padding-top:150px;}
            #料金比較{margin-top:-150px;padding-top:150px;}
            #年一括払いでさらにお得に。{margin-top:-150px;padding-top:150px;}
            #初期費用はどれくらいかかる？{margin-top:-150px;padding-top:150px;}
            #良くある質問{margin-top:-150px;padding-top:150px;}


            .br-メイン用-pc { display:block; }
            .br-メイン用-タブレット長 { display:none; }
            .br-メイン用-タブレット短 { display:none; }
            .br-メイン用-携帯長 { display:none; }
            .br-メイン用-携帯短 { display:none; }

            .br-pc { display:block; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            .写真{
            border: 2px solid black;
            }

            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 40px;
            }

            /*メイン*/

            #新メイン写真 {
            background-image: url("https://tablet-order-system.com/images/Lady_order.JPG");
            color: white;
            background-repeat:no-repeat;
            background-size: cover;
            background-position: center center;
            width:100%;
            height:800px;

            }

            #メイン_キャッチ{
            color: black;
            font-weight: bold;
            font-size: 40px;
            margin-top: 130px;
            }

            #メイン_サービス名{
            color: orange;
            font-weight: bold;
            font-size: 32px;
            }

            #メイン_説明{
            color: black;
            font-weight: bold;
            font-size: 24px;
            }

            span.ナビメニューの文字 {
            font-size: 18px;
            font-weight: bold;
            color: orange;
            }

            #問い合わせボタン{
            color: white;
            font-weight: bold;
            font-size: 24px;
            }

            #申し込みボタン{
            color: white;
            font-weight: bold;
            font-size: 24px;
            }

            #見出し下の説明{
            font-size: 22px;
            font-weight: bold;
            color: black;
            }



            /*プロモーションビデオ*/

            /*驚くほどスピーディかつリーズナブル*/

            #初期費用の例はこちらボタン{
            margin-top: 5px;
            }

            /*色々なタブレットでサービスを開始できる*/


            .タブレット名{
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            }

            /*アプリ機能*/

            /*他サービスとの料金比較*/

            table{
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            border-color: black;
            }


            th{
            width: 25%;
            background-color: black;
            color: white;
            font-weight: bold;
            }

            #月額{
            vertical-align:middle;
            }

            #項目{
            width:25%;
            }

            #自社名{
            font-size: 26px;
            width:35%;
            color: white;
            font-weight: bold;
            }

            #A社{
            width:20%;
            }

            #B社{
            width:20%;
            }


            .自社金額{
            font-size: 30px;
            background-color:#fcf292;
            color: red;
            }

            #表説明_自社{
            color: red;
            background-color:#fcf292;
            font-weight: bold;
            }

            .表説明{
            color: black;
            font-weight: bold;
            font-size: 18px;
            line-height: 6px;
            }

            #自社タブレット{
            font-size: 20px;
            background-color:#fcf292;
            color: red;
            vertical-align:middle;
            }

            #A社タブレット金額{
            vertical-align:middle;
            font-size: 18px;
            color: black;
            }
            #B社タブレット金額{
            vertical-align:middle;
            font-size: 18px;
            color: black;
            }

            #テーブル下の説明{
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            }

            span.テーブル下の説明_圧倒的にリーズナブル {
            font-size: 24px;
            font-weight: bold;
            }

            #料金比較_今すぐ始めようボタン{
            font-weight: bold;
            font-size: 20px;
            width: 100%;
            }

            #初期費用テーブル{

            }

            #初期費用テーブル_名前{
            width: 48%;
            }

            #初期費用テーブル_金額{
            width: 19%;
            }

            #初期費用テーブル_数量{
            width: 14%;
            }

            #初期費用テーブル_合計{
            width: 19%;
            }

            #初期費用テーブル_合計金額{
            font-size: 24px;
            background-color: yellow;
            }





            /*年一括払いでさらにお得*/

            #年一括払いテーブル{
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
            }

            span.小文字{
            font-weight: bold;
            font-size: 10px;
            }

            #paypalを登録するボタン{
            margin-top: 5px;
            }

            #支払いページへのリンクボタン{
            margin-top: 5px;
            }

            #無料体験を行うボタン{
            margin-top: 5px;
            }


            /* start 良くある質問*/

            #質問テーブル{
            text-align: left;
            }




            }
            /*ipad 長*/
            @media screen and (max-width: 1024px){

            .br-メイン用-pc { display:none; }
            .br-メイン用-タブレット長 { display:block; }
            .br-メイン用-タブレット短 { display:none; }
            .br-メイン用-携帯長 { display:none; }
            .br-メイン用-携帯短 { display:none; }

            .br-pc { display:block; }
            .br-タブレット横 { display:block; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 40px;
            }



            /*メイン*/

            #新メイン写真 {
            background-image: url("https://tablet-order-system.com/images/Lady_order.JPG");
            color: white;
            background-repeat:no-repeat;
            background-size: cover;
            background-position: center center;
            width:100%;
            height:700px;
            }

            #メイン_キャッチ{
            color: black;
            font-weight: bold;
            font-size: 32px;
            }

            #メイン_サービス名{
            color: orange;
            font-weight: bold;
            font-size: 32px;
            }

            #メイン_説明{
            color: black;
            font-weight: bold;
            font-size: 24px;
            }

            span.ナビメニューの文字 {
            font-size: 14px;
            font-weight: bold;
            color: orange;
            }

            #問い合わせボタン{
            color: white;
            font-weight: bold;
            font-size: 24px;

            }

            #申し込みボタン{
            color: white;
            font-weight: bold;
            font-size: 24px;

            }
            #見出し下の説明{
            font-size: 22px;
            font-weight: bold;
            color: black;
            }



            /*プロモーションビデオ*/

            #video{
            width:100%;
            height:500px;
            }

            /*驚くほどスピーディかつリーズナブル*/

            /*色々なタブレットでサービスを開始できる*/



            /*アプリ機能*/



            /*他サービスとの料金比較1024*/

            table{
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            border-color: black;
            }



            #月額{
            vertical-align:middle;
            }

            #項目{
            width:25%;
            }

            #自社名{
            font-size: 22px;
            width:35%;
            color: white;
            font-weight: bold;
            }




            .自社金額{
            font-size: 30px;
            background-color:#fcf292;
            color: red;
            }

            #表説明_自社{
            color: red;
            background-color:#fcf292;
            font-weight: bold;
            }

            .表説明{
            color: black;
            font-weight: bold;
            font-size: 15px;
            line-height: 6px;
            }

            #自社タブレット{
            font-size: 18px;
            background-color:#fcf292;
            color: red;
            vertical-align:middle;
            }

            #A社タブレット金額{
            vertical-align:middle;
            font-size: 18px;
            color: black;
            }
            #B社タブレット金額{
            vertical-align:middle;
            font-size: 18px;
            color: black;
            }

            #テーブル下の説明{
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            }

            span.テーブル下の説明_圧倒的にリーズナブル {
            font-size: 24px;
            font-weight: bold;
            }

            #料金比較_今すぐ始めようボタン{
            font-weight: bold;
            font-size: 20px;
            width: 100%;
            }



            /* start 良くある質問*/




            }
            /*ipad 短*/
            @media screen and (max-width: 768px){

            .br-メイン用-pc { display:none; }
            .br-メイン用-タブレット長 { display:none; }
            .br-メイン用-タブレット短 { display:block; }
            .br-メイン用-携帯長 { display:none; }
            .br-メイン用-携帯短 { display:none; }

            .br-pc { display:block; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:none; }

            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 25px;
            }


            /*メイン*/

            #新メイン写真 {
            background-image: url("https://tablet-order-system.com/images/Lady_order.JPG");
            color: white;
            background-repeat:no-repeat;
            background-size: cover;
            background-position: center center;
            width:100%;
            height:500px;
            margin-top:100px;
            }

            #メイン_キャッチ{
            color: black;
            font-weight: bold;
            font-size: 28px;
            margin-top: 80px;
            }

            #メイン_サービス名{
            color: orange;
            font-weight: bold;
            font-size: 28px;
            }

            #メイン_説明{
            color: black;
            font-weight: bold;
            font-size: 18px;
            }

            span.ナビメニューの文字 {
            font-size: 14px;
            font-weight: bold;
            color: orange;
            }

            #問い合わせボタン{
            color: white;
            font-weight: bold;
            font-size: 18px;
            }

            #申し込みボタン{
            color: white;
            font-weight: bold;
            font-size: 18px;
            }

            #見出し下の説明{
            font-size: 19px;
            font-weight: bold;
            color: black;
            }


            /*プロモーションビデオ*/

            #video{
            width:100%;
            height:300px;
            }
            /*驚くほどスピーディかつリーズナブル*/

            /*色々なタブレットでサービスを開始できる*/

            /*アプリ機能*/

            #アプリの機能_文章{
            font-size: 12px;
            }

            /*他サービスとの料金比較*/

            table{
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            border-color: black;
            }

            #月額{
            vertical-align:middle;
            }

            #項目{
            width:25%;
            }

            #自社名{
            font-size: 18px;
            width:35%;
            color: white;
            font-weight: bold;
            }

            .自社金額{
            font-size: 30px;
            background-color:#fcf292;
            color: red;
            }

            #表説明_自社{
            color: red;
            background-color:#fcf292;
            font-weight: bold;
            }

            .表説明{
            color: black;
            font-weight: bold;
            font-size: 12px;
            line-height: 6px;
            }

            #自社タブレット{
            font-size: 15px;
            background-color:#fcf292;
            color: red;
            vertical-align:middle;
            }

            #A社タブレット金額{
            vertical-align:middle;
            font-size: 14px;
            color: black;
            }
            #B社タブレット金額{
            vertical-align:middle;
            font-size: 14px;
            color: black;
            }

            #テーブル下の説明{
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            }

            span.テーブル下の説明_圧倒的にリーズナブル {
            font-size: 18px;
            }

            #料金比較_今すぐ始めようボタン{
            font-weight: bold;
            font-size: 16px;
            width: 100%;
            }



            /* start 良くある質問*/

            #質問テーブル{
            text-align: left;
            font-size: 15px;
            }



            }

            /*iphone 長*/
            @media screen and (max-width: 736px){

            .br-メイン用-pc { display:none; }
            .br-メイン用-タブレット長 { display:none; }
            .br-メイン用-タブレット短 { display:none; }
            .br-メイン用-携帯長 { display:block; }
            .br-メイン用-携帯短 { display:none; }

            .br-pc { display:none; }
            .br-携帯長 { display:block; }
            .br-携帯短 { display:none; }

            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 24px;
            }



            /*メイン*/

            #新メイン写真 {
            background-image: url("https://tablet-order-system.com/images/Lady_order.JPG");
            color: white;
            background-repeat:no-repeat;
            background-size: cover;
            background-position: center center;
            width:100%;
            height:330px;
            margin-top:100px;
            }

            #メイン_キャッチ{
            color: black;
            font-weight: bold;
            font-size: 20px;
            margin-bottom:5px;
            margin-top: 40px;

            }

            #メイン_サービス名{
            color: orange;
            font-weight: bold;
            font-size: 18px;
            margin-bottom:5px;
            }

            #メイン_説明{
            color: black;
            font-weight: bold;
            font-size: 15px;
            }

            span.ナビメニューの文字 {
            font-size: 14px;
            font-weight: bold;
            color: orange;
            }

            #問い合わせボタン{
            color: white;
            font-weight: bold;
            font-size: 13px;

            }

            #申し込みボタン{
            color: white;
            font-weight: bold;
            font-size: 13px;

            }

            #見出し下の説明{
            font-size: 19px;
            font-weight: bold;
            color: black;
            }



            /*プロモーションビデオ*/

            #video{
            width:100%;
            height:320px;
            }

            /*驚くほどスピーディかつリーズナブル*/

            /*色々なタブレットでサービスを開始できる*/



            /*アプリ機能*/

            #アプリの機能_文章{
            font-size: 14px;
            }



            /*携帯(長)他サービスとの料金比較*/

            table{
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            border-color: black;
            }



            #月額{
            vertical-align:middle;
            }

            #項目{
            width:20%;
            }

            #自社名{
            font-size: 14px;
            width:40%;
            color: white;
            font-weight: bold;
            }


            .自社金額{
            font-size: 28px;
            background-color:#fcf292;
            color: red;
            }

            #表説明_自社{
            color: red;
            background-color:#fcf292;
            font-weight: bold;
            }

            .表説明{
            color: black;
            font-weight: bold;
            font-size: 10px;
            line-height: 6px;
            }

            #自社タブレット{
            font-size: 13px;
            background-color:#fcf292;
            color: red;
            vertical-align:middle;
            }

            #A社タブレット金額{
            vertical-align:middle;
            font-size: 13px;
            color: black;
            }
            #B社タブレット金額{
            vertical-align:middle;
            font-size: 13px;
            color: black;
            }

            #テーブル下の説明{
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            }

            span.テーブル下の説明_圧倒的にリーズナブル {
            font-size: 20px;
            }

            #料金比較_今すぐ始めようボタン{
            font-weight: bold;
            font-size: 16px;
            width: 100%;

            }


            /* start 良くある質問*/


            }

            /*iphone 短*/
            @media screen and (max-width: 414px){

            #無料体験{margin-top:-20px;padding-top:20px;}
            #カスタマイズ機能{margin-top:-20px;padding-top:20px;}
            #注文確認{margin-top:-20px;padding-top:20px;}
            #売上分析{margin-top:-20px;padding-top:20px;}
            #お支払い方法{margin-top:-20px;padding-top:20px;}
            #料金比較{margin-top:-20px;padding-top:20px;}
            #料金比較{margin-top:-20px;padding-top:20px;}
            #年一括払いでさらにお得に。{margin-top:-20px;padding-top:20px;}
            #初期費用はどれくらいかかる？{margin-top:-20px;padding-top:20px;}
            #良くある質問{margin-top:-20px;padding-top:20px;}


            .br-メイン用-pc { display:none; }
            .br-メイン用-タブレット長 { display:none; }
            .br-メイン用-タブレット短 { display:none; }
            .br-メイン用-携帯長 { display:none; }
            .br-メイン用-携帯短 { display:block; }

            .br-pc { display:none; }
            .br-携帯長 { display:none; }
            .br-携帯短 { display:block; }



            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 15px;
            }


            /*メイン*/

            #新メイン写真 {
            background-image: url("https://tablet-order-system.com/images/Lady_order.JPG");
            color: white;
            background-repeat:no-repeat;
            background-size: cover;
            background-position: center center;
            width:100%;
            height:330px;
            margin-top:100px;
            }

            #メイン_キャッチ{
            color: black;
            font-weight: bold;
            font-size: 14px;
            margin-bottom:5px;
            margin-top: 50px;
            }

            #メイン_サービス名{
            color: orange;
            font-weight: bold;
            font-size: 14px;
            margin-bottom:5px;
            }

            #メイン_説明{
            color: black;
            font-weight: bold;
            font-size: 11px;
            }

            span.ナビメニューの文字 {
            font-size: 14px;
            font-weight: bold;
            color: orange;
            }

            #問い合わせボタン{
            color: white;
            font-weight: bold;
            font-size: 12px;
            }

            #申し込みボタン{
            color: white;
            font-weight: bold;
            font-size: 12px;
            }

            #見出し下の説明{
            font-size: 19px;
            font-weight: bold;
            color: black;
            }



            /*プロモーションビデオ*/

            #video{
            width:100%;
            height:260px;
            }

            /*驚くほどスピーディかつリーズナブル*/

            /*色々なタブレットでサービスを開始できる*/



            /*アプリ機能*/

            #アプリの機能_文章{
            font-size: 14px;
            }



            /*携帯他サービスとの料金比較*/

            table{
            text-align: center;
            font-weight: bold;
            font-size: 7px;
            border-color: black;
            }


            #月額{
            vertical-align:middle;
            }

            #項目{
            width:25%;
            }

            #自社名{
            font-size: 10px;
            width:31%;
            color: white;
            font-weight: bold;
            }

            #A社{
            width:22%;
            font-size: 10px;
            }

            #B社{
            width:22%;
            font-size: 10px;
            }


            .自社金額{
            font-size: 16px;
            background-color:#fcf292;
            color: red;
            }

            .他社金額{
            font-size: 9px;
            }



            #表説明_自社{
            color: red;
            background-color:#fcf292;
            font-weight: bold;
            font-size: 9px;
            }

            .表説明{
            color: black;
            font-weight: bold;
            font-size: 8px;
            line-height: 9px;
            }

            #自社タブレット{
            font-size: 8px;
            background-color:#fcf292;
            color: red;
            line-height: 8px;
            vertical-align:middle;
            }

            #他社タブレット説明{
            font-size: 8px;
            }

            #A社タブレット金額{
            vertical-align:middle;
            font-size: 6px;
            color: black;
            line-height: 8px;
            }

            #B社タブレット金額{
            vertical-align:middle;
            font-size: 6px;
            color: black;
            line-height: 8px;
            }

            .一列目_項目名{
            font-size: 7px;
            }

            #テーブル下の説明{
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            }

            span.テーブル下の説明_圧倒的にリーズナブル {
            font-size: 14px;
            }

            #料金比較_今すぐ始めようボタン{
            font-weight: bold;
            font-size: 16px;
            width: 100%;

            }


            #初期費用テーブル{
            font-size: 9px;
            }

            #初期費用テーブル_合計金額{
            font-size: 12px;
            background-color: yellow;
            }


            #年一括払いテーブル{
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            }


            /* start 良くある質問 携帯*/

            #質問テーブル{
            text-align: left;
            font-size: 12px;
            }

            }

        </style>

    </head>



    <body>

        <!-- start main-wrapper section -->
        <div class="main-wrapper">

            <?php include("./common_header_index.php"); ?>

            <!-- start メイン -->
            <div class="container-fluid">
                <div class="row">
              		  <div class="col-md-12" id="新メイン写真">
          		          <h1 id="メイン_キャッチ">
                          月額￥1,000で始められる<br>タブレットオーダーシステム
          		          </h1>
          		          <h2 id="メイン_サービス名">
          								TABLET ORDER SYSTEM
          							</h2>
          		          <h6 id="メイン_説明">
          								驚くほどスピーディかつリーズナブル。<br>タブレットを何台使っても<br>月額1,000円のみの<br class="br-メイン用-携帯短" />サブスクリプション形式で<br>飲食店の業務効率化を実現する<br class="br-メイン用-携帯短" />新時代のWebサービス。
          							</h6>
          							<a href="index_mousikomi.php" class="btn btn-primary" role="button" id="申し込みボタン">
          								申し込みはこちらから
          							</a>
          							<a href="index_query.php" class="btn btn-success" role="button" id="問い合わせボタン">
          								お問い合わせ
          							</a>
              		  </div><!-- col-md-12 -->
                </div><!-- row -->
            </div><!-- container-fluid -->

        </div>
        <!-- end メイン-->


        <!-- start プロモーションビデオ -->
        <section>
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">TABLET ORDER SYSTEM</h2>
                    <p>
        							TABLET ORDER SYSTEMは飲食店に来店した<br class="br-携帯短" />お客様が<br class="br-pc" />
                      <strong>タブレットを使って<br class="br-携帯短" /><br class="br-携帯長" />メニューを注文できるサービス</strong>です。
                      <br class="br-携帯短" /><br class="br-pc" /><strong>飲食店の回転率の向上や<br class="br-携帯長" />人件費の削減、<br class="br-携帯短" />利益の向上</strong>に大きく貢献します。
        						</p>
                </div><!-- section-heading -->
                <div class="row feature-boxes-container" >
          					<div class="col-md-2">
          					</div><!-- col-md-2 -->
          					<div class="col-md-8">
          						<iframe id="video" width="720" height="420" src="https://www.youtube.com/embed/zn0Vun0TfuQ" alt="タブレットオーダーシステムのプロモーションビデオ" frameborder="0" allow="accelerometer; autoplay; gyroscope; picture-in-picture" allowfullscreen></iframe>
          					</div><!-- col-md-8 -->
          					<div class="col-md-2">
          					</div><!-- col-md-2 -->
                </div><!-- row feature-boxes-container -->
            </div><!-- container -->
        </section>
        <!-- end プロモーションビデオ -->


        <!-- start コロナに負けない -->
        <section>
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							コロナに負けない。
        						</h2>
                    <p>
                      withコロナ時代。<br>タブレットで注文するシステムを<br>取り入れている飲食店が増えています。
        						</p>
                </div><!-- section-heading -->
                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
          							<div class="owl-carousel owl-theme text-center">
          									<div class="item">
                              <img src="images/smile_girl.JPG" alt="飲食店のかわいい女の子">
                            </div>
          							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
                                <p>
                                  <strong>コロナ対策①</strong><br>
                                  注文時のお客様とスタッフの接触や<br>会話を減らすことができお客様の安心につながります。
                                </p>
                                <p>
                                  <strong>コロナ対策②</strong><br>
                                  圧倒的にリーズナブルな初期費用と月額で<br>始めることができ人件費削減につながるので<br>飲食店の経営を助けます。
                                </p>
                                <p>
                                  <strong>コロナ対策③</strong><br>
                                  注文時の業務効率化を図ることができ<br>消毒作業やその他の業務に取り組みやすくなります。
                                </p>
        										</div>
        								</div>
        						</div>
        				</div>
            </div><!-- container -->
        </section>
        <!-- end コロナに負けない -->

        <!-- start テラスで注文 -->
        <section>
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							テラス営業での注文にも便利。
        						</h2>
                    <p>
                      コロナ対策でテラス営業を始める<br class="br-携帯短" />お店が増えています。<br>
                      テラス営業で発生するお悩みも<br class="br-携帯短" />タブレットオーダーシステムなら<br class="br-携帯短" />解決できます。
        						</p>
                </div><!-- section-heading -->
                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
          							<div class="owl-carousel owl-theme text-center">
          									<div class="item"><img src="images/terrace_order.JPG" alt="テラスで注文"></div>
          							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
                                <p>
                                  <strong>テラス営業の悩み①</strong><br>
                                  テラスにスタッフが常駐できない。
                                </p>
                                <p>
                                  <strong>テラス営業の悩み②</strong><br>
                                  騒音で注文時にお客様の声が<br class="br-携帯短" />店の中に届かない。
                                </p>
                                <p>
                                  <strong>どちらの悩みも簡単に解決</strong><br>
                                  タブレットオーダーシステムなら<br>
                                  テラスにスタッフが常駐しなくても<br>
                                  どんなにテラス周辺が騒がしくても<br>
                                  簡単に注文を受けることができます。
                                </p>
        										</div>
        								</div>
        						</div>
        				</div>
            </div><!-- container -->
        </section>
        <!-- end テラスで注文 -->


        <!-- start 驚くほどスピーディかつリーズナブル -->
        <section>
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							驚くほどスピーディかつリーズナブル。
        						</h2>
                    <p>
        							他サービスより<strong>圧倒的に安く、速く、<br class="br-携帯短" />簡単に導入することが可能</strong>です。<br class="br-携帯短" /><br class="br-pc" /><br class="br-携帯長" />年一括払いでさらにお得になります。
        						</p>
                </div><!-- section-heading -->

                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
          							<div class="owl-carousel owl-theme text-center">
          									<div class="item"><img src="images/staff_smile.JPG" alt="飲食店の夫婦"></div>
          							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
        												<h6>申し込みから1ヶ月で導入できます。</h6>
                                <p>
                                  ①申し込み・入金・新規登録(即日)<br>
                                  ②各種設定(1-2週間)<br>
                                  　・グループ登録<br>
                                  　・メニュー登録<br>
                                  　・注文メニューのカラー設定<br>
                                  　・会計時の写真設定<br>
                                  ③タブレットや受注PCを設置(1-2週間)<br>
                                  ④タブレットオーダーシステム導入開始
                                </p>
                                <h6>圧倒的に安く導入できます。</h6>
                                <p>
                                  ・タブレットを何台使っても月額は1000円。<br>
                                  ・ライセンス料などは一切かかりません。<br>
                                  ・安価なタブレットを使いコストカット。<br>
                                  <a href="https://tablet-order-system.com/#初期費用はどれくらいかかる？" class="butn medium theme" id="初期費用の例はこちらボタン">
        														<span class="alt-font">初期費用の例はこちら</span><i class="fas fa-angle-right font-size16 sm-font-size14 text-white margin-10px-left"></i>
        													</a>
                                </p>
        										</div>
        								</div>
        						</div>
        				</div><!-- row -->

            </div><!-- container -->
        </section>
        <!-- end 驚くほどスピーディかつリーズナブル -->


        <!-- start 色々なタブレットでサービスを開始できる -->
        <section id="FREE TABLET">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							色々なタブレットでサービスを開始できる
        						</h2>
                    <p>
        							定番のブラウザを使える<br class="br-携帯短" />タブレットであれば何でもOK。
                      <br><strong>安価なタブレットも使える</strong>ので安心です。<br>
                      他サービスでは高額なタブレットを<br class="br-携帯短" />準備しないといけないことも...。<br>
                      推奨ブラウザ <br class="br-携帯短" /><strong>Safari</strong>・<strong>Chrome</strong>・<strong>Firefox</strong>・<strong>Edge</strong>
        						</p>
                </div><!-- section-heading -->
                <div class="row">
                    <div class="col-md-4">
                        <img src="images/tablet_ios.PNG" alt="iPad">
                        <p class="タブレット名"><strong>ipad</strong></p>
                    </div>
                    <div class="col-md-4">
                        <img src="images/tablet_android.PNG" alt="androidのタブレット">
                        <p class="タブレット名"><strong>android</strong></p>
                    </div>
                    <div class="col-md-4">
                        <img src="images/tablet_kindle2.PNG" alt="kindle fire">
                        <p class="タブレット名"><strong>kindle fire</strong></p>
                    </div>
                </div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end 色々なタブ レットでサービスを開始できる -->


        <!-- start お支払い方法 -->
        <section  id="お支払い方法">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							お支払い方法
        						</h2>
                    <p>
        							paypalと銀行振り込みで<br class="br-携帯短" />簡単にお支払い頂けます。
        						</p>
                </div><!-- section-heading -->
                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
        							<div class="owl-carousel owl-theme text-center">
        									<div class="item"><img src="images/paypal3.JPG" alt="paypalのロゴ"></div>
        							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
                                <p>
                                  <strong>paypal</strong><br>
                                  1.paypalアカウントに<br class="br-携帯短" />支払方法を登録します。<br>
                                  支払方法にはクレジットカードや<br class="br-携帯短" />銀行口座を登録できます。<br>

                                  <a href="https://www.paypal.com/"target="_blank" class="butn medium theme" id="paypalを登録するボタン">
        															<span class="alt-font">paypalを登録する</span><i class="fas fa-angle-right font-size16 sm-font-size14 text-white margin-10px-left"></i>
        													</a>
                                  <br>
                                  2.支払いページからログインして<br class="br-携帯短" />お支払い下さい。<br>
                                  <a href="https://tablet-order-system.com/index_pay1.php"target="_blank" class="butn medium theme" id="支払いページへのリンクボタン">
        															<span class="alt-font">支払いページ</span><i class="fas fa-angle-right font-size16 sm-font-size14 text-white margin-10px-left"></i>
        													</a>
                                </p>
                                <p>
                                  <strong>銀行振り込み</strong><br>
                                  指定の口座にお振り込み下さい。aaa
                                </p>
        										</div>
        								</div>
        						</div>
        				</div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end  お支払い方法 -->



        <!-- start 無料体験 -->
        <section id="無料体験">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							無料体験
        						</h2>
                    <p>
                      TABLET ORDER SYSTEMを<br class="br-携帯短" />1週間無料体験できます。
        						</p>
                </div><!-- section-heading -->
                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
          							<div class="owl-carousel owl-theme text-center">
          									<div class="item"><img src="images/tablet_woman.JPG" alt="タブレットを使う女性"></div>
          							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
        												<h6>無料で全ての機能をお試し頂けます。</h6>
                                <p>
                                  実際に使ってみないと<br class="br-携帯短" />どんなものかわからず<br>
                                  不安な方は<br class="br-携帯短" />１週間の無料体験がおすすめです。<br>
                                  設定メニューから<br class="br-携帯短" />グループやメニューを登録し<br>
                                  注文メニューで<br class="br-携帯短" />実際に注文を行ってみましょう。<br>
                                  <a href="https://tablet-order-system.com/index_Experience_signup.php"target="_blank" class="butn medium theme" id="無料体験を行うボタン">
        															<span class="alt-font">無料体験を行う。</span><i class="fas fa-angle-right font-size16 sm-font-size14 text-white margin-10px-left"></i>
        													</a><br><br>
                                  ※１週間経過すると<br class="br-携帯短" />体験用のアカウントやデータは<br>
                                  自動的に消去されますのでご注意ください。<br><br>
                                  ※無料体験はお手持ちのタブレットのみ、<br>もしくはPCのみでも実施できますが<br>
                                  注文用のタブレット（携帯でも可）と<br>注文受注用のPCの両方があるのが理想です。
                                </p>
        										</div>
        								</div>
        						</div>
        				</div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end  無料体験  -->


        <!-- start 便利なアプリの機能 -->
        <section>
            <div class="container" >
                <div class="section-heading">
                    <h3 class="大見出し">便利なアプリの機能</h3>
                    <p class="width-55 sm-width-75 xs-width-95">
                      飲食店の業務効率化を実現する<br class="br-携帯短" />便利なアプリの機能を備えています。
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box-02">
                            <div class="img-box"><img class="写真" src="images/order_menu2.JPG" alt="注文画面" /></div>
                            <div class="feature-textbox padding-25px-all sm-padding-20px-tb sm-padding-15px-lr text-center bg-light-gray">
                                <h4 class="title font-size22 sm-font-size20 font-weight-600 alt-font margin-10px-bottom">カスタマイズ機能</h4>
                                <p class="feature-desc sm-font-size14 sm-line-height-26 sm-margin-15px-bottom" id="アプリの機能_文章">
                                  注文メニューに表示する<br>グループやメニューなどは<br>簡単にカスタマイズできます。<br><br>
                                  <a class="read-more" href="https://tablet-order-system.com/#カスタマイズ機能"><i class="fa fa-play-circle"></i>詳細はこちら</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box-02">
                            <div class="img-box"><img class="写真" src="images/order_list2.JPG" alt="注文一覧画面" /></div>
                            <div class="feature-textbox padding-25px-all sm-padding-20px-tb sm-padding-15px-lr text-center bg-light-gray">
                                <h4 class="title font-size22 sm-font-size20 font-weight-600 alt-font margin-10px-bottom">注文確認</h4>
                                <p class="feature-desc sm-font-size14 sm-line-height-26 sm-margin-15px-bottom" id="アプリの機能_文章">
                                  注文は注文一覧画面や<br>テーブル別未対応注文リスト、<br>メールで迅速に確認できます。<br><br>
                                  <a class="read-more" href="https://tablet-order-system.com/#注文確認"><i class="fa fa-play-circle"></i>詳細はこちら</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box-02">
                            <div class="img-box"><img class="写真" src="images/monthly_data.PNG" alt="月別データ" /></div>
                            <div class="feature-textbox padding-25px-all sm-padding-20px-tb sm-padding-15px-lr text-center bg-light-gray">
                                <h4 class="title font-size22 sm-font-size20 font-weight-600 alt-font margin-10px-bottom">売上分析</h4>
                                <p class="feature-desc sm-font-size14 sm-line-height-26 sm-margin-15px-bottom" id="アプリの機能_文章">
                                  日別・月別データや<br>月次売上推移グラフで<br>売上を分析できます。<br><br>
                                  <a class="read-more" href="https://tablet-order-system.com/#売上分析"><i class="fa fa-play-circle"></i>詳細はこちら</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end 便利なアプリの機能 -->


        <!-- start カスタマイズ機能 -->
        <section id="カスタマイズ機能">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							カスタマイズ機能
        						</h2>
                    <p>
        							注文メニューに表示する<br class="br-携帯短" />グループやメニューなどは<br class="br-携帯短" />簡単にカスタマイズできます。
        						</p>
                </div><!-- section-heading -->
                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
        							<div class="owl-carousel owl-theme text-center">
        									<div class="item"><img class="写真" src="images/order_menu2.JPG" alt="注文画面"></div>
                          <div class="item"><img class="写真" src="images/IMG_1223.jpg" alt="会計ページ" /></div>
                          <div class="item"><img class="写真" src="images/logo2.jpg" alt="注文画面のロゴ" /></div>
        							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
                                <p>
                                  <strong>グループ</strong><br>
                                  グループを16個まで登録できます。
                                </p>
                                <p>
                                  <strong>メニュー</strong><br>
                                  メニュー名、金額、写真、<br class="br-携帯短" />グループ、表示位置を<br>登録できます。
                                </p>
                                <p>
                                  <strong>カラー変更</strong><br>
                                  メニューのカラーは９色から選択できます。
                                </p>
                                <p>
                                  <strong>売切れ</strong><br>
                                  売切れ表示に変更することが可能です。
                                </p>
                                <p>
                                  <strong>会計写真</strong><br>
                                  会計時の写真を登録できます。
                                </p>
                                <p>
                                  <strong>お店のロゴ</strong><br>
                                  注文画面に表示するお店の<br class="br-携帯短" />ロゴを登録できます。
                                </p>
        										</div>
        								</div>
        						</div>
        				</div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end カスタマイズ機能 -->
        <hr>

        <!-- start 注文確認 -->
        <section id="注文確認">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							注文確認
        						</h2>
                    <p>
        							注文は注文一覧画面やメールで<br class="br-携帯短" />迅速に確認できます。
        						</p>
                </div><!-- section-heading -->
                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
        							<div class="owl-carousel owl-theme text-center">
        									<div class="item"><img class="写真" src="images/order_list.jpg" alt="注文一覧"></div>
                          <div class="item"><img class="写真" src="images/order_table.jpg" alt="テーブル別注文リスト" /></div>
                          <div class="item"><img  class="写真" src="images/MAIL2.PNG" alt="注文メール" /></div>
        							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
                                <p>
                                  <strong>お客様からの呼び出し</strong><br>
                                  お客様から呼び出しのあるテーブル番号は<br>青色に変わります。<br>
                                  対応後、テーブル番号をクリックすると<br>白色に変わります。
                                </p>
                                <p>
                                  <strong>今日の注文一覧</strong><br>
                                  最新の注文が表の上部に表示されます。<br>
                                  「対応」ボタンを押すと「対応済」と<br class="br-携帯短" />表示されます。<br>
                                  画面は30秒毎に最新の情報に更新されます。
                                </p>
                                <p>
                                  <strong>テーブル別未対応注文リスト</strong><br>
                                  未対応の注文リストをテーブル別に<br class="br-携帯短" />表示しています。<br>
                                  注文後、10分以上経過して未対応の場合は<br>10分経過と表示されます。<br>
                                  対応ボタンを押すと<br class="br-携帯短" />リストから削除されます。<br>
                                </p><!-- row -->
                                <p>
                                  <strong>メールによるお知らせ</strong><br>
                                  呼び出し、注文、会計の時に受注PCに<br class="br-携帯短" />メールが届きます。
                                </p>
        										</div>
        								</div>
        						</div>
        				</div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end 注文確認-->
        <hr>

        <!-- start 売上分析 -->
        <section id="売上分析">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
        							売上分析
        						</h2>
                    <p>
        							日別・月別データや月次売上推移グラフで<br class="br-携帯短" />売上を分析できます。
        						</p>
                </div><!-- section-heading -->
                <div class="row">
        						<div class="col-lg-6 col-md-12 sm-margin-50px-bottom xs-margin-30px-bottom">
          							<div class="owl-carousel owl-theme text-center">
          									<div class="item"><img class="写真" src="images/monthly_data.PNG" alt="日別・月別データ"></div>
                            <div class="item"><img class="写真" src="images/monthly_graff4.PNG" alt="折れ線グラフ" /></div>
          							</div>
        						</div>
        						<div class="col-lg-6 col-md-12">
        								<div class="padding-70px-left md-padding-50px-left sm-no-padding">
        										<div class="display-table-cell vertical-align-middle width-100">
                                <p>
                                  <strong>日別・月別データ</strong><br>
                                  日・月単位で何がどれくらい売れたかを<br class="br-携帯短" />分析できます。<br>
                                  日別は過去10日間、月別は過去12カ月間の<br>データを確認できます。
                                </p>
                                <p>
                                  <strong>月次売上推移グラフ</strong><br>
                                  過去12ヵ月の売り上げの推移を<br>折れ線グラフで把握できます。<br>
                                  「対応」ボタンを押すと<br class="br-携帯短" />「対応済」と表示されます。<br>
                                  画面は30秒毎に最新の情報に更新されます。
                                </p>
        										</div>
        								</div>
        						</div>
        				</div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end 注文確認-->


        <!-- start 他サービスとの料金比較 -->
        <hr>
        <section  id="料金比較">
            <div class="container">

                <div class="section-heading">
                    <h2 class="各セクション見出し">
            					他サービスとの料金比較
            				</h2>
                </div><!-- section-heading -->

                <div class="row position-relative">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th id="項目"></th>
                                    <th id="自社名">当サービス</th>
                                    <th id="A社">A社</th>
                                    <th id="B社">B社</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="月額" class="一列目_項目名"rowspan="2">月額</td>
                                    <td class="自社金額">¥1,000</td>
                                    <td class="他社金額">¥5,000</td>
                                    <td class="他社金額">¥10,000</td>
                                </tr>
                                <tr>
                                    <td class="表説明" id="表説明_自社">タブレットを<br class="br-携帯短" />何台使っても<br class="br-携帯短" />¥1,000。</td>
                                    <td class="表説明"colspan="2">タブレット<br class="br-携帯短" />1台当たりに<br class="br-携帯短" />月額がかかる。</td>
                                </tr>
                                <tr>
                                   <td class="一列目_項目名">ライセンス料</td>
                                    <td class="自社金額">¥0</td>
                                    <td class="他社金額">¥300,000</td>
                                    <td class="他社金額">¥100,000</td>
                                </tr>
                                <tr>
                                   <td class="一列目_項目名">メニュー作成</td>
                                    <td class="自社金額">¥0</td>
                                    <td class="他社金額">¥150,000</td>
                                    <td class="他社金額">¥400,000</td>
                                </tr>
                                <tr>
                                    <td id="月額" class="一列目_項目名"rowspan="2">タブレット<br>購入費(1台)</td>
                                    <td id="自社タブレット">タブレットは<br class="br-携帯短" />安価なものでOK!!</td>
          													<td id="他社タブレット説明"colspan="2">専用タブレットのみ対応。</td>
                                </tr>
                                <tr>
                                    <td id="自社タブレット">（参考価格）<br class="br-携帯短" /><br class="br-携帯長" /><br class="br-pc" />¥5,000-30,000</td>
                                    <td id="A社タブレット金額">（参考価格）<br class="br-携帯短" /><br class="br-携帯長" /><br class="br-pc" />¥29,800</td>
                                    <td  id="B社タブレット金額">（参考価格）<br class="br-携帯短" /><br class="br-携帯長" /><br class="br-pc" />¥34,800</td>
                                </tr>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                        <p id="テーブル下の説明">会社によって様々な料金形態がありますが<br class="br-携帯短" />TABLET ORDER SYSTEM は<br class="br-携帯短" /><strong><span class="テーブル下の説明_圧倒的にリーズナブル"><br class="br-携帯長" />圧倒的にリーズナブル</span></strong>です。</p>
                        <a href="index_mousikomi.php" class="btn btn-primary" role="button" id="料金比較_今すぐ始めようボタン">申し込みはこちらから</a>
                    </div><!-- col-md-12 -->
                </div><!-- row position-relative -->

            </div><!-- container -->
        </section>
        <!-- end 他サービスとの料金比較 -->

        <br><br><br>


        <!-- start 初期費用はどれくらいかかる？ -->
        <hr>
        <section  id="初期費用はどれくらいかかる？">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">
          						初期費用はどれくらいかかる？
          					</h2>
                    <p><strong>10,000円のタブレットを<br class="br-携帯短" />20台用意する場合の初期費用の例</strong>です。<br>
                      注文受注タブレットは<br class="br-携帯短" />お手持ちのタブレットや<br>PCがあれば準備する必要はありません。
                    </p>
                </div><!-- section-heading -->
                    <table class="table table-bordered"id="初期費用テーブル">
                        <thead>
                            <tr>
                                <th id="初期費用テーブル_名前">名前</th>
                                <th id="初期費用テーブル_金額">金額</th>
                                <th id="初期費用テーブル_数量">数</th>
                                <th id="初期費用テーブル_合計">合計</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>注文タブレット</td>
                                <td>￥10,000</td>
                                <td>20</td>
                                <td>￥200,000</td>
                            </tr>
                            <tr>
                                <td>タブレットスタンド</td>
                                <td>￥2,000</td>
                                <td>20</td>
                                <td>￥40,000</td>
                            </tr>
                            <tr>
                                <td>Wi-Fiルーター</td>
                                <td>￥15,000</td>
                                <td>1</td>
                                <td>￥15,000</td>
                            </tr>
                            <tr>
                                <td>注文受注タブレット</td>
                                <td>￥10,000</td>
                                <td>1</td>
                                <td>￥10,000</td>
                            </tr>
                            <tr>
                                <td>月額</td>
                                <td>￥1,000</td>
                                <td>1</td>
                                <td>￥1,000</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="初期費用テーブル_合計金額">￥266,000</td>

                            </tr>
                        </tbody>
                    </table>
        </section>
        <!-- end 初期費用はどれくらいかかる？ -->


        <!-- start 年一括払いでさらにお得  -->
        <section>
            <div class="container">
                <div class="section-heading" id="年一括払いでさらにお得に。">
                    <h2 class="各セクション見出し">
        							年一括払いでさらにお得に。
        						</h2>
                    <p>
        							年一括払いで<span color="blue">月額は833円</span>に。
        						</p>
                </div><!-- section-heading -->

                <!-- start table section -->
                    <table class="table table-bordered" id="年一括払いテーブル">
                      <tr>
                          <th>月払い</th>
                          <th>年一括払い</th>
                      </tr>
                      <tr>
                          <td>¥1,000<span class="小文字"> /1ヶ月</span></td>
                          <td>¥10,000<span class="小文字"> /12ヶ月</span></td>
                      </tr>
                    </table>
                <!-- end table section -->

                <br><br><br>

            </div><!-- container -->
        </section>
        <!-- end 年一括払いでさらにお得 -->
        <hr>

        <!-- start 良くある質問 -->
        <section id="良くある質問">
            <div class="container">
                <div class="section-heading">
                    <h2 class="各セクション見出し">良くある質問</h2>
                </div><!-- section-heading -->
                <div class="row">
                      <!-- start table section -->
                      <table class="table table-bordered" id="質問テーブル">
                            <tr>
                                <th>Q.初期費用はどれくらいかかる？</th>
                            </tr>
                            <tr>
                                <td>A.例えば10000円のタブレットを20台用意する場合、25−30万の初期費用がかかります。<br>
                                <a href="https://tablet-order-system.com/#初期費用はどれくらいかかる？">初期費用の詳細はこちら</a></td>
                            </tr>
                            <tr>
                                <th>Q.どんなタブレットが使える？</th>
                            </tr>
                            <tr>
                                <td>A.推奨ブラウザ(Safari・Chrome・Firefox・Edge)が使えるものであれば何でもOKです。<br>
                                「Android」「iOS」「Windows」「kindlefire」など様々なタブレットが使えます。</td>
                            </tr>
                            <tr>
                                <th>Q.お客様の操作は簡単？</th>
                            </tr>
                            <tr>
                                <td>A.難しい操作は一切なくシンプル操作で簡単です。</td>
                            </tr>
                            <tr>
                                <th>Q.利益につながる？</th>
                            </tr>
                            <tr>
                                <td>A.安価な初期費用で始められ人件費を確実に抑えられるのでお店の利益につながるでしょう。<br>（利益を100％保証するものではありません。）</td>
                            </tr>
                            <tr>
                                <th>Q.何メニューまで登録できる？</th>
                            </tr>
                            <tr>
                                <td>A.メニューは96個まで登録できます。<br>(16グループ×6メニュー)</td>
                            </tr>
                            <tr>
                                <th>Q.グループ名は最大何文字で登録できる？</th>
                            </tr>
                            <tr>
                                <td>A.グループ名は最大10文字で登録できます。</td>
                            </tr>
                            <tr>
                                <th>Q.メニュー名は最大何文字で登録できる？</th>
                            </tr>
                            <tr>
                                <td>A.メニュー名は最大15文字で登録できます。</td>
                            </tr>
                            <tr>
                                <th>Q.テーブル数は何テーブルまで対応できる？</th>
                            </tr>
                            <tr>
                                <td>A.テーブル数は60テーブルまで対応できます。</td>
                            </tr>
                            <tr>
                                <th>Q.途中退会できる？</th>
                            </tr>
                            <tr>
                                <td>A.アカウント設定から簡単に退会できます。<br>ただし、メニューなどの全てのデータが消去されるのでご注意下さい。</td>
                            </tr>
                            <tr>
                                <th>Q.申し込みからどれくらいでサービスを開始できる？</th>
                            </tr>
                            <tr>
                                <td>A.1ヶ月もあればサービスを開始出来ます。</td>
                            </tr>
                            <tr>
                                <th>Q.支払い方法は？</th>
                            </tr>
                            <tr>
                                <td>A.PAYPAL、もしくは銀行振り込みで<br class="br-携帯短" />お支払い頂けます。<br>
                                  <a href="https://tablet-order-system.com/#お支払い方法">お支払い方法の詳細はこちら</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Q.面倒な手続きが必要？</th>
                            </tr>
                            <tr>
                                <td>A.面倒で手間がかかる手続きは一切不要です。</td>
                            </tr>
                            <tr>
                                <th>Q.エラーは発生する？</th>
                            </tr>
                            <tr>
                                <td>A.お客様の想定外の動作やサーバーの状況等によって<br>エラーが発生することがあります。</td>
                            </tr>
                            <tr>
                                <th>Q.エラーはすぐに改善できる？</th>
                            </tr>
                            <tr>
                                <td>エラー画面に表示される対応方法を実施すれば<br class="br-携帯短" />すぐに改善されます。<br>システムの稼働監視を常に行っておりますので
                                  <br>サーバーの問題でエラーが発生しても3分ほどで自動復旧するようになっています。
                                </td>
                            </tr>
                      </table>
                  <!-- end table section -->
                </div><!-- row -->
            </div><!-- container -->
        </section>
        <!-- end 良くある質問 -->



        <?php include("./common_footer_index.php"); ?>

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
