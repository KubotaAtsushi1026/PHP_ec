<?php

    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    // (C)
    require_once 'models/User.php';
    require_once 'models/Post.php';
    session_start();
    $login_user = $_SESSION['login_user'];
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;
    
    // Postモデルを使って、全投稿を取得
    $posts = Post::all();
    
    // var_dump($posts);
    
    //ビューの表示
    include_once 'views/top_view.php';