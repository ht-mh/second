<?php
session_start();
require('../library.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
	list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    if(!($_SESSION['update'] = 'update_check')|| !$_SESSION['form']){
        unset($_SESSION['form']);
        header('Location: myshopping_list.php');
        exit(); 
    }
}else{
	header('Location: .././login.php');
}
unset($_SESSION['form']);
unset($_SESSION['update']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fin_style.css"/>
    <title>お買い物リスト編集</title>
</head>
<body>
<div id="wrap">
    <div id="head">
        <h1>お買い物リストの編集</h1>
    </div>

    <div id="content">
    <p>お買い物リストを編集しました</p>
    <p><a href=".././index.php">トップページへ</a>|| <a href="../my_shopping/myshopping_list.php">マイショッピングページへ</a></p>
    </div>
</div>
</body>
</html>