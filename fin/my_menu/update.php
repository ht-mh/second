<?php
//menuのupdateはfinishに入る時に行うテスト
session_start();
require_once('../library.php');
require_once('../functions.php');
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
  list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
  $menu_id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
  $tn = 'menu';
}else{
    header('Location: ../login.php');
    exit();
}

$result = result_count($tn,$menu_id,$id);
$_SESSION['result'] =$result;
if($result === 'false'){
    if($_SESSION['form']){
        unset($_SESSION['form']);
    }
    $_SESSION['tn'] = $tn;
    header('Location: mymenu_list.php');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['menu_form'])){
    $menu_form = $_SESSION['menu_form'];
}else{
    $menu_form = [
        'id' => '',
        'menu_name' =>'',
        'date' =>'',
        'remarks' => ''
    ]; 
}

$error = [];
$db = dbconnect();
$sql = 'SELECT * FROM menu WHERE id=? and member_id=?  limit 1';
        $stmt = $db->prepare($sql);
        if(!$stmt){
            die('エラーだぴょん');
        }
        $stmt->bindValue(1,$update_id,PDO::PARAM_INT);
        $stmt->bindValue(2,$id,PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $menu_form['id'] = $menu_id;
    $menu_form['menu_name'] = filter_input(INPUT_POST, 'menu_name', FILTER_SANITIZE_STRING);
    $year = filter_input(INPUT_POST, 'cooking_year', FILTER_SANITIZE_STRING);
    $month = filter_input(INPUT_POST, 'cooking_month', FILTER_SANITIZE_STRING);
    $day = filter_input(INPUT_POST, 'cooking_day', FILTER_SANITIZE_STRING);
    $menu_form['remarks'] = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if($menu_form['menu_name'] === '' ){
        $error['mandatory'] ='blind';
    }elseif($year === '' || $month === '' || $day === ''){
        $error['day'] = 'blind';
    }else{
        //エラー地獄
        if((strlen($menu_form['remarks']) > 600)){
            $error['remarks_length'] = 'remarks_length';
        }
        if(strlen($menu_form['menu_name']) > 20){
            $error['menu_length'] = 'menu_length';
        }
        list($menu_form['date'],$timestamp) = timestamp($year,$month,$day);
        $sql = 'SELECT count(*) FROM menu WHERE menu_name=? and cooking_date=? and member_id=?';
        $stmt = $db->prepare($sql);
        if(!$stmt){
            die('エラーだぴょん');
        }
        $stmt->bindValue(1,$menu_form['menu_name']);
        $stmt->bindValue(2,$menu_form['date']);
        $stmt->bindValue(3,$id,PDO::PARAM_INT);
        $stmt->execute();
        $cnt = $stmt->fetchColumn();

        if($cnt > 0){
            $error['menu_name']='same';
        }
        if(empty($error)){
            $_SESSION['menu_form'] = $menu_form;
            $_SESSION['menu_update'] = 'update_check';
            header('Location: update_check.php');
            $db = null;
            exit();
        }
    }
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
    <h1>こんだて編集</h1>
</div>

<div id="content">
    <p>次のフォームに必要事項をご記入ください。</p>
    <form action="" method="post" enctype="multipart/form-data">
        <dl>
            <dt>こんだて<span class="required">必須</span></dt>
            <dd>
                <?php if($result['menu_name']){ ?>
                    <input type="text" name="menu_name" size="35" maxlength="19" value="<?php echo h($row['menu_name']); ?>"/>
                <?php }else{?>
                    <input type="text" name="menu_name" size="35" maxlength="19" value="<?php echo h($menu_form['menu_name']); ?>"/>
                <?php } ?>
                <?php if(isset($error['mandatory']) && $error['mandatory'] ==='blind'){ ?>
                    <p class="error">* 料理名を入力してください</p>
                <?php }
                if(isset($error['menu_name']) && $error['menu_name'] === 'same'){ ?>
                    <p class="error">*すでに登録されています</p>
                <?php }
                if(isset($error['mandatory']) && $error['mandatory'] === 'menu_length'){ ?>
                    <p class="error">* 20文字以内にしてください</p>
                <?php } ?>
            </dd>
            <dt>日付を選んでください<span class="required">必須</span></dt>
            <dd>
            <?php if(isset($error['day']) && $error['day'] ==='blind'){ ?>
                    <p class="error">* 日付を選択してください</p>
            <?php } ?>
                <select name="cooking_year" size="2">
                    <option value="2022" selected>2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                </select><p>年</p>
                <select name="cooking_month" size="4">
                    <option value="01" selected>1</option>
                    <option value="02">2</option>
                    <option value="03">3</option>
                    <option value="04">4</option>
                    <option value="05">5</option>
                    <option value="06">6</option>
                    <option value="07">7</option>
                    <option value="08">8</option>
                    <option value="09">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select><p>月</p>
                <select name="cooking_day" size="4">
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select><p>日</p>
            </dd>
            <dd>
            <dt>メモ</dt>
            <?php if(isset($error['remarks_length']) && $error['remarks_length'] === 'remarks_length'){ ?>
                    <p class="error">* 600文字以内にしてください</p>
            <?php } ?>
            <textarea name="message" cols="50" rows="5" maxlength="600"></textarea>
            </dd>
        </dl>
        <div><input type="submit" value="入力内容を確認する"/></div>
        <br /><br />
            </form>
</div>
</div> 
</body>
</html>