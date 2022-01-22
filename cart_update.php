<?php
    // (C)
    require_once 'models/User.php';
    require_once 'models/Cart.php';
    session_start();
    // var_dump($_POST);
    $login_user = $_SESSION['login_user'];
    
    $cart_id = $_POST['cart_id'];
    $number = $_POST['number'];
    
    $cart = Cart::find($cart_id);
    $cart->number = $number;
    // var_dump($cart);
    $flash_message = $cart->save();
    
    $_SESSION['flash_message'] = $flash_message;
    
    header('Location: cart_index.php');
    exit;