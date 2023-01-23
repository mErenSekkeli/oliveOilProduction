<?php 
require_once(realpath(dirname(__FILE__) . '/connection.php'));
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    session_start();
}

class my_orders_service{
    public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function getOrders(){
        $query = $this->conn->db->prepare("SELECT user_orders.*, company_products.product_name as product_name FROM user_orders, company_products WHERE user_id = :user_id
        AND user_orders.product_id = company_products.product_id ORDER BY order_date DESC");
        $query->execute(array(
            'user_id' => $_SESSION['user_id']
        ));
        if($query){
            return $query;
        }else{
            return false;
        }
    }

    public function refundOrder(){
        $id = $_POST['order_id'];
        $query = $this->conn->db->prepare("UPDATE user_orders SET is_refund = 1 WHERE order_id = :order_id AND is_refund = :is_refund");
        $query->execute(array(
            'is_refund' => 0,
            'order_id' => $id
        ));

        //update stock
        $query = $this->conn->db->prepare("SELECT product_id, product_liter FROM user_orders WHERE order_id = :order_id");
        $query->execute(array(
            'order_id' => $id
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $product_id = $result['product_id'];
        $product_liter = $result['product_liter'];

        $query = $this->conn->db->prepare("UPDATE company_products SET product_stock = product_stock + :stock WHERE product_id = :product_id");
        $query->execute(array(
            'stock' => $product_liter,
            'product_id' => $product_id
        ));

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function deleteOrder(){
        $id = $_POST['order_id'];
        $query = $this->conn->db->prepare("DELETE FROM user_orders WHERE order_id = :order_id");
        $query->execute(array(
            'order_id' => $id
        ));
        if($query){
            return true;
        }else{
            return false;
        }
    }
}

?>