<?php
   require_once 'models/User.php';
   require_once 'models/Item.php';

   session_start();

   $users = User::all();
   $items = Item::all();

   $flash_message = $_SESSION['flash_message'];
   $_SESSION['flash_message'] = null;

   include_once 'views/index_view.php';