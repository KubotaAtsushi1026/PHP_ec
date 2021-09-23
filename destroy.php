<?php
    // コントローラー(C)
    require_once 'models/User.php';
    session_start();
   
    $id = $_POST['id'];
    $user = User::find($id);
    
    $user->destroy();
    
    // メッセージをセッションに保存
    $_SESSION['flash_message'] = $user->name . 'さんを削除しました';
    
    // リダイレクト
    header('Location: index.php');
    exit;
    