<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>新規商品登録</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>新規商品登録</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <form action="item_store.php" method="POST" enctype="multipart/form-data">
            商品名: <input type="text" name="name"><br>
            紹介文: <input type="text" name="content"><br>
            価格: <input type="number" name="price" min="0"><br>
            在庫数: <input type="number" name="stock" min="0"><br>
            画像: <input type="file" name="image"><br>
            公開状態: <input type="radio" name="status_flag" value="1" checked> 公開
            <input type="radio" name="status_flag" value="2"> 非公開<br>
            <!--<input type="submit" value="登録">-->
            <button type="submit">登録</button>
        </form>
       
        
        <p><a href="admin_top.php">管理者メニューに戻る</a></p>
    </body>
</html>