<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>登録商品一覧</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>登録商品一覧</h1>

        <?php foreach($items as $item): ?>
        <?php if($item->status_flag === "0"): ?>
        <ul class="gray">
        <?php else: ?>
        <ul>
        <?php endif; ?>
            <li><a href="item_edit.php?id=<?= $item->id ?>"><?= $item->id ?></a></li>
            <li><?= $item->name ?></li>
            <li><?= $item->content ?></li>
            <li><?= $item->price ?>円</li>
            <li><?= $item->stock ?>個</li>
            <li><img src="upload/<?= $item->image ?>"></li>
            <li><?= $item->created_at ?></li>
            <li>
                <form action="status_flag_change.php" method="POST">
                    <input type="hidden" name="status_flag" value="<?= $item->status_flag ?>">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <?php if($item->status_flag === "0"): ?>
                    <button type="submit">公開にする</button>
                    <?php else: ?>
                    <button type="submit">非公開にする</button>
                    <?php endif; ?>
                </form>
            </li>
        </ul>
       
        <?php endforeach; ?>
        
        <p><a href="logout.php">ログアウト</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>