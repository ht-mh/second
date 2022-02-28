<?php
session_start();
require('../library.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
	list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
	unset($_SESSION['join']);
}else{
	header('Location: .././login.php');
	exit();
}

if(isset($_SESSION['id']) && isset($_SESSION['username']) && !($_SESSION['join'])){
	header('Location: .././index.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../fin_style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員登録</h1>
</div>

<div id="content">
<p>ユーザー登録が完了しました</p>
<p><a href=".././index.php">トップページへ</a></p>
</div>

</div>
</body>
</html>
