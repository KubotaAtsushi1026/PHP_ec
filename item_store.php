<?php
    // (C)
    
    require_once 'models/User.php';
    require_once 'models/Item.php';
    session_start();


    // 入力した情報を取得
    $name = $_POST['name'];
    $content = $_POST['content'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];
    $status_flag = $_POST['status_flag'];
    $login_user = $_SESSION['login_user'];
    
    // ファイルが選択されていなければ
    if($_FILES['image']['size'] === 0){
        $image = '';
    }
    
    $item = new Item($login_user->id, $name, $content, $price, $stock, $image, $status_flag);
    // var_dump($item);
    // // 入力チェック
    $errors = $item->validate();
    // // var_dump($errors);
    
    // // 入力エラーが一つもなければ
    if(count($errors) === 0){
        
        $image = mt_rand(100, 10000) . $image;
        $item->image = $image;
        
        // データーベースに保存
        $flash_message = $item->save();
        // 画像のフルパスを設定
        $file = 'upload/' . $image;
    
        // uploadディレクトリにファイル保存
        move_uploaded_file($_FILES['image']['tmp_name'], $file);
        
        $_SESSION['flash_message'] = $flash_message;
        // リダイレクト
        header('Location: admin_top.php');
        exit;
    }else{ // 入力エラーが一つでもあれば
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: item_create.php');
        exit;
    }