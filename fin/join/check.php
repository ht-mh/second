<?php
session_start();
require('../library.php');

if(isset($_SESSION['form'])){
	$form = $_SESSION['form'];
}else {
	header('Location: ../login.php');
	exit();
}

if(isset($_SESSION['form']) && !($_SESSION['join'])){
	header('Location: .././index.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$db = dbconnect();
	$sql = 'insert into members (username, password) VALUES(?,?)';
	$stmt = $db->prepare($sql);
	if(!$stmt){
		die($db->error);
	}
	$password = password_hash($form['password'], PASSWORD_DEFAULT);
	$stmt->bindValue(1,$form['username']);
	$stmt->bindValue(2,$password);
	$success = $stmt->execute();
	if(!$success) {
		die($db->error);
	}
	
	$sql = 'SELECT id FROM members WHERE username=? limit 1';
    $stmt = $db->prepare($sql);
    if(!$stmt){
        die($db->error);
    }

    //SQL実行
	$stmt->bindValue(1,$form['username']);
    $success = $stmt->execute();
    if(!$success){
        die($db->error);
    }
    $result = $stmt->fetch();

	session_regenerate_id();
    $_SESSION['id'] = $result['id'];
    $_SESSION['username'] = $form['username'];
	unset($_SESSION['form']);
	header('Location: thanks.php');
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

	<link rel="stylesheet" href="../css/fin_style.css" />
</head>

<body>
	<div id="wrap">
		<div id="head">
			<h1>会員登録</h1>
		</div>

		<div id="content">
			<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
			<form action="" method="post">
				<dl>
					<dt>ニックネーム</dt>
					<dd><?php echo h($form['username']); ?></dd>
					<dt>パスワード</dt>
					<dd>
						【表示されません】
					</dd>
				</dl>
				<div><a href="regist.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
			</form>
		</div>

	</div>
</body>

</html>