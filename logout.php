<?php
    // (C)
    // セッション開始
    session_start();
    // セッションに保存されたユーザー情報を破棄
    $_SESSION['login_user'] = null;
    // flash_messageのセット
    $_SESSION['flash_message'] = 'ログアウトしました';
    
    // リダイレクト
    header('Location: index.php');
    exit;