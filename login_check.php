<?php
    // (C)
    require_once 'models/User.php';
    session_start();
    // var_dump($_POST);
    // 入力された値を取得
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // データベースを見に行ってそんなユーザーいるのかチェック
    $user = User::login($email, $password);
    
    // var_dump($user);
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
            // var_dump('管理者');
        }else
            header('Location: user_top.php');
            exit;
            // var_dump('一般');
    }else{
        $errors = array();
        $errors[] = 'そのようなユーザーは登録されていません';
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: login.php');
        exit;
    }