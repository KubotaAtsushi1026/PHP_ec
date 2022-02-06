<?php
    // (C)
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    require_once 'models/Item.php';

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
    
    // ファイルが選択されていなければ
    if($_FILES['image']['size'] === 0){
        // $imageという変数に、元の画像ファイル名を保存
        $image = $item->image;
    }
    
    // 入力値にエラーがないかチェック
    $errors = $item->validate();

    if(count($errors) === 0){
        // 画像が選択されていたならば
        if($_FILES['image']['size'] !== 0){
            // 新しい画像名をランダムに生成
            $image = mt_rand(100, 10000) . $image;
            // $itemインスタンスのimage情報をランダムフィル名に変更
            $item->image = $image;

            // 画像のフルパスを設定
            $file = 'upload/' . $image;

            // uploadディレクトリにファイル保存
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
        }

        
        // データーベースを更新
        $flash_message = $item->save();
        
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