<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>一般ユーザーメニュー</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>一般ユーザーメニュー</h1>
        <?php if($flash_message !== null): ?>
        <P class="message"><?= $flash_message ?></P>
        <?php endif; ?>
        
        <h2><?= $login_user->name ?>さん、ようこそ！</h2>
      
        
        <p><a href="item_create.php">新規商品登録</a></p>
        <?php foreach($items as $item): ?>
        <ul>
            <li><?= $item->id ?></li>
            <li><?= $item->name ?></li>
            <li><?= $item->content ?></li>
            <li><?= $item->price ?>円</li>
            <li><?= $item->stock ?>個</li>
            <li><img src="upload/<?= $item->image ?>"></li>
            <li><?= $item->created_at ?></li>
            <li><?= $item->status_flag ?></li>
        </ul>
        <?php endforeach; ?>
        
        <p><a href="logout.php">ログアウト</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>