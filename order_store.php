<?php
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
    $order = $_SESSION['order'];
    // var_dump($order);
    $_SESSION['order'] = null;
    
    $order->commit();
    $_SESSION['flash_message'] = '注文を確定しました';
    
    // header('Location: user_top.php');
    // exit;
    