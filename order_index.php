<?php
    // (C)
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    require_once 'models/Order.php';

    $login_user = $_SESSION['login_user'];
    
    $orders = Order::all($login_user->id);
    
    include_once 'views/order_index_view.php';