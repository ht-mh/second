<?php
session_start();
require_once('../library.php');
require_once('../functions.php');

if(isset($_SESSION['id']) && isset($_SESSION['username'])){
	list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    $_SESSION['remove_id'] = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
}else{
	header('Location: .././login.php');
    exit();
}

$result = shop_id($_SESSION['remove_id'],$id);
if($result === 'false'){
    unset($_SESSION['form']);
    header('Location: myshopping_list.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $_SESSION['remove'] = 'remove';
    header('Location: remove.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="../css/fin_style.css"/>
    <title>商品の削除</title>
</head>
<body>
<div id="wrap">
    <div id="head">
        <h1>商品リストから削除</h1>
    </div>
    <form action="" method="POST">
    <div id="content">
        <div id="Read">
            <p><?php echo h($username);?>さん</p>
            <p>本当に削除しますか？</p>
            <div><p><a href=".././index.php">トップページに戻る</a>||</p><input type="submit" value="削除する"/></div>
        </div>
    </div>
    </form>
</body>
</html>
