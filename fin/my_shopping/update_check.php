<?php
session_start();
require('../library.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    if(!($_SESSION['update'] = 'update')|| !$_SESSION['form']){
        header('Location: myshopping_list.php');
        exit(); 
    }
	list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    $form = $_SESSION['form'];
}else{
	header('Location: .././login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $db = dbconnect();
    if(is_null($form['shopping_span']) && is_null($form['next_shoppingday'])){
        $sql = 'UPDATE shopping_list SET category=?,item_name=?,shopping_day=? WHERE id=? and member_id=?';
        $stmt = $db->prepare($sql);
        if(!$stmt){
            die($db->error);
        }
        $stmt ->bindValue(1,$form['category']);
        $stmt ->bindValue(2,$form['item_name']);
        $stmt ->bindValue(3,$form['date']);
        $stmt ->bindValue(4,$form['id']);
        $stmt ->bindValue(5,$id,PDO::PARAM_INT);
    }else{
        $sql = 'UPDATE shopping_list SET category=?,item_name=?,shopping_day=?,shopping_span=?,
        shopping_next=? WHERE id=? and member_id=?';
        $stmt = $db->prepare($sql);
        if(!$stmt){
            die($db->error);
        }
        $stmt ->bindValue(1,$form['category']);
        $stmt ->bindValue(2,$form['item_name']);
        $stmt ->bindValue(3,$form['date']);
        $stmt ->bindValue(4,$form['shopping_span']);
        $stmt ->bindValue(5,$form['next_shoppingday']);
        $stmt ->bindValue(6,$form['id']);
        $stmt ->bindValue(7,$id,PDO::PARAM_INT);
    }
    $success = $stmt->execute();
    if(!$success) {
        die('エラーだぴょん');
    }
    $db = null;
    $_SESSION['update'] = 'update_check';
    header('Location: update_finish.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fin_style.css"/>
    <title>Document</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <p>以下の内容に編集します</p>
    <p>カテゴリー： <?php echo $form['category']; ?></p>
    <p>商品名： <?php echo $form['item_name']; ?></p>
    <p>購入日： <?php echo $form['date']; ?></p>
    <?php if($form['shopping_span'] && $form['next_shoppingday']){?>
    <p>次回購入日： <?php echo $form['next_shoppingday']; ?></p>
    <?php } ?>
    <a href="update.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="編集する" />
</form>
</body>
</html>