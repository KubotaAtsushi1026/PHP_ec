<?php
    // モデル(M)
    require_once 'models/Comment.php';
    require_once 'models/User.php';
    require_once 'models/Model.php';

    // 投稿の設計図を作成
    class Post extends Item{
        // プロパティ
        public $id; // 投稿番号
        public $user_id; //投稿者のユーザー番号
        public $name; // タイトル
        public $content; // 本文
        public $price;
        public $stock;
        public $image;
        public $status_flag;// 画像ファイル名
        public $created_at; // 投稿日時
        public $updated_at;
        // コンストラクタ
        public function __construct($user_id="", $title="", $content="", $price="", $stock="", $image=""){
            $this->user_id = $user_id;
            $this->title = $name;
            $this->content = $content;
            $this->price = $price;
            $this->stock = $stock;
            $this->image = $image;
        }
        
        // 入力チェックをするメソッド
        public function validate(){
            // 空のエラー配列作成
            $errors = array();
            // タイトルが入力されていなければ
            if($this->title === ''){
                $errors[] = 'タイトルが入力されていません';
            }
            // 本文が入力されていなければ
            if($this->content === ''){
                $errors[] = '本文を入力してください';
            }
            
            // 画像が選択されていなければ
            if($this->image === ''){
                $errors[] = '画像を選択してください';
            }
            
            // 完成したエラー配列はいあげる
            return $errors;
        }
      
        // 全テーブル情報を取得するメソッド
        public static function all(){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo->query('SELECT posts.id, users.name, posts.title, posts.content, posts.image, posts.created_at FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id desc');
                // フェッチの結果を、Postクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Post');
                $posts = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                // Postクラスのインスタンスの配列を返す
                return $posts;
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        // データを1件登録するメソッド
        public function save(){
            try {
                $pdo = self::get_connection();
                
                if($this->id === null){
                $stmt = $pdo -> prepare("INSERT INTO posts (user_id, title, content, image) VALUES (:user_id, :title, :content, :image)");
                // バインド処理
                $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
                $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);

                // 実行
                $stmt->execute();
                    
                }else{
                     $stmt = $pdo -> prepare("UPDATE posts SET title=:title, content=:content, image=:image WHERE id=:id");
                     // バインド処理
                     $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
                     $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                     $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                     $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                     // 実行
                     $stmt->execute();
                }
                
                self::close_connection($pdo, $stmp);
                if($this->id === null){
                    return "新規写真投稿が成功しました。";
                }else{
                    return $this->id. 'の投稿情報を更新しました';
                }
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        public static function find($id){
                try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("SELECT posts.user_id, posts.id, posts.title, posts.content, posts.image, posts.created_at, users.name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
                // フェッチの結果を、Postクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Post');
                $post = $stmt->fetch();
                self::close_connection($pdo, $stmp);
                return $post;
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        public static function destroy($id){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("DELETE FROM posts WHERE id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
               
                } catch (PDOException $e) {
                    return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // メールアドレスとパスワードを与えられてユーザーを取得
        public static function login($email, $password){
             try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("SELECT * FROM users WHERE email=:email AND password=:password");
                // バインド処理
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                 $stmt->bindParam(':password', $password, PDO::PARAM_STR);                // 実行

                // 実行
                $stmt->execute();
                // フェッチの結果を、Userクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
                $user = $stmt->fetch();
                self::close_connection($pdo, $stmp);
                return $user;
                
                } catch (PDOException $e) {
                    return 'PDO exception: ' . $e->getMessage();
                }
        }
        // その投稿に紐づいたコメント一覧を取得
        public function comments(){
             try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("select comments.id, users.name, comments.content, comments.created_at from comments join users on comments.user_id = users.id where post_id=:post_id");
                // バインド処理
                $stmt->bindParam(':post_id', $this->id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
                // フェッチの結果を、Commentクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Comment');
                $comments = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                return $comments;
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        public function favorites(){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("select users.id, users.name from favorites JOIN users ON favorites.user_id = users.id WHERE favorites.post_id=:post_id");
                // バインド処理
                $stmt->bindParam(':post_id', $this->id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
                // フェッチの結果を、Userクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
                $favorites_users = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                return $favorites_users;
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
    }
