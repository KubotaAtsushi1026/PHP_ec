<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>My Top</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- ビュー(V)-->
        <h1>会員制写真投稿サイト</h1>
        <?php if($flash_message !== null): ?>
        <P class="message"><?= $flash_message ?></P>
        <?php endif; ?>
        
        <h2><?= $login_user->name ?>さん、ようこそ！</h2>
      
        
        <p><a href="post_create.php">新規写真投稿</a></p>
        
        <!--全投稿データを表示-->
        <?php if(count($posts)=== 0): ?>
        <P>まだ投稿は1件もありません</P>
        <?php else: ?>
        <table>
            <tr>
                <th>投稿番号</th>
                <th>投稿者</th>
                <th>タイトル</th>
                <th>本文</th>
                <th>画像</th>
                <th>投稿日時</th>
            </tr>
            <?php foreach($posts as $post): ?>
            <tr>
                <td><a href="show.php?id=<?= $post->id ?>"><?= $post->id ?></a></td>
                <td><?= $post->name ?></td>
                <td><?= $post->title ?></td>
                <td><?= $post->content ?></td>
                <td><img src="upload/<?= $post->image ?>" alt="<?= $post->image ?>"></td>
                <td><?= $post->created_at ?></td>

            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        
        <p><a href="logout.php">ログアウト</a></p>

        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>