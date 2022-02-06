<?php
    // (C)
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    require_once 'models/Item.php';

    $items = Item::all();
    $login_user = $_SESSION['login_user'];
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;

    //ビューの表示
    include_once 'views/admin_top_view.php';