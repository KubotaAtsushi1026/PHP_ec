<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Amazon</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <header>
            <h1>Amazon</h1>
            <nav>
                <ul>
                    <li><a href="signup.php">新規ユーザー会員登録</a></li>
                    <li><a href="login.php">ログイン</a></li>
                </ul>
            </nav>
        </header>
        <img src="img/amazon.png" alt="amazon" class="amazon">
        <?php if($flash_message !== null): ?>
        <P class="message"><?= $flash_message ?></P>
        <?php endif; ?>
</html>