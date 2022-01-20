<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>注文履歴</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>注文履歴</h1>

        <?php if(count($orders) !== 0): ?>
        
        <?php foreach($orders as $order): ?>
        <?php $total = 0; ?>
        <p>発注番号: <?= $order->id ?></p>
        <p>発注日時: <?= $order->created_at ?></p>
        <table>
            <tr>
                <th>発注番号</th>
                <th>商品番号</th>
                <th>商品名</th>
                <th>商品画像</th>
                <th>価格</th>
                <th>個数</th>
                <th>小計</th>
                <th>注文日時</th>
            </tr>
                <?php foreach($order->order_items() as $order_item): ?>
                <tr>
                    <td><?= $order_item->order_id ?></td>
                    <td><a href="item_show.php?id=<?= $order_item->item_id ?>"><?= $order_item->item_id ?></a></td>
                    <td><?= $order_item->name ?></td>
                    <td><img src="upload/<?= $order_item->image ?>"></td>
                    <td><?= $order_item->price ?>円</td>
                    <td><?= $order_item->number ?>個</td>
                    <td><?= $order_item->subtotal ?>円</td>
                    <td><?= $order_item->created_at ?></td>
                </tr>
                <?php $total += $order_item->subtotal; ?>
                <?php endforeach; ?>
        </table>
        <p>合計金額: <?= $total ?>円</p>
        <?php $total = 0 ?>
        <hr>
        <?php endforeach; ?>
        
    
        <?php else: ?>
        <p>注文履歴はありません</p>
        <?php endif; ?>
        
        <p><a href="user_top.php">ユーザートップへ</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>