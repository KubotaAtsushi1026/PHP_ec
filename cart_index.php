<?php
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    // (C)
    require_once 'models/User.php';
    require_once 'models/Item.php';
    require_once 'models/Cart.php';
    require_once 'models/Order.php';
    require_once 'models/OrderItem.php';

    session_start();
    $login_user = $_SESSION['login_user'];
    $carts = Cart::all($login_user->id);
    // var_dump($carts);
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;
    
    
    
    //ビューの表示
    include_once 'views/cart_index_view.php';