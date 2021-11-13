<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>管理者メニュー</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>管理者メニュー</h1>
        <?php if($flash_message !== null): ?>
        <P class="message"><?= $flash_message ?></P>
        <?php endif; ?>
        
        <h2><?= $login_user->name ?>さん、ようこそ！</h2>
      
        
        <p><a href="item_create.php">新規商品登録</a></p>
        
        <ul>
            <li><?= $item->id ?></li>
            <li><?= $item->name ?></li>
            <li><?= $item->content ?></li>
            <li><?= $item->price ?></li>
            <li><?= $item->stock ?></li>
            <li><?= $item->status_flag ?></li>
            <li><img src="upload/<?= $item->image ?>"></li>
            <li><?= $item->created_at ?></li>
            <li><?= $item->updated_at ?></li>
        </ul>
        
        <p><a href="logout.php">ログアウト</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>