<?php
    // モデル(M)
    require_once 'models/User.php';

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
      
        // データを1件登録するメソッド
        public function save(){
            try {
                $pdo = self::get_connection();
                
                $stmt = $pdo -> prepare("INSERT INTO order_items (order_id, item_id, number, price) VALUES (:order_id, :item_id, :number, :price)");
                // バインド処理
                $stmt->bindParam(':order_id', $this->order_id, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT);
                $stmt->bindParam(':number', $this->number, PDO::PARAM_INT);
                $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
                // 実行
                $stmt->execute();
                self::close_connection($pdo, $stmt);

            } catch (PDOException $e) {
                return 'PDO exception: ' . $e->getMessage();
            }
        }
    }
