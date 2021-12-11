<?php
    // モデル(M)
    require_once 'models/User.php';
    require_once 'models/Model.php';

    // カートの設計図を作成
    class Cart extends Model{
        // プロパティ
        public $id; // カート番号
        public $user_id; //登録者のユーザー番号
        public $item_id; // 商品番号
        public $number; // 個数
        public $created_at; // 公開日時
        public $updated_at; // 更新日時
        // コンストラクタ
        public function __construct($user_id="", $item_id="", $number=""){
            $this->user_id = $user_id;
            $this->item_id = $item_id;
            $this->number = $number;
        }
        
        // 入力チェックをするメソッド
        public function validate(){
            // 空のエラー配列作成
            $errors = array();
            // タイトルが入力されていなければ
            if($this->user_id === ''){
                $errors[] = 'ユーザー番号が入力されていません';
            }
            // 本文が入力されていなければ
            if($this->item_id === ''){
                $errors[] = '商品番号を入力してください';
            }
            if($this->number === ''){
                $errors[] = '個数を入力してください';
            }

            
            // 完成したエラー配列はいあげる
            return $errors;
        }
      
        // 全テーブル情報を取得するメソッド
        public static function all(){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo->query('SELECT user_id, item_id, number FROM carts JOIN users ON items.user_id = users.id ORDER BY items.id desc');
                // フェッチの結果を、Itemクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Cart');
                $carts = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                // Itemクラスのインスタンスの配列を返す
                return $carts;
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        // データを1件登録するメソッド
        public function save(){
            try {
                $pdo = self::get_connection();
                
                if($this->id === null){
                    $stmt = $pdo -> prepare("INSERT INTO carts (user_id, item_id, number) VALUES (:user_id, :item_id, :number)");
                    // バインド処理
                    $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT);
                    $stmt->bindParam(':number', $this->number, PDO::PARAM_INT);
                    // 実行
                    $stmt->execute();
                    
                }else{
                     $stmt = $pdo -> prepare("UPDATE items SET name=:name, content=:content, price=:price, stock=:stock, image=:image WHERE id=:id");
                     // バインド処理
                     $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
                     $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                     $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
                     $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
                     $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                     $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                     // 実行
                     $stmt->execute();
                }
                
                self::close_connection($pdo, $stmp);
                if($this->id === null){
                    return "新規カートに追加しました。";
                }else{
                    return $this->id. 'の商品情報を更新しました';
                }
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        public static function find($id){
                try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("select * from items where id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
                // フェッチの結果を、Itemクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Item');
                $item = $stmt->fetch();
                self::close_connection($pdo, $stmp);
                return $item;
                
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
        public function update_flag(){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("UPDATE items SET status_flag=:status_flag WHERE id=:id");
                // バインド処理
                $stmt->bindParam(':status_flag', $this->status_flag, PDO::PARAM_INT);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                // 実行
                $stmt->execute();
            
                
                self::close_connection($pdo, $stmp);
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
    }
