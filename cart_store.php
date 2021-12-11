<?php
    // C(コントローラー)
    require_once 'models/User.php';
    require_once 'models/Item.php';
    require_once 'models/Cart.php';
    session_start();
    $login_user = $_SESSION['login_user'];
    $item_id = $_POST['item_id'];
    $number = $_POST['number'];
    
    // var_dump($_POST);
    // 飛んできた値から新しいカートインスタンス作成
    $cart = new Cart($login_user->id, $item_id, $number);
    // var_dump($cart);
    $errors = $cart->validate();
    // エラーがなければ
    if(count($errors) === 0){
        // データベースにカート情報を保存
        $flash_message = $cart->save();
        $_SESSION['flash_message'] = $flash_message;
        // リダイレクト
        header('Location: cart_index.php');
        exit;
    }else{
        $_SESSION['errors']  = $errors;
        // リダイレクト
        header('Location: user_top.php');
        exit;
    }
    