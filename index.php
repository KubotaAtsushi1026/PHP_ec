<?php
   session_start();
   
   $flash_message = $_SESSION['flash_message'];
   $_SESSION['flash_message'] = null;

   include_once 'views/index_view.php';