<?php
    require_once 'models/Item.php';
    // var_dump($_POST);
    session_start();
    $id = $_POST['id'];
    $name = $_POST['name'];
    $content = $_POST['content'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];
    
    $item = Item::find($id);
    $item->name = $name;
    $item->content = $content;
    $item->price = $price;
    $item->stock = $stock;
    
    if($_FILES['image']['size'] === 0){
        $image = $item->image;
    }
    $item->image = $image;
    // var_dump($item);
    
    $errors = $item->validate();
    // var_dump($errors);
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
    }else{
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: item_edit.php?id=' . $id);
        exit;
    }