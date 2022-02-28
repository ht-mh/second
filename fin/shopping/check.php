<?php
session_start();
require('../library.php');

if(isset($_SESSION['form']) && isset($_SESSION['id']) && isset($_SESSION['username'])){
  list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);  
	$form = $_SESSION['form'];
}else {
	header('Location: ../login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $db = dbconnect();
  if(is_null($form['shopping_span']) && is_null($form['next_shoppingday'])){
    $sql ='INSERT INTO shopping_list(category, item_name, shopping_day, member_id) VALUES(?,?,?,?)';
    $stmt = $db->prepare($sql);
    if(!$stmt){
      die($db->error);
    }
    $stmt ->bindValue(1,$form['category']);
    $stmt ->bindValue(2,$form['item_name']);
    $stmt ->bindValue(3,$form['date']);
    $stmt ->bindValue(4,$id,PDO::PARAM_INT);
  }else{
    $sql = 'INSERT INTO shopping_list (category, item_name, shopping_day, shopping_span, shopping_next, member_id) VALUES(?,?,?,?,?,?)';
    $stmt = $db->prepare($sql);
    if(!$stmt){
      die($db->error);
    }
    $stmt ->bindValue(1,$form['category']);
    $stmt ->bindValue(2,$form['item_name']);
    $stmt ->bindValue(3,$form['date']);
    $stmt ->bindValue(4,$form['shopping_span']);
    $stmt ->bindValue(5,$form['next_shoppingday']);
    $stmt ->bindValue(6,$id,PDO::PARAM_INT);
  }
  $success = $stmt->execute();
  if(!$success) {
		die('エラーだぴょん');
	}
  header('Location: finish.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/fin_style.css"/>
</head>
<body>
<form action="" method="post">
<div id="content">
  <p>登録しますか？</p>
  <input type="submit" value="登録する" />
</div>
</form>
</body>
</html>