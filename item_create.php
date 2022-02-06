<?php
    // (C)
    require_once 'login_filter.php';

    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;

    // ビューの表示
    include_once 'views/item_create_view.php'; 