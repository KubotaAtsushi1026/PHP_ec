<?php

    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    // (C)
    require_once 'models/User.php';
    require_once 'models/Item.php';

    session_start();
    $items = Item::all();
    // var_dump($items);
    $login_user = $_SESSION['login_user'];
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;
    
    
    
    //ビューの表示php
    include_once 'views/item_index_view.php';