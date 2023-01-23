<?php
require_once(realpath(dirname(__FILE__) . '/connection.php'));
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    session_start();
}
class products_service{
    public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function getProducts(){
        $query = $this->conn->db->prepare("SELECT company_products.* FROM company_products");
        $query->execute();
        return $query;
    }

    public function getProduct($id){
        $query = $this->conn->db->prepare("SELECT company_products.* FROM company_products WHERE product_id = :product_id");
        $query->execute(array(
            'product_id' => $id
        ));
        return $query;
    }

    public function editProduct(){
        $query = $this->conn->db->prepare("UPDATE company_products SET product_name = :product_name, product_stock = :product_stock, product_price_per_kilo = :product_price_per_kilo, product_status = :product_status WHERE product_id = :product_id");
        $result = $query->execute(array(
            'product_name' => $_POST['product_name'],
            'product_stock' => $_POST['product_stock'],
            'product_price_per_kilo' => $_POST['product_price'],
            'product_status' => $_POST['product_status'],
            'product_id' => $_POST['product_id']
        ));
        if($result){
            return true;
        }else{
            return false;
        }     
    }

    public function deleteProduct(){
        $query = $this->conn->db->prepare("DELETE FROM company_products WHERE product_id = :product_id");
        $result = $query->execute(array(
            'product_id' => $_POST['product_id']
        ));
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function addProduct(){
        $query = $this->conn->db->prepare("INSERT INTO company_products (product_name, product_stock, product_price_per_kilo, product_status) VALUES (:product_name, :product_stock, :product_price_per_kilo, :product_status)");
        $result = $query->execute(array(
            'product_name' => $_POST['product_name'],
            'product_stock' => $_POST['product_stock'],
            'product_price_per_kilo' => $_POST['product_price'],
            'product_status' => $_POST['product_status']
        ));
        if($result){
            return true;
        }else{
            return false;
        }
    }
}

?>