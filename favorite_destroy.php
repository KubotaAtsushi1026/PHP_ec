<?php
    require_once 'models/User.php';
    require_once 'models/Favorite.php';
    session_start();
    $post_id = $_POST['post_id'];
    $login_user = $_SESSION['login_user'];
    
    Favorite::destroy($login_user->id, $post_id);
    
    $_SESSION['flash_message'] = 'いいねを解除しました';
    
    header('Location: show.php?id=' . $post_id);
    exit;