<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>管理者メニュー</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <header>
            <h1>管理者メニュー</h1>
            <nav>
                <ul>
                    <li><a href="item_create.php">新規商品登録</a></li>
                    <li><a href="logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </header>
        <img src="img/amazon2.png" alt="amazon2" class="amazon">

        <h2><?= $login_user->name ?>さん、ようこそ！</h2>
      
        <div class="flex">    
            <div class="box1">
                <?php foreach($items as $item): ?>
                <?php if($item->status_flag == 0): ?>
                <section class="gray">
                <?php else: ?>
                <section class="white">
                <?php endif; ?>    
                    <h3><?= $item->name ?></h3>
                    <p><a href="item_edit.php?id=<?= $item->id ?>"><?= $item->id ?></a></p>
                    <p><?= $item->content ?></p>
                    <p><?= $item->price ?>円</p>
                    <p><?= $item->stock ?>個</p>
                    <p><img src="upload/<?= $item->image ?>"></p>
                    <p><?= $item->created_at ?></p>
                    <p>
                        <form action="status_flag_change.php" method="POST">
                            <input type="hidden" name="status_flag" value="<?= $item->status_flag ?>">
                            <input type="hidden" name="id" value="<?= $item->id ?>">
                            <?php if($item->status_flag === "0"): ?>
                            <button type="submit">公開にする</button>
                            <?php else: ?>
                            <button type="submit">非公開にする</button>
                            <?php endif; ?>
                        </form>
                    </p>
                </section>
                <?php endforeach; ?>
            </div>    

            <div class="flexbox-end">
                <img src="img/side.png" alt="side" class="side">
                <img src="img/side2.png" alt="side2" class="side">
                <img src="img/side3.png" alt="side3" class="side">
            </div>
        </div>
    </body>
</html>