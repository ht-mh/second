<?php
session_start();
require('../library.php');

if(isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])){
    $form = $_SESSION['form'];
}else{
    $form = [
        'username' =>'',
        'password' =>''
    ];
}

$error = [];

//フォームの内容をチェック
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $form['username'] = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
    if(strlen($form['username']) > 4){
        $error['username'] ='length';
    }elseif($form['username'] === '' && $form['password'] === ''){
        $error['username'] = 'blank';
    }elseif(!($form['username'] === '' && $form['password'] === '') && ($form['username'] === $form['password'])){
        $error['username'] = 'same';
    }else {
        $db = dbconnect();
        $sql = 'SELECT count(*) FROM members WHERE username=?';        
        $stmt = $db->prepare($sql);
        if(!$stmt){
            die($db->error);
        }
        $stmt->bindValue(1,$form['username']);
        $success = $stmt->execute();
        if(!$success){
            die($db->error);
        }

        $cnt = $stmt->fetchColumn();

        if($cnt > 0){
            $error['username']='deplicate';
        }
        if($form['password'] === ''){
            $error['password'] = 'blank';
        } else if(strlen($form['password']) > 4){
            $error['password'] ='length';
        }
    }
    
    if(empty($error)){
        $_SESSION['form'] = $form;
        $_SESSION['join'] = 'join';
        header('Location: check.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録</title>

    <link rel="stylesheet" href="../css/fin_style.css"/>
</head>

<body>
<div id="wrap">
    <div id="head">
        <h1>会員登録</h1>
    </div>

    <div id="content">
        <p>次のフォームに必要事項をご記入ください。</p>
        <form action="" method="post" enctype="multipart/form-data">
            <dl>
                <dt>ニックネーム<span class="required">必須</span></dt>
                <dd>
                    <input type="text" name="username" size="35" maxlength="255" value="<?php echo h($form['username']); ?>"/>
                    <?php if(isset($error['username']) && $error['username'] === 'same'){ ?>
                        <p class="error">* ユーザー名とパスワードが同じです</p>
                    <?php }?>
                    <?php if(isset($error['username']) && $error['username'] === 'blank'){ ?>
                        <p class="error">* ニックネームを入力してください</p>
                    <?php }?>
                    <?php if(isset($error['username']) && $error['username'] === 'length'){ ?>
                        <p class="error">* ユーザ名は4文字以下で入力してください</p>
                        <?php } ?>
                    <?php if(isset($error['username']) && $error['username'] === 'deplicate'){ ?>
                        <p class="error">*すでに登録されています</p>
                    <?php } ?>
                    </dd>
                    <dt>パスワード<span class="required">必須</span></dt>
                <dd>
                    <input type="password" name="password" size="10" maxlength="20" value="<?php echo h($form['password']); ?>"/>
                    <?php if(isset($error['password']) && $error['password'] === 'blank'){ ?>
                        <p class="error">* パスワードを入力してください</p>
                        <?php } ?>
                        <?php if(isset($error['password']) && $error['password'] === 'length'){ ?>
                        <p class="error">* パスワードは4文字以下で入力してください</p>
                        <?php } ?>
                    
                </dd>
            </dl>
            <div><input type="submit" value="入力内容を確認する"/></div>
            <br /><br />
        </form>
        <p>すでにアカウントをお持ちのかたは<a href="../login.php">こちら</a></p>
    </div>
</div>
</body>

</html>