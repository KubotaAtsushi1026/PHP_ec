<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品情報編集</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <!-- ビュー(V)-->
        <h1>商品情報編集</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <form action="item_update.php" method="POST" enctype="multipart/form-data">
            商品名: <input type="text" name="name" value="<?= $item->name ?>"><br>
            紹介文: <input type="text" name="content" value="<?= $item->content ?>"><br>
            価格: <input type="number" name="price" min="0" value="<?= $item->price ?>"><br>
            在庫数: <input type="number" name="stock" min="0" value="<?= $item->stock ?>"><br>
            画像: <input type="file" name="image"><br>
            <img src="upload/<?= $item->image ?>">
            <input type="hidden" name="id" value="<?= $item->id ?>">
            <!--<input type="submit" value="登録">-->
            <button type="submit">更新</button>
        </form>
       
        
        <p><a href="admin_top.php">管理者メニューに戻る</a></p>
    </body>
</html>