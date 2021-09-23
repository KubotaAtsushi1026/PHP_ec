<?php
    require_once 'models/User.php';
    require_once 'models/Favorite.php';
    session_start();
    $post_id = $_POST['post_id'];
    $login_user = $_SESSION['login_user'];
    // print $post_id;
    // print $post_id；
    $favorite = new Favorite($login_user->id, $post_id);
    // var_dump($favorite);
    
    $flash_message = $favorite->save();
    
    $_SESSION['flash_message'] = $flash_message;
    
    header('Location: show.php?id=' . $post_id);
    exit;