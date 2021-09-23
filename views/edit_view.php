<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?= $user->name ?>さんの編集</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1><?= $user->name ?>さんの編集</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <form action="update.php" method="POST">
            名前: <input type="text" name="name" value="<?= $user->name ?>"><br>
            年齢: <input type="text" name="age" value="<?= $user->age ?>"><br>
            <!--<input type="submit" value="登録">-->
            <input type="hidden" name="id" value="<?= $user->id ?>">
            <button type="submit">更新</button>
        </form>
       
        
        <p><a href="show.php?id=<?= $user->id ?>"><?= $user->name ?>さんの詳細に戻る</a></p>
    </body>
</html>