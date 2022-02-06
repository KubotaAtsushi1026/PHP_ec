<?php
    // (C)
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    require_once 'models/Item.php';
    require_once 'models/Cart.php';
    require_once 'models/Order.php';
    require_once 'models/OrderItem.php';

    // セッションからログインユーザー情報を取得
    $login_user = $_SESSION['login_user'];
    
    // そのユーザーの全カート情報を取得
    $carts = Cart::all($login_user->id);

    // セッションからオーダー情報を取得して、セッションから破棄
    $order = $_SESSION['order'];
    $_SESSION['order'] = null;
    
    // 購入処理実行
    $messages = $order->commit();
    $_SESSION['errors'] = $messages;
    
    // リダイレクト
    header('Location: user_top.php');
    exit;