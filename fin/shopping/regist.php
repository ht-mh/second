<?php
session_start();
require_once('../library.php');
require_once('../functions.php');


if(isset($_SESSION['id']) && isset($_SESSION['username'])){
  list($id,$username) = session_array($_SESSION['id'],$_SESSION['username']);
}else{
    header('Location: ../login.php');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])){
    $form = $_SESSION['form'];
}else{
    $form = [
        'category' =>'',
        'item_name' =>'',
        'shopping_year' =>'',
        'shopping_month' =>'',
        'shopping_day'=>'',
        'shopping_span'=>''
    ];
}

$error = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //連想配列を使って簡単にする
    $form['category'] = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $form['item_name'] = filter_input(INPUT_POST, 'item_name', FILTER_SANITIZE_STRING);
    $form['shopping_year'] = filter_input(INPUT_POST, 'shopping_year', FILTER_SANITIZE_STRING);
    $form['shopping_month'] = filter_input(INPUT_POST, 'shopping_month', FILTER_SANITIZE_STRING);
    $form['shopping_day'] = filter_input(INPUT_POST, 'shopping_day', FILTER_SANITIZE_STRING);
    $form['shopping_span'] = filter_input(INPUT_POST, 'shopping_span', FILTER_SANITIZE_STRING);
    
    if($form['category'] === '選択してください' || $form['item_name'] === '' ){
        $error['mandatory'] ='blind';
    }elseif(is_null($form['shopping_year']) || is_null($form['shopping_month']) || is_null($form['shopping_day'])){
        $error['day'] = 'blind';
    }else{
        $db = dbconnect();
        $sql = 'SELECT count(*) FROM shopping_list WHERE category=? and item_name=? and member_id=?';
        $stmt = $db->prepare($sql);
        if(!$stmt){
            die('エラーだぴょん');
        }
        $stmt->bindValue(1,$form['category']);
        $stmt->bindValue(2,$form['item_name']);
        $stmt->bindValue(3,$id,PDO::PARAM_INT);
        $stmt->execute();
        $cnt = $stmt->fetchColumn();

        if($cnt > 0){
            $error['item_name']='same';
        }
        if(empty($error)){
            $form_date = $form['shopping_year'].'-'.$form['shopping_month'].'-'.$form['shopping_day'];
            $timestamp = strtotime($form_date);
            $form['date'] = date('Y年m月d日', $timestamp);
            if($form['shopping_span'] === 'なし'){
                $form['shopping_span'] = null;
                $form['next_shoppingday'] = null;
            }else{
                $form['next_shoppingday'] = date('Y-m-d', strtotime($form['shopping_span'], $timestamp));
            }
            $_SESSION['form'] = $form;
            header('Location: check.php');
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
    <title>お買い物リスト作成</title>
    <link rel="stylesheet" href="../css/fin_style.css"/>
</head>
<body>
<div id="wrap">
    <div id="head">
        <h1>お買い物リスト作成</h1>
    </div>
<div id="content">
        <p>次のフォームに必要事項をご記入ください。</p>
        <form action="" method="post" enctype="multipart/form-data">
            <dl>
                <?php if(isset($error['mandatory']) && $error['mandatory'] === 'blind'){ ?>
                    <p class="error">* カテゴリーと商品名を記入してください</p>
                <?php } ?>
                <dt>カテゴリ<span class="required">必須</span></dt>
                <dd>
                    <select name="category" >
                        <option hidden>選択してください</option>
                        <optgroup label="ヘルスケア">
                            <option value="シャンプー">シャンプー</option>
                            <option value="リンス">リンス</option>
                            <option value="ボディソープ">ボディソープ</option>
                            <option value="洗顔">洗顔</option>
                        </optgroup>
                        <optgroup label="スキンケア">
                            <option value="化粧水">化粧水</option>
                            <option value="乳液">乳液</option>
                            <option value="オイル">オイル</option>
                            <option value="クリーム">クリーム</option>
                        </optgroup>
                        <optgroup label="その他">
                            <option value="その他">その他</option>
                        </optgroup>
                    </select>
                </dd>

                <dt>商品名<span class="required">必須</span></dt>
                <dd>
                <?php if(isset($error['item_name']) && $error['item_name'] === 'same'){ ?>
                    <p class="error">* すでに登録されています</p>
                <?php } ?>
                <input type="text" name="item_name" size="35" maxlength="20" value="<?php echo h($form['item_name']); ?>"/>  
                </dd>
                <?php if(isset($error['day']) && $error['day'] === 'blind'){ ?>
                    <p class="error">* 日付を選んでください</p>
                <?php } ?>
                <dt>購入日<span class="required">必須</span></dt>
                <dd>
                    <select name="shopping_year" size="2">
                        <option value="2022" selected>2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select><p>年</p>
                    <select name="shopping_month" size="4">
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
                    <select name="shopping_day" size="4">
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
                
                    <dt>次回購入日</dt>
                    <select name="shopping_span" size="4">
                        <option value="なし" selected>選択してください</option>
                        <option value="+1 week">1週間</option>
                        <option value="+2 week">2週間</option>
                        <option value="+3 week">3週間</option>
                        <option value="+1 month">1ヶ月</option>
                        <option value="+2 month">2ヶ月</option>
                        <option value="+3 month">3ヶ月</option>
                    </select><p>後</p>
                </dd>
            </dl>
            <div><input type="submit" value="入力内容を確認する"/></div>
            <br /><br />
        </form>
        
    </div>
</div>
</body>
</html>