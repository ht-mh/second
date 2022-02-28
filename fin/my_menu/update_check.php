<?php
session_start();
require_once('../library.php');
require_once('../functions.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
  if(($_SESSION['menu_update'] !== 'update_check') || is_null($_SESSION['menu_form'])){
    unset($_SESSION['menu_update']);
    unset($_SESSION['menu_form']);
    header('Location: mymenu_list.php');
    exit(); 
  }
  var_dump($_SESSION['menu_update']);
  list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
}else{
    header('Location: ../login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $_SESSION['menu_finish'] = 'update_finish';
  $_SESSION['menu_update'] = 'update_check';
  header('Location: update_finish.php');
  $db = null;
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
<div id="wrap">
  <div id="head">
      <h1>こんだて編集</h1>
  </div>

  <div id="content">
<body>
  <div id="content">
  <form action="" method="post" enctype="multipart/form-data">
    <p>以下の内容に編集します</p>
    <p>料理名： <?php echo $_SESSION['menu_form']['menu_name']; ?></p>
    <p>作った日： <?php echo $_SESSION['menu_form']['date']; ?></p>
    <?php if($_SESSION['menu_form']['remarks']){?>
    <p>備考欄： <?php echo $_SESSION['menu_form']['remarks']; ?></p>
    <?php } ?>
    <a href="update.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit"  value="編集する" />
  </form>
  </div>
</body>
</html>