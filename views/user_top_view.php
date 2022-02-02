<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>一般ユーザーメニュー</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <header>
            <h1>一般ユーザーメニュー</h1>
            <nav>
                <ul>
                    <li><a href="cart_index.php">カート一覧</a></li>
                    <li><a href="order_index.php">購入一覧</a></li>
                    <li><a href="logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </header>

        
        <img src="img/amazon2.png" alt="amazon2" class="amazon">
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
      
        <div class="flex">    
            <div class="box1">
                <?php foreach($items as $item): ?>
                <?php if($item->status_flag == 1): ?>
                <section>
                    <h3><?= $item->name ?></h2>
                    <p><a href="item_show.php?id=<?= $item->id ?>"><?= $item->id ?></a></p>
                    <p><?= $item->content ?></p>
                    <p><?= $item->price ?>円</p>
                    <p><img src="upload/<?= $item->image ?>"></p>
                    <p><?= $item->created_at ?></p>
                </section>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>    
            <div class="flexbox-end">
                <img src="img/side.png" alt="side" class="side">
                <img src="img/side2.png" alt="side2" class="side">
                <img src="img/side3.png" alt="side3" class="side">
            </div>

    </body>
</html>