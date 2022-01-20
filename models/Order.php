<?php
    // モデル(M)
    require_once 'models/Model.php';
    require_once 'models/User.php';
    require_once 'models/Item.php';
    require_once 'models/Cart.php';
    require_once 'models/OrderItem.php';

    // 注文の設計図を作成
    class Order extends Model{
        // プロパティ
        public $id; // 注文番号
        public $user_id; //登録者のユーザー番号
        public $zipcode; // 郵便番号
        public $address; // 住所
        public $tel; // 電話番号
        public $created_at; // 注文日時

        // コンストラクタ
        public function __construct($user_id="", $zipcode="", $address="", $tel=""){
            $this->user_id = $user_id;
            $this->zipcode = $zipcode;
            $this->address = $address;
            $this->tel = $tel;
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
                $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id=:user_id');
                // バインド処理
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                // 実行
                $stmt->execute();
                // フェッチの結果を、Orderクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Order');
                $orders = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                // Orderクラスのインスタンスの配列を返す
                return $orders;
            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
        // データを1件登録するメソッド
        public function save(){
            try {
                $pdo = self::get_connection();
                
                if($this->id === null){
                    $stmt = $pdo -> prepare("INSERT INTO orders (user_id, zipcode, address, tel) VALUES (:user_id, :zipcode, :address, :tel)");
                    // バインド処理
                    $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':zipcode', $this->zipcode, PDO::PARAM_STR);
                    $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
                    $stmt->bindParam(':tel', $this->tel, PDO::PARAM_STR);
                    // 実行
                    $stmt->execute();
                    
                    $order_id = $pdo->lastInsertId();
                    
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
                    return $order_id;
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
        // その注文に紐づいた注文商品一覧を取得
        public function order_items(){
             try {
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("select orders.id as order_id, items.id as item_id, items.name, items.image, order_items.number, order_items.price, order_items.price*order_items.number as subtotal, orders.created_at from order_items join orders on order_items.order_id=orders.id join users on orders.user_id=users.id join items on order_items.item_id=items.id where orders.id=:order_id");
                // バインド処理
                $stmt->bindParam(':order_id', $this->id, PDO::PARAM_INT);                // 実行
                $stmt->execute();
                // フェッチの結果を、OrderItemクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'OrderItem');
                $order_items = $stmt->fetchAll();
                self::close_connection($pdo, $stmp);
                return $order_items;
                
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
        
        public function commit(){
            // try{
                $pdo = self::get_connection();
                
                // $pdo->beginTransaction();
                
                $order_id = $this->save();
                $carts = Cart::all($this->user_id);
                
                foreach($carts as $cart){
                    // カートの商品番号から商品情報を取得
                    $item = Item::find($cart->item_id);
                    // 新しい注文商品詳細を作成
                    $order_item = new OrderItem($order_id, $cart->item_id, $cart->number, $item->price);
                    // 注文商品詳細をデータベースに保存
                    $order_item->save();
                    // カート情報削除
                    Cart::destroy($cart->id);
                    // 商品の在庫を減らす
                    $item->stock -= $cart->number;
                    // 商品の在庫更新
                    $item->save();
                    
                    
                }
                // $pdo->commit();
            // }catch(PDOException $e){
            //     // $pdo->rollback();
            //     return null;
            // }
        }
    }
