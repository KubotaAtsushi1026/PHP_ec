<?php
    // (C)
    require_once 'models/User.php';
    require_once 'models/Order.php';
    session_start();
    
    $login_user = $_SESSION['login_user'];
    
    $orders = Order::all($login_user->id);
    // var_dump($orders);
    // foreach($orders as $order){
    //     var_dump($order->order_items());
    // }
    
    include_once 'views/order_index_view.php';