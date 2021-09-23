<?php
    // 外部ファイル読み込み
    require_once 'models/User.php';
    // セッション開始(すべてのファイルが使える情報の共有箱)
    session_start();
    // コントローラ(C)
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 入力された値から新しいユーザー作成
    $new_user = new User($name, $email, $password);
    // var_dump($new_user);
    
    // 入力チェック(validation)
    $errors = $new_user->validate();
    // var_dump($errors);
    
    // 名前もメールアドレスもパスワードも正しく入力されていれば
    if(count($errors) === 0){
        
        $flash_message = $new_user->save();
        
        $_SESSION['flash_message'] = $flash_message;
        
        // // リダイレクト（画面が変わる）
        header('Location: index.php');
        exit;
        
    }else{ // 入力エラーが1つでもあれば
        // エラー配列をセッションに保存
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: create.php');
        exit;
    }
    