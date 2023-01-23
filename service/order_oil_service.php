<?php
require_once(realpath(dirname(__FILE__) . '/connection.php'));
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    session_start();
}
class order_oil_service{
    public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function getProducts(){
        $query = $this->conn->db->prepare("SELECT company_products.* FROM company_products WHERE product_status = 1");
        $query->execute();
        return $query;
    }

    public function requestOil(){
        $query = $this->conn->db->prepare("SELECT checkIfStockEnough(:id, :stock)");
        $query->execute(array(
            'id' => $_POST['product_id'],
            'stock' => $_POST['order_liter']
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insertOrder(){
        $query2 = $this->conn->db->prepare("SELECT company_products.product_price_per_kilo FROM company_products WHERE product_id = :product_id");
        $query2->execute(array(
            'product_id' => $_POST['product_id']
        ));

        $price = $query2->fetch(PDO::FETCH_ASSOC);
        $price = $price['product_price_per_kilo'];
        $newDate = date('Y-m-d H:i:s', strtotime(' + 2 hours'));
        $query = $this->conn->db->prepare("INSERT INTO user_orders (user_id, product_id, order_price, product_liter, order_date, is_refund) VALUES (:user_id, :product_id, :order_price, :product_liter, :order_date, :is_refund)");
        $result = $query->execute(array(
        'user_id' => $_SESSION['user_id'],
        'product_id' => $_POST['product_id'],
        'order_price' => $price * $_POST['order_liter'],
        'product_liter' => $_POST['order_liter'],
        'order_date' => $newDate,
        'is_refund' => 0
    ));

        if($result){
            return true;
        }else{
            return false;
        }

    }
}
?>