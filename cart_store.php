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
    // データベースにカート情報を保存
    $flash_message = $cart->save();