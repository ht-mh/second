<?php
session_start();
require_once('../library.php');
require_once('../functions.php');

if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    $menu_id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);

    if(is_null($menu_id)){
        header('Location: mymenu_list.php');
        exit();
    }
    $db = dbconnect();
    $sql = 'SELECT * FROM menu WHERE menu_id=? and member_id=?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1,$menu_id);
    $stmt->bindValue(2,$id,PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}else{
    header('Location: .././login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>こんだて</title>
    <link rel="stylesheet" href="../css/fin_style.css"/>
</head>
<body>
<div id="wrap">
    <div id="head">
        <h1>テスト</h1>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
    <div id="content">
        <p><?php echo h($result['menu_name']); ?></p>
        <a href="update.php?id=<?php echo h($result['menu_id']);?>">編集</a>
        <a href="remove_check.php?id=<?php echo h($result['menu_id']);?>">削除</a>
        
    </div>
    </form>
</div>
</body>
</html>