<?php
    // C(コントローラー)
    require_once 'models/Item.php';
    require_once 'models/Cart.php';
    $login_user = $_SESSION['login_user'];
    $item_id = $_POST['item_id'];
    $number = $_POST['number'];
    
    // その商品のカート情報を取得
    $cart = Cart::find_my_cart($login_user->id, $item_id);
    
    // その商品がカートに存在しなければ
    if($cart === false){
        
        // 飛んできた値から新しいカートインスタンス作成
        $cart = new Cart($login_user->id, $item_id, $number);
        
    }else{ // カートにすでにその商品があれば
        
        // そのカートインスタンスの個数を増やす
        $cart->number += $number;
    }
    
    // 入力エラーチェック
    $errors = $cart->validate();
    
    // エラーがなければ
    if(count($errors) === 0){
        // データベースにカート情報を保存、もしくは更新
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