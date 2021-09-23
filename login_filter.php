<?php
 // filter
 require_once 'models/User.php';
 // セッション開始
 session_start();
 // ログインしているユーザー情報をセッションから取得
 $login_user = $_SESSION['login_user'];
 
 // そんな情報が保存されていなければ
 if($login_user === null){
     $errors = array();
     $errors[] = '不正アクセスです。ログインしてください';
     $_SESSION['errors'] = $errors;
     // リダイレクト
     header('Location: login.php');
     exit;
 }