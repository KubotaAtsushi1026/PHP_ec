<?php
    // (C)
    require_once 'models/User.php';
    require_once 'models/Cart.php';
    require_once 'models/Order.php';
    session_start();
    
    $login_user = $_SESSION['login_user'];
    
    $zipcode = $_POST['zipcode'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    
    $order = new Order($login_user->id, $zipcode, $address, $tel);
    
    $errors = $order->validate();

    if(count($errors) === 0){
        $_SESSION['order'] = $order;
        $carts = Cart::all($login_user->id);
        include_once 'views/order_check_view.php';
    }else{
        $_SESSION['errors'] = $errors;
        $_SESSION['order'] = $order;
        header('Location: order_create.php');
        exit;
    }