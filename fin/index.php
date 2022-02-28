<?php
session_start();
require('library.php');

if(isset($_SESSION['id']) && isset($_SESSION['username'])){
  list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
}else{
    header('Location: login.php');
}
?> 
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title><!--[if lt IE 9]>
<script src="html5.js" type="text/javascript"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="./css/style.css"></head>
<body class="basic2 home" id="hpb-sp-20-0012-10">
<div id="page" class="site">
<header id="masthead" class="site-header sp-part-top sp-header2" role="banner">
<div id="masthead-inner" class="sp-part-top sp-header-inner">
<div id="sp-site-branding2-1" class="sp-part-top sp-site-branding2">
<h1 class="site-title sp-part-top sp-site-title" id=""><a href="index.php">トップページ</a></h1>
<h2 class="site-description sp-part-top sp-catchphrase" id=""></h2>
<div class="extra sp-part-top sp-site-branding-extra" id="sp-site-branding-extra-1">
<p class="tel paragraph"><a href="myprofile.php"><?php echo h($username);?>さん</a></p>
<p class="address paragraph">ぶっちぎれ</p></div></div></div></header>
<div id="main" class="site-main sp-part-top sp-main">
<div id="contenthead" class="sp-part-top sp-content-header">
<nav id="sp-site-navigation-1" class="navigation-main button-menu sp-part-top sp-site-navigation horizontal" role="navigation">
<h1 class="menu-toggle">メニュー</h1>
<div class="screen-reader-text skip-link"><a title="コンテンツへスキップ" href="#content">コンテンツへスキップ</a></div>
<ul id="menu-mainnav">
    <li class="menu-item"><a href="index.php">トップページ</a></li>
    <li class="menu-item"><a href="../fin/profile/profile.php">プロフィール編集</a></li>
    <li class="menu-item"><a href="../fin/shopping/regist.php">お買い物登録</a></li>
    <li class="menu-item"><a href="../fin/my_shopping/myshopping_list.php">商品リスト</a></li>
    <li class="menu-item"><a href="../fin/menu/regist.php">こんだて登録</a></li>
    <li class="menu-item"><a href="../fin/my_menu/mymenu_list.php">こんだてリスト</a></li>
     <li class="menu-item"><a href="contact.php">お問い合せ</a></ul></nav>
<a style="display: block"><img id="sp-image-1" src="" class="sp-part-top sp-image">カレンダー</a>
</div>

<div id="main-inner">
<div id="primary" class="content-area">
<div id="content" class="site-content sp-part-top sp-content page-toppage" role="main">
<header id="sp-page-title-1" class="entry-header sp-part-top sp-page-title">
    <h1 class="entry-title">トップページ</h1>
</header>
<article>
<div id="page-content" class="sp-part-top sp-block-container">
    <p class="large paragraph"></p>
    <p class="paragraph"></p>
</div></article>
<header id="sp-page-title-2" class="entry-header sp-part-top sp-page-title">
<h1 class="entry-title">新着情報</h1></header>
<main>
    <div id="sp-block-container-1" class="sp-part-top sp-block-container">
        
    </div>
</div></div></div></div>
</main>
<?php include('./footer.php'); ?>
</div>
<script type="text/javascript" src="navigation.js"></script>
</body>
</html>