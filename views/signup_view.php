<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>新規会員登録</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>新規会員登録</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <form action="user_store.php" method="POST">
            名前: <input type="text" name="name"><br>
            メールアドレス: <input type="text" name="email"><br>
            パスワード: <input type="password" name="password"><br>
            権限: <input type="radio" name="admin_flag" value="0"　checked
            >一般 
            <input type="radio" name="admin_flag" value="1">管理者<br> 

            <!--<input type="submit" value="登録">-->
            <button type="submit">登録</button>
        </form>
       
        
        <p><a href="index.php">トップページに戻る</a></p>
    </body>
</html>