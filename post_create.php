<?php
// (C)
require_once 'login_filter.php';
session_start();

$errors = $_SESSION['errors'];
$_SESSION['errors'] = null;

// ビューの表示
include_once 'views/post_create_view.php';