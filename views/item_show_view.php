<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品情報詳細</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <!-- ビュー(V)-->
        <h1>商品情報詳細</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <ul>
            <li><?= $item->id ?></li>
            <li><?= $item->name ?></li>
            <li><?= $item->content ?></li>
            <li><?= $item->price ?>円</li>
            <li><img src="upload/<?= $item->image ?>"></li>
            <li><?= $item->created_at ?></li>
        </ul>
        <?php if($item->stock >= 1): ?>
        <form action="cart_store.php" method="POST">
            <select name="number">
                <?php for($i = 1;$i <= $item->stock; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>        
            </select>
            <button type="submit">カートに追加</button>
            <input type="hidden" name="item_id" value="<?= $item->id ?>">
        </form>
        <?php else: ?>
        <p>現在在庫切れです</p>
        <?php endif; ?>
        <p><a href="user_top.php">ユーザーメニューに戻る</a></p>
    </body>
</html>