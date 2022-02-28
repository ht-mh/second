<?php
session_start();
require('../library.php');
require_once('../functions.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    if(is_null($_SESSION['menu_form'])){
        unset($_SESSION['form']);
        header('Location: mymenu_list.php');
        exit(); 
    }
    var_dump($_SESSION['menu_finish']);
    var_dump($_SESSION['menu_update']);
    // ($_SESSION['menu_check'] !== 'menu_check')|| 
    $menu_form = $_SESSION['menu_form'];
    $db = dbconnect();
    $sql = 'UPDATE menu SET menu_name=?,cooking_date=?,remarks=? WHERE menu_id=? and member_id=?';
    $stmt = $db->prepare($sql);
    if(!$stmt){
        die($db->error);
    }
    $stmt ->bindValue(1,$menu_form['menu_name']);
    $stmt ->bindValue(2,$menu_form['date']);
    $stmt ->bindValue(3,$menu_form['remarks']);
    $stmt ->bindValue(4,$menu_form['id'],PDO::PARAM_INT);
    $stmt ->bindValue(5,$id,PDO::PARAM_INT);
    $success = $stmt->execute();
    if(!$success) {
        die('エラーだぴょん');
    }
    unset($_SESSION['menu_form']);
    unset($_SESSION['menu_update']);
    unset($_SESSION['menu_check']);
    
   
}else{
	header('Location: .././login.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fin_style.css"/>
    <title>こんだて編集</title>
</head>
<body>
<div id="wrap">
    <div id="head">
        <h1>こんだての編集</h1>
    </div>

    <div id="content">
    <p>こんだてを編集しました</p>
    <p><a href=".././index.php">トップページへ</a>|| <a href="mymenu_list.php">マイこんだてページへ</a></p>
    </div>
</div>
</body>
</html>