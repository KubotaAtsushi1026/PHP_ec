<?php
    // (C)
    session_start();
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    
    // viewの表示
    include_once 'views/login_view.php';