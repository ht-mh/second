<?php
//remove fanctionを作成する
session_start();
require_once('../library.php');
require_once('../functions.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    if(!$_SESSION['remove_id'] || !($_SESSION['remove'] === 'remove')){
        unset($_SESSION['menu_form']);
        header('Location:  mymenu_list.php');
        exit(); 
    }
    list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    $tn = 'menu';
    $success = db_remove($tn,$_SESSION['remove_id'],$id);
    if(!$success){
        die('削除に失敗しました');
    }
    unset($_SESSION['remove_id']);
}else{
    header('Location:  ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/fin_style.css"/>
    <title>こんだての削除</title>
</head>
<body>
<div id="wrap">
    <div id="head">
        <h1>こんだての削除</h1>
    </div>
    <div id="content">
    <p>こんだてを削除しました</p>
    <p><a href=".././index.php">トップページへ</a> || <a href="myshopping_list.php">ショッピングリストへ戻る</a></p>
    </div>
</div>
</body>
</html>
