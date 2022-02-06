<?php
    // (C)
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    require_once 'models/User.php';
    require_once 'models/Item.php';
    session_start();

    // 入力された値を取得
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // データベースを見に行ってそんなユーザーいるのかチェック
    $user = User::login($email, $password);
    
    // そんなユーザーがいたならば
    if($user !== false){
        // その見つけたユーザーをセッションに保存
        $_SESSION['login_user'] = $user;
        // flash_messageをセット
        $_SESSION['flash_message'] = 'ログインしました';
        // 管理者ならば
        if($user->admin_flag == 1){
            // リダイレクト
            header('Location: admin_top.php');
            exit;
        }else
            header('Location: user_top.php');
            exit;
    }else{
        $errors = array();
        $errors[] = 'そのようなユーザーは登録されていません';
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: login.php');
        exit;
    }