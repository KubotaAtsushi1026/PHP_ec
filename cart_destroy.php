<?php
    require_once 'models/Cart.php';

    $id = $_POST['id'];
    print $id;
    
    Cart::destroy($id);
    
    $_SESSION['flash_message'] = 'カートを削除しました';
    // リダイレクト
    header('Location: cart_index.php');
    exit;