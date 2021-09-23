<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ログイン</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>ログイン</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <form action="login_check.php" method="POST">
            メールアドレス: <input type="text" name="email"><br>
            パスワード: <input type="password" name="password"><br>

            <!--<input type="submit" value="登録">-->
            <button type="submit">ログイン</button>
        </form>
       
        
        <p><a href="index.php">トップページに戻る</a></p>
    </body>
</html>