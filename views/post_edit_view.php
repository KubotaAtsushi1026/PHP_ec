<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?= $post->id ?>の投稿の編集</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1><?= $post->id ?>の投稿の編集</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <form action="post_update.php" method="POST" enctype="multipart/form-data">
            タイトル: <input type="text" name="title" value="<?= $post->title ?>"><br>
            本文: <input type="text" name="content" value="<?= $post->content ?>"><br>
            画像: <input type="file" name="image"><br>
            <input type="hidden" name="id" value="<?= $post->id ?>">
            <!--<input type="submit" value="登録">-->
            <button type="submit">更新</button>
        </form>
       
        
        <p><a href="top.php">My Topに戻る</a></p>
    </body>
</html>