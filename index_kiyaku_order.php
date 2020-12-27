
<?php
require_once('config.php');
require_once('functions.php');

session_start();

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
        <title>有料コンテンツ購入規約 | TABLET ORDER SYSTEM</title>
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

            #問い合わせ_申し込みボタン{
            float: left;
            }
            span.メインタイトル {
            font-size: 42px;
            }
            .アプリ機能_タイトル{
            text-align: center;
            }
            #良くある質問_他サービスとの料金比較表{
            text-align: center;
            }
            #良くある質問_推奨ブラウザ{
            text-align: center;
            }



            @media screen and (max-width: 3000px) {


            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 40px;
            text-align: left;
            }

            #販売者情報{
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 20px;
            }

            .lead{
            font-weight: bold;
            }

            h1{
            margin-top: 50px;
            font-weight: bold;
            }



            }
            /*ipad 横幅*/
            @media screen and (max-width: 1024px){


            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 40px;
            }


            }
            /*ipad 縦幅*/
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

            h1{
            margin-top: 80px;
            }


            }

            /*iphone 縦幅(横)*/
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
            text-aline: left;
            }

            #各セクション見出し下_説明{
            color: black;
            font-weight: bold;
            font-size: 14px;
            }

            h1{
            margin-top: 80px;
            }



            }

            /*iphone 横幅(短)*/
            @media screen and (max-width: 414px){



            .各セクション見出し{
            color: black;
            font-weight: bold;
            font-size: 15px;
            }

            #各セクション見出し下_説明{
            color: black;
            font-weight: bold;
            font-size: 12px;
            }

            h1{
            font-size: 22px;
            font-weight: bold;
            margin-top: 80px;
            }

            .lead{
            font-size: 16px;
            }

            }

        </style>

    </head>



    <body>

        <!-- start main-wrapper section -->
        <div class="main-wrapper">

          <?php include("./common_header_index.php"); ?>
            <!-- end header section -->

          <!-- start セクション１ TABLET ORDER SYSTEM -->
          <section>
              <div class="container">
              <h1>有料コンテンツ購入規約</h1>
              <hr>
                  <div class="row" >
                      <div class="col-md-9">
                          <p>
                          	この規約（以下、「本規約」といいます）は、飲食店向けWebサービス<b>「TABLET ORDER SYSTEM」</b>のご利用にあたり、
                            有料サービスを利用する会員と当社の間の権利義務関係を定めることを目的とし、有料サービスを利用するすべての会員に適用されます。
                          </p><br>

                          <p class="lead" style="padding-bottom:0;">第1条（定義）</p>
                          <p>
                          	本規約において使用する用語の定義については、次のとおりとします。<br><br>
                          	(1)「本サービス」とは、当社が運営する飲食店向けWebサービス<b>「TABLET ORDER SYSTEM」</b>の
                            名称で提供する飲食店の受注業務に関連するサービスをいいます。<br><br>
                          	(2)「本サイト」とは、当社が本サービス提供のために運営するウェブサイト全体をいいます。<br><br>
                          	(3)「契約者」とは、本規約に同意し、当社が提供する有料のサービスを受講するために
                            所定の契約者情報の登録手続を行い、料金支払手続を行った方をいいます。<br><br>
                          	(4)「有料コンテンツ」とは、本サービスのうち、料金を支払うことによって利用することが可能になるコンテンツ
                            （モバイル端末による注文機能、モバイル端末やPCによる注文受付機能、メールの受信機能、その他のデータなどを含み、
                            またこれらに限られません）をいいます。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第2条（本規約への同意）</p>
                          <p>
                          	1　契約を希望する方（以下、「契約希望者」といいます）が本規約に従って本サービスの契約手続をした場合には、
                            本規約に同意したものとみなします。<br><br>
                          	2　本サービスに関して、本規約とは別に規約、ガイドライン、ポリシーなどの名称で当社が配布または掲示している文書がある場合には、
                            契約者は本規約の他、それらの定めにも従って本サービスを利用しなければなりません。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第3条（本規約の変更）</p>
                          <p>
                          	当社は、本規約の内容を契約者に事前に告知することなく変更できるものとします。
                            変更後の本規約の内容は、本サイトに掲示するものとし、その後契約者が初めて有料コンテンツを
                            利用した時点または変更内容が本サイト上に掲示されてから1か月が経過した時点のいずれか早い時点をもって、
                            契約者に変更後の本規約が適用されるものとします。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第4条（契約者情報）</p>
                          <p>
                          	1　契約希望者は、当社所定の手続において、当社が定める必要事項を本サイト上に入力の上、契約者情報の登録を行います。<br><br>
                          	2　契約者は、契約者情報を登録する場合、いかなる虚偽の申告も行わず、真実、正確かつ完全な情報を提供しなければなりません。<br><br>
                          	3　契約者は、登録した契約者情報に変更があった場合には、登録変更手続を行い、最新の情報に更新するよう努めなければなりません。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第5条（未成年の契約者）</p>
                          <p>
                          	有料コンテンツの契約希望者が未成年の場合、法定代理人の同意を得ることが必要です。
                            法定代理人の同意なく有料コンテンツを契約することはできません。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第6条（契約者情報の取扱い）</p>
                          <p>
                          	当社は、第4条によって得られた契約者の個人情報を、個人情報の保護に関する法律および当社が定める
                            プライバシーポリシーに従い、適正に取り扱います。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第7条（ID等の管理）</p>
                          <p>
                          	1　契約者は、ID（メールアドレス）、パスワード（以下、「ID等」といいます）の管理責任を負うものとします。<br><br>
                          	2　契約者は、ID等を第三者に利用させたり、貸与、譲渡、売買、質入れ等をしたりすることはできないものとします。
                            ID等が第三者に利用された場合であっても、当該ID等を用いて行われた行為については、契約者が行ったものとみなします。<br><br>
                          	3　当社に責任がないID等の管理不十分、使用上の過誤、第三者の使用等による損害の責任は契約者が負うものとし、
                            当社は一切責任を負わないものとします。
                            ID等が不正に利用されたことにより当社に損害が生じた場合には、契約者は当社に対し、その損害を賠償するものとします。<br><br>
                          	4　契約者は、ID等を第三者に知られた場合、あるいはID等を第三者に使用されている疑いがある場合には、
                            直ちに当社にその旨連絡するとともに、
                            当社の指示がある場合にはこれに従うものとします。<br><br>
                          	5　契約者は、定期的にパスワード変更する義務があるものとし、その義務を怠ったことにより損害が生じた場合、
                            当社は一切の責任を負わないものとします。<br><br>
                            6　一つの契約（一つのID)でサービスを利用できるのは１店舗のみとなります。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第8条（有料コンテンツの利用停止）</p>
                          <p>
                          	1　当社は、契約者が以下に定める事由に1つでも該当するときは、契約者の有料コンテンツの利用を停止することができます。<br>
                            　(1)有料コンテンツの料金の支払が3ヶ月滞った場合<br>
                            　(2)契約者情報に誤りがあり、相当期間にわたり当社からの連絡が取れない場合<br>
                            　(3)契約者が契約した有料コンテンツを第三者に利用させた場合<br>
                            　(4)反社会的勢力（暴力団、暴力団員、暴力団準構成員、暴力団関係企業、総会屋、社会運動等標ぼうゴロ、特殊知能暴力集団、その他これらに準じる者をいいます）である場合、または反社会的勢力と関与している場合<br>
                            　(5)第13条に定める禁止事項に違反した場合<br>
                            　(6)その他、当社が契約者に有料コンテンツの利用を継続させることが不適当であると判断した場合<br><br>
                          	2　前項の有料コンテンツ利用の停止事由が消滅した場合には、当社は契約者からの通知に基づいて、有料コンテンツの利用を再開させることができます。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第9条（有料コンテンツの提供）</p>
                          <p>
                          	1　第4条の契約者情報登録をして購入手続を行ったことにより、契約者は有料コンテンツの利用を開始することができます。<br><br>
                          	2　契約者は、モバイル端末による注文機能、モバイル端末やPCによる注文受付機能、注文メールの受信機能、注文メニューのカスタマイズ機能、
                            売上データの確認などの機能を使うことができます。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第10条（有料コンテンツの料金）</p>
                          <p>
                          	1　本サービスの料金は、月払いもしくは年一括払いかに応じて別途定めるとおりとします。<br><br>
                          	2　本サービスを利用するにあたり、必要なモバイル端末、PC、通信機器、通信設備、モバイル端末設置台等については契約者が費用を負担し、準備するものとします。
                          </p>


                          <p class="lead" style="padding-bottom:0;">第11条（有料コンテンツ利用期間）</p>
                          <p>
                          	当社が提供する有料コンテンツの利用期間については無制限とし、当社が有料コンテンツの提供を継続する限りにおいて、契約者は有料コンテンツの利用を継続できるものとします。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第12条（有料コンテンツの変更・追加・中断等）</p>
                          <p>
                          	1　当社は、契約者に事前の通知をすることなく、有料コンテンツの内容の変更・追加を行うことができます。ただし、契約者にとって重要な内応が変更・追加される場合は必ず、事前に通知を行います。<br><br>
                          	2　当社は、以下に定める場合に、有料コンテンツの全部または一部の利用を一時中断、停止することができます。これにより契約者に損害および不利益が生じても、次項に定める場合を除き、当社は一切責任を負いません。<br>
                          　(1)システムの保守点検または更新など、管理運営上必要な場合<br>
                          　(2)天災、火災、停電などの不可抗力により有料コンテンツの提供が困難となった場合<br>
                          　(3)戦争、内乱、暴動等により本サービスの運営が不能となった場合<br>
                          　(4)通信機器およびコンピュータシステムなどの障害、不正アクセス、コンピュータウイルスの感染、通信回線等に不具合・事故等が発生した場合<br>
                          　(5)本サービスの運営が困難となった場合<br>
                          　(6)その他当社が有料コンテンツ利用の一時中断もしくは停止が必要であると判断する場合<br>
                          </p>

                          <p class="lead" style="padding-bottom:0;">第13条（禁止事項）</p>
                          <p>
                          	契約者は、有料コンテンツの利用に当たり、以下に定める事由に該当する行為を行ってはなりません。<br>
                            　(1)法令、裁判所の判決、決定若しくは命令、または法令上拘束力のある行政措置に違反する行為<br>
                            　(2)公の秩序または善良の風俗を害するおそれのある行為<br>
                            　(3)当社または第三者の知的財産権・プライバシー・肖像権等を侵害する行為、または侵害するおそれがある行為<br>
                            　(4)本サービスの運営を妨げる、または妨げるおそれのある一切の行為<br>
                            　(5)その他、当社が不適切であると判断する一切の行為<br>
                          </p>

                          <p class="lead" style="padding-bottom:0;">第14条（有料コンテンツ提供の終了）</p>
                          <p>
                          当社は、有料コンテンツ提供の運営が著しく困難になる等、やむをえない事由が生じた場合には、有料コンテンツの一部、または全部の提供を終了できるものとします。<br>
                          </p>

                          <p class="lead" style="padding-bottom:0;">第15条（契約上の地位の譲渡）</p>
                          <p>
                          	契約者は、当社の書面による事前の承諾がない限り、契約者としての地位を第三者に承継させ、
                            または契約者としての資格に基づく自己の権利義務の全部または一部を第三者に対して譲渡し、承継させ、または担保に供することはできないものとします。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第16条（当社からの解除）</p>
                          <p>
                          	契約者が本規定に違反する場合、第8条第1項に定める事項に継続的に該当する場合には、
                            当社は有料コンテンツの購入・利用の契約を解除することができます。<br>
                          </p>

                          <p class="lead" style="padding-bottom:0;">第17条（免責事項）</p>
                          <p>
                          	1　当社は、以下に定める場合において、何らの責任も負わないものとします。<br>
                          	　(1)当社が合理的な安全策を講じたにもかかわらず、有料コンテンツの無断改変、有料コンテンツへの不正アクセス、コンピュータウイルスの混入等の不正行為が行われ、これに起因して契約者に生じた損害および不利益<br>
                          	　(2)その他、有料コンテンツの利用により生じる一切の損害<br><br>
                          	2　当社との有料コンテンツの契約により、飲食店の売上や利益が増えることまでを保証するものではありません。<br>
                          </p>

                          <p class="lead" style="padding-bottom:0;">第18条（損害賠償）</p>
                          <p>
                          	契約者が本規約に違反し、当社に対して損害を与えた場合、故意過失を問わず、契約者は自己の費用と責任をもって、
                            当社に生じた損害を賠償するものとします。
                          </p>

                          <p class="lead" style="padding-bottom:0;">第19条（協議条項）</p>
                          <p>
                          	本規約に定めのない事項、または本規約に関連して契約者と当社との間で紛争が生じた場合には、双方誠実に協議し、
                            解決することに努めるものとします。
                          </p>

                      </div><!-- col-md-9 -->

                      <div class="col-md-3">
                          <?php include("./common_info.php"); ?>
                      </div><!-- col-md-3 -->

                  </div><!-- row -->

              </div><!-- container -->
          </section>
          <!-- end セクション１ TABLET ORDER SYSTEM -->

          <hr>

          <!-- start footer section -->
          <?php include("./common_footer_index.php"); ?>
          <!-- end footer section -->

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
