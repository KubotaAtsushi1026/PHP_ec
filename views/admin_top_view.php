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
        <img src="img/amazon2.png" alt="amazon2" class="amazon">
        <?php if($flash_message !== null): ?>
        <P class="message"><?= $flash_message ?></P>
        <?php endif; ?>
        
        <h2><?= $login_user->name ?>さん、ようこそ！</h2>
      
        
        <p><a href="item_create.php">新規商品登録</a></p>
        <p><a href="item_index.php">登録商品一覧</a></p>
        <?php foreach($items as $item): ?>
        <?php if($item->status_flag === "0"): ?>
        <ul class="gray">
        <?php else: ?>
        <div class="flex">    
            <div class="box1">
                
                <?php endif; ?>
                <section>
                    <h3><?= $item->name ?></h2>
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
            </div>
        <?php endforeach; ?>
        
            <div class="flexbox-end">
                <img src="img/side.png" alt="side" class="side">
                <img src="img/side2.png" alt="side2" class="side">
                <img src="img/side3.png" alt="side3" class="side">
            </div>
        </div>
            
       
        <p><a href="logout.php">ログアウト</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>