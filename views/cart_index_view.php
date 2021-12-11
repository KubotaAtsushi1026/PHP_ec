<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>カート一覧</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>カート一覧</h1>
        
        <?php if($flash_message !== null): ?>
        <P class="message"><?= $flash_message ?></P>
        <?php endif; ?>
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
                <th>削除</th>
            </tr>
            <?php foreach($carts as $cart): ?>
            <tr>
                <td><?= $cart->id ?></td>
                <td><a href="item_show.php?id=<?= $cart->item_id ?>"><?= $cart->item_id ?></a></td>
                <td><?= $cart->name ?></td>
                <td><img src="upload/<?= $cart->image ?>"</td>
                <td><?= $cart->price ?>円</td>
                <td><?= $cart->stock ?>個</td>
                <td><?= $cart->number ?>個</td>
                <td><?= $cart->price * $cart->number ?>円</td>
                <td><?= $cart->created_at ?></td>
                <td>
                    <form action="cart_destroy.php" method="POST">
                        <input type="hidden" name="id" value="<?= $cart->id ?>">
                        <button>削除</button>
                    </form>
                </td>
            </tr>
            <?php $total += $cart->price * $cart->number; ?>
            <?php endforeach; ?>
        </table>
        
        <p>合計金額: <?= $total ?>円</p>
        
        <button>購入</button>
        
        <?php else: ?>
        <p>カート情報はありません</p>
        <?php endif; ?>
        
        <p><a href="user_top.php">ユーザートップへ</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>