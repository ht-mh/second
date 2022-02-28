<?php
session_start();
require_once('../library.php');
require_once('../functions.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
    $db = dbconnect();
    $sql = 'SELECT count(*) FROM menu WHERE member_id=?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1,$id,PDO::PARAM_INT);
    $stmt->execute();
    $cnt = $stmt->fetchColumn();
    if($cnt > 0){
        if(is_null($_SESSION['orderby']) || $_SESSION['orderby'] === 'asc' || $_SESSION['orderby'] === '----'){
            $sql = 'SELECT * FROM menu WHERE member_id=? ORDER BY cooking_date';
        }elseif($_SESSION['orderby'] === 'desc'){
            $sql = 'SELECT * FROM menu WHERE member_id=?  ORDER BY cooking_date DESC';
        }
        unset($_SESSION['orderby']);
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

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $_SESSION['orderby'] = filter_input(INPUT_POST, 'orderby');
    if(is_null($_SESSION['orderby']) ||$_SESSION['orderby'] === 'desc'|| $_SESSION['orderby'] === '----'){
        $sql = 'SELECT * FROM menu WHERE member_id=? ORDER BY cooking_date DESC';
    }elseif( $_SESSION['orderby'] === 'asc'){
        $sql = 'SELECT * FROM menu WHERE member_id=? ORDER BY cooking_date';
    }
    var_dump($_SESSION['orderby']);
    unset($_SESSION['orderby']);
    $stmt = $db->prepare($sql);
    if(!$stmt){
        die('エラーだぴょん');
    }
    $stmt->bindValue(1,$id,PDO::PARAM_INT);
    $success = $stmt->execute();
    if(!$success){
        die('エラーだぞ');
    }
    $change_order = '並び替えました';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>こんだて表</title>
    <link rel="stylesheet" href="../css/fin_style.css" />
</head>
<body>
<form action="" method="post">
<div id="wrap">
    <div id="head">
        <h1>こんだて表</h1>
    </div>
    <div id="content">
        <div id="Read">
            <?php if($change_order){ ?>
                <p><?php echo h($change_order);?></p>
            <?php } ?>
            <p><?php echo h($username);?>さんのこんだて一覧</p>
            <?php if($cnt > 0){  ?>
        <select name="orderby" >
            <option hidden>----</option>
            <option value='asc'>昇順</option>
            <option value="desc">降順</option>
            <div><input type="submit" value="並び替える"/></div>
        </select>
        
        <table>
            <tr>
                <th>作った日</th>
                <th>料理名</th>
                
            </tr>
            <?php
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            ?>
             <tr>
                <th><?php echo h($row['cooking_date']);?></th>
                <th><a href="menu_remarks.php?id=<?php echo h($row['menu_id']);?>"><?php echo h($row['menu_name']);?></a></th>
            </tr>
            <?php
                }
                $db = null;
                unset($row);
            ?>
        </table>
        <?php }else{?>
            <p>表示できるものがありません</p>
        <?php } ?>
        <p><a href=".././index.php">トップページへ</a>|| <a href="../menu/regist.php">こんだてを追加する</a></p>
        </div>
    </div>  
    </form>
</div>
</body>
</html>