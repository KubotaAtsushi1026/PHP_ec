<?php
    // // (C)
    // var_dump($_POST);
    // var_dump($_FILES);
    require_once 'models/User.php';
    require_once 'models/Post.php';
    session_start();


    // 入力した情報を取得
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    
    $login_user = $_SESSION['login_user'];
    
    // ファイルが選択されていなければ
    if($_FILES['image']['size'] === 0){
        $image = '';
    }
    
    $post = new Post($login_user->id, $title, $content, $image);
    // var_dump($post);
    // 入力チェック
    $errors = $post->validate();
    // var_dump($errors);
    
    // 入力エラーが一つもなければ
    if(count($errors) === 0){
        
        $image = mt_rand(100, 10000) . $image;
        $post->image = $image;
        
        // データーベースに保存
        $flash_message = $post->save();
        // 画像のフルパスを設定
        $file = 'upload/' . $image;
    
        // uploadディレクトリにファイル保存
        move_uploaded_file($_FILES['image']['tmp_name'], $file);
        
        $_SESSION['flash_message'] = $flash_message;
        // リダイレクト
        header('Location: top.php');
        exit;
    }else{ // 入力エラーが一つでもあれば
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: post_create.php');
        exit;
    }