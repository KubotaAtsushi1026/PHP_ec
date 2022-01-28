<?php
    // モデル(M)
    require_once 'models/User.php';
    require_once 'models/Model.php';

    // 注文商品詳細の設計図を作成
    class OrderItem extends Model{
        // プロパティ
        public $id; // 注文商品詳細番号
        public $order_id; //注文番号
        public $item_id; // 商品番号
        public $number; // 個数
        public $price; // 決定価格
        public $created_at; // 注文日時

        // コンストラクタ
        public function __construct($order_id="", $item_id="", $number="", $price=""){
            $this->order_id = $order_id;
            $this->item_id = $item_id;
            $this->number = $number;
            $this->price = $price;
        }
        
        // 入力チェックをするメソッド
        public function validate(){
            // 空のエラー配列作成
            $errors = array();
            // ユーザーIDが入力されていなければ
            if($this->user_id === ''){
                $errors[] = 'ユーザー番号が入力されていません';
            }
            // 郵便番号が正しく入力されていなければ
            if(!preg_match('/^[0-9]{3}-[0-9]{4}$/', $this->zipcode)){
                $errors[] = '郵便番号をxxx-xxxxの形式で入力してください';
            }
            // 個数が選択されていなければ
            if($this->address === ''){
                $errors[] = '住所を入力してください';
            }
            // 電話番号が正しく入力されていなければ
            if(!preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $this->tel)){
                $errors[] = '電話番号をxxx-xxxx-xxxxの形式で入力してください';
            }
            
            // 完成したエラー配列はいあげる
            return $errors;
        }
      
        // 全テーブル情報を取得するメソッド
        public static function all($user_id){
            try {
                $pdo = self::get_connection();
                $stmt = $pdo->prepare('SELECT carts.id, carts.item_id, items.name, items.image, items.price, items.stock, carts.number, carts.created_at FROM carts JOIN items on carts.item_id=items.id WHERE carts.user_id=:user_id');
                // バインド処理
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                // 実行
                $stmt->execute();
                // フェッチの結果を、Cartクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Cart');
                $carts = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                // Cartクラスのインスタンスの配列を返す
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
                    $stmt = $pdo -> prepare("INSERT INTO order_items (order_id, item_id, number, price) VALUES (:order_id, :item_id, :number, :price)");
                    // バインド処理
                    $stmt->bindParam(':order_id', $this->order_id, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT);
                    $stmt->bindParam(':number', $this->number, PDO::PARAM_INT);
                    $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
                    // 実行
                    $stmt->execute();
                    
                }else{ // 更新
                     $stmt = $pdo -> prepare("UPDATE carts SET number=:number, updated_at=NOW() WHERE id=:id");
                     // バインド処理
                     $stmt->bindParam(':number', $this->number, PDO::PARAM_INT);
                     $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                     // 実行
                     $stmt->execute();
                }
                
                self::close_connection($pdo, $stmp);
                if($this->id === null){
                    return '';
                }else{
                    return 'カート番号: ' . $this->id . 'のカート商品の個数を更新しました。';
                }
                
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        public static function find($id){
                try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("select * from carts where id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
                // フェッチの結果を、Cartクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Cart');
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
                $stmt = $pdo -> prepare("DELETE FROM carts WHERE id=:id");
                // バインド処理
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
               
            } catch (PDOException $e) {
                    return 'PDO exception: ' . $e->getMessage();
            }
        }
        
        // 重複チェック
        public static function find_my_cart($user_id, $item_id){
             try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("SELECT * FROM carts WHERE user_id=:user_id AND item_id=:item_id");
                // バインド処理
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);

                // 実行
                $stmt->execute();
                // フェッチの結果を、Cartクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Cart');
                $my_cart = $stmt->fetch();
                self::close_connection($pdo, $stmp);
                return $my_cart;                
            
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