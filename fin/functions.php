<?php
require_once('library.php');


function shop_id($shop_id,$member_id){
    $db = dbconnect();
    $sql = 'SELECT count(*) FROM shopping_list WHERE id=? and member_id=?';
    $stmt = $db->prepare($sql);
    if(!$stmt){
        die('エラーだぴょん');
    }
    $stmt->bindValue(1,$shop_id,PDO::PARAM_INT);
    $stmt->bindValue(2,$member_id,PDO::PARAM_INT);
    $stmt->execute();
    $cnt = $stmt->fetchColumn();
    if($cnt > 0){
        $result = 'true';
    }else{
        $result = 'false';
    }
    return $result;
}

function result_count($value,$id,$member_id){
    $db = dbconnect();
    if($value === 'menu'){
        $sql = 'SELECT count(*) FROM menu WHERE menu_id=? and member_id=?';
    }elseif($value === 'shop'){
        $sql = 'SELECT count(*) FROM shopping_list WHERE id=? and member_id=?';
    }
    $stmt = $db->prepare($sql);
    if(!$stmt){
        die('エラーだぴょん');
    }
    $stmt->bindValue(1,$id,PDO::PARAM_INT);
    $stmt->bindValue(2,$member_id,PDO::PARAM_INT);
    $stmt->execute();
    $cnt = $stmt->fetchColumn();
    if($cnt > 0){
        $result = 'true';
    }else{
        $result = 'false';
    }
    return $result;
}

function db_remove($value,$id,$member_id){
    $db = dbconnect();
    if($value === 'menu'){
        $sql = 'delete from menu where menu_id=? and member_id=? limit 1';
    }elseif($value === 'shop'){
        $sql = 'delete from shopping_list where id=? and member_id=? limit 1';
    }
    $stmt = $db->prepare($sql);
    if(!$stmt){
        die('えらーだぴょん');
    }
    $stmt->bindValue(1,$id,PDO::PARAM_INT);
    $stmt->bindValue(2,$member_id,PDO::PARAM_INT);
    $success = $stmt->execute();
    return $success;
}

?>