<?php
    require_once 'models/User.php';
    $id = $_GET['id'];
    // print $id;
    $user = User::find($id);
    // var_dump($user);
    // $posts = $user->post();
    $posts = array();
    include_once 'views/users_show_view.php';