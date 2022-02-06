<?php
    // モデル(M)
    require_once 'models/User.php';

    // 商品の設計図を作成
    class Item extends Model{
        // プロパティ
        public $id; // 商品番号
        public $user_id; //登録者のユーザー番号
        public $name; // 商品名
        public $content; // 紹介文
        public $price; // 価格
        public $stock; // 在庫数
        public $image; // 商品画像
        public $status_flag;// 商品画像
        public $created_at; // 公開日時
        public $updated_at; // 更新日時
        // コンストラクタ
        public function __construct($user_id="", $name="", $content="", $price="", $stock="", $image="", $status_flag=""){
            $this->user_id = $user_id;
            $this->name = $name;
            $this->content = $content;
            $this->price = $price;
            $this->stock = $stock;
            $this->image = $image;
            $this->status_flag = $status_flag;
        }
        
        // 入力チェックをするメソッド
        public function validate(){
            // 空のエラー配列作成
            $errors = array();
            // タイトルが入力されていなければ
            if($this->name === ''){
                $errors[] = '商品名が入力されていません';
            }
            // 本文が入力されていなければ
            if($this->content === ''){
                $errors[] = '紹介文を入力してください';
            }
            if($this->price === ''){
                $errors[] = '価格を入力してください';
            }
            if($this->stock === ''){
                $errors[] = '在庫数を入力してください';
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
                $stmt = $pdo->query('SELECT items.id, items.name, items.content, items.price, items.stock, items.image, items.created_at, items.status_flag FROM items JOIN users ON items.user_id = users.id ORDER BY items.id desc');
                // フェッチの結果を、Itemクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Item');
                $items = $stmt->fetchAll();
                self::close_connection($pdo, $stmt);
                // Itemクラスのインスタンスの配列を返す
                return $items;
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // データを1件登録するメソッド
        public function save(){
            try {
                $pdo = self::get_connection();
                
                if($this->id === null){
                    $stmt = $pdo -> prepare("INSERT INTO items (user_id, name, content, price, stock, image, status_flag) VALUES (:user_id, :name, :content, :price, :stock, :image, :status_flag)");
                    // バインド処理
                    $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
                    $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                    $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
                    $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
                    $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                    $stmt->bindParam(':status_flag', $this->status_flag, PDO::PARAM_INT);
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
                
                self::close_connection($pdo, $stmt);
                if($this->id === null){
                    return "新規商品投稿が成功しました。";
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
                self::close_connection($pdo, $stmt);
                return $item;
                
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
            
                self::close_connection($pdo, $stmt);
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
    }
