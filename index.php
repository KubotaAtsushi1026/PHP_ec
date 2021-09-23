<?php
   require_once 'models/User.php';
   session_start();
   // $_SESSION['users'] = null;
   $users = User::all();
   $flash_message = $_SESSION['flash_message'];
   $_SESSION['flash_message'] = null;
   // var_dump($users);
   include_once 'views/index_view.php';