<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>カート一覧</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <header>
            <h1>カート一覧</h1>
            <nav>
                <ul>
                    <li><a href="user_top.php">一般ユーザーメニュー</li></p>
                    <li><a href="order_index.php">購入一覧</li></p>
                    <li><a href="contact.php">お問い合わせ</li></p>
                    <li><a href="logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </header>
        <br>
        
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
                <td>
                    <form action="cart_update.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?= $cart->id ?>">
                        <select name="number">
                            <?php for($i = 1; $i <= $cart->stock; $i++): ?>
                            <option value="<?= $i ?>" <?php if($i == $cart->number): ?>selected<?php endif; ?>><?= $i ?></option>
                            <?php endfor;?>
                        </select>個
                        <button type="submit">更新</button>
                    </form>
                </td>
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
        
        <form action="order_create.php">
            <button>購入</button>
        </form>
        
        <?php else: ?>
        <p>カート情報はありません</p>
        <?php endif; ?>
        
    </body>
</html>