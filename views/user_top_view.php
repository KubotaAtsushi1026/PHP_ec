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
        
        <?php if($errors !== null): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li class="error"><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        
        <h2><?= $login_user->name ?>さん、ようこそ！</h2>
      
        <p><a href="cart_index.php">カート一覧</a></a></p>
        <p><a href="purchase_index.php">購入一覧</a></p>
        <?php foreach($items as $item): ?>
        <?php if($item->status_flag == 1): ?>
        <ul>
            <li><a href="item_show.php?id=<?= $item->id ?>"><?= $item->id ?></a></li>
            <li><?= $item->name ?></li>
            <li><?= $item->content ?></li>
            <li><?= $item->price ?>円</li>
            <li><img src="upload/<?= $item->image ?>"></li>
            <li><?= $item->created_at ?></li>
        </ul>
        <?php endif; ?>
        <?php endforeach; ?>
        
        <p><a href="logout.php">ログアウト</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>