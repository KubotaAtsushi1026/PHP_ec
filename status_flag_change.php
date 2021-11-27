<?php
    // (C)
    require_once 'models/Item.php';
    $status_flag = $_POST['status_flag'];
    $id = $_POST['id'];
    // データベースの更新
    $item = Item::find($id);
    // status_flagが0の時$itemのstatus_flagを1に変える
    if($status_flag === "0"){
        $item->status_flag = 1;
    }else{
        $item->status_flag = 0;
    }
    $item->update_flag();
    
    header('Location: admin_top.php');
    exit;