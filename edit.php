<?php 
    require_once 'models/User.php';
    session_start();
    $id = $_GET['id'];
    $User::find($id);
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    include_once 'views/edit_view.php';