<?php
session_start();
require('../library.php');
if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['form'])){
	list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    session_destroy($_SESSION['form']);
}else{
	header('Location: .././login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お買い物リスト作成</title>
</head>
<body>
<div id="wrap">
    <div id="head">
        <h1>お買い物リストを登録できました</h1>
    </div>

    <div id="content">
    <p>お買い物リストに登録しました</p>
    <p><a href=".././index.php">トップページへ</a>|| <a href="../my_shopping/myshopping_list.php">マイショッピングページへ</a></p>
    </div>
</div>
</body>
</html>