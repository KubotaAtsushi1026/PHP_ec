<?php
    // (C)
    require_once 'login_filter.php';
    require_once 'models/Post.php';
    session_start();
    $id = $_GET['id'];
    
    $post = Post::find($id);
    // var_dump($post);
    
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    
    // ビューの表示
    include_once 'views/post_edit_view.php';