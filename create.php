<?php
    // コントローラー(C)
    // セッション開始
    session_start();
    
    // セッションからエラー配列を取得
    $errors = $_SESSION['errors'];
    // セッションからエラー配列を破棄
    $_SESSION['errors'] = null;
    
    // HTMLの表示
    include_once 'views/create_view.php';