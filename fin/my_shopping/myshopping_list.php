<?php
session_start();
require('../library.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
	list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    $db = dbconnect();
    $sql = 'SELECT count(*) FROM shopping_list WHERE member_id=?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1,$id,PDO::PARAM_INT);
    $stmt->execute();
    $cnt = $stmt->fetchColumn();
    if($cnt > 0){
        $sql = 'SELECT * FROM shopping_list WHERE member_id=?';
        $stmt = $db->prepare($sql);
        if(!$stmt){
            die('エラーだぴょん');
        }
        $stmt->bindValue(1,$id,PDO::PARAM_INT);
        $success = $stmt->execute();
        if(!$success){
            die('エラーだぞ');
        }
    }
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
    <title>ショッピングリスト</title>
    <link rel="stylesheet" href="../css/fin_style.css" />
</head>
<body>
<form action="" method="POST">
<div id="wrap">
    <div id="head">
        <h1>マイショッピングリスト</h1>
    </div>
    <div id="content">
        <div id="Read">
            <p><?php echo h($username);?>さんの商品リスト</p>
        <?php if($cnt > 0){  ?>
        <table>
            <tr>
                <th>カテゴリー</th>
                <th>商品名</th>
                <th>お買い物日</th>
                <th>次回購入日</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            ?>
             <tr>
                <th><?php echo h($row['category']);?></th>
                <th><?php echo h($row['item_name']);?></th>
                <th><?php echo h($row['shopping_day']);?></th>
                <?php if(is_null($row['shopping_next'])){?>
                <th>----</th>
        <?php }else{ 
                    $alert_day = date_cal($row['shopping_next']); 
                    if($alert_day <= 0){
        ?>
                        <th><p class="alert"><?php echo h($row['shopping_next']);?></p></th>
              <?php }else{ ?>
                    <th><?php echo h($row['shopping_next']);?></th>
                <?php 
                    }
                }
                ?>
                <th><button type="button" onclick="location.href='update.php?id=<?php echo h($row['id']); ?>'">編集</button></th>
                <th><button type="button" onclick="location.href='remove_check.php?id=<?php echo h($row['id']); ?>'">削除</button></th>
            </tr>
            <?php
                }
                $db = null;
            ?>
            
            <tr>
            </tr>
        </table>
        <?php }else{?>
            <p>表示できるものがありません</p>
        <?php } ?>
        <p><a href=".././index.php">トップページへ</a>|| <a href="../shopping/regist.php">商品を追加する</a></p>
        </div>
    </div>  
    </form>
</div>
</body>
</html>