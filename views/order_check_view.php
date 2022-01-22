<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>注文確認</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>注文確認</h1>
        
        <h2>発送情報</h2>
        <table>
            <tr>
                <th>お名前</th>
                <td><?= $login_user->name ?></td>
            </tr>
            <tr>
                <th>住所</th>
                <td><?= $order->zipcode ?></td>
            </tr>
            <tr>
                <th>住所</th>
                <td><?= $order->address ?></td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td><?= $order->tel ?></td>
            </tr>
        </table>
        <br>
        <br>
        
        <?php if(count($carts) !== 0): ?>
        <?php $total = 0; ?>
        <table>
            <tr>
                <th>カート番号</th>
                <th>商品番号</th>
                <th>商品名</th>
                <th>商品画像</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>個数</th>
                <th>小計</th>
                <th>カートに追加した日時</th>
            </tr>
            <?php foreach($carts as $cart): ?>
            <tr>
                <td><?= $cart->id ?></td>
                <td><?= $cart->item_id ?></td>
                <td><?= $cart->name ?></td>
                <td><img src="upload/<?= $cart->image ?>"</td>
                <td><?= $cart->price ?>円</td>
                <td><?= $cart->stock ?>個</td>
                <td><?= $cart->number ?>個</td>
                <td><?= $cart->price * $cart->number ?>円</td>
                <td><?= $cart->created_at ?></td>
            </tr>
            <?php $total += $cart->price * $cart->number; ?>
            <?php endforeach; ?>
        </table>
        
        <p>合計金額: <?= $total ?>円</p>
        
        <form action="order_store.php">
            <button type="submit">注文確定</button>
        </form>
        
        <?php else: ?>
        <p>カート情報はありません</p>
        <?php endif; ?>
        
        <p><a href="order_create.php">発送先入力へ戻る</a></p>

    </body>
</html>