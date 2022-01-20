<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>発送先入力</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>発送先入力</h1>
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <form action="order_check.php" method="POST">
            郵便番号: <input type="text" name="zipcode" placeholder="xxx-xxxx" value="<?= $order->zipcode ?>"><br>
            住所: <input type="text" name="address" value="<?= $order->address ?>"><br>
            電話番号: <input type="text" name="tel" placeholder="xxx-xxxx-xxxx" value="<?= $order->tel ?>"><br>
            <button type="submit">次へ</button>
        </form>
        <p><a href="cart_index.php">カート一覧に戻る</a></p>
    </body>
</html>