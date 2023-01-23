<?php
if(empty($_SESSION['user_id']) || !isset($_SESSION['user_id'])){
    session_start();
}
require_once(realpath(dirname(__FILE__) . '/connection.php'));
class oil_transform_service{
    public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function oil_transform(){
        if(!empty($_POST['olive_weight']) && !empty($_POST['olive_type'])){
        $query = $this->conn->db->prepare("INSERT INTO olive_orders (olive_type, olive_weight) VALUES (:olive_type, :olive_weight)");
        $result = $query->execute(array(
            'olive_type' => $_POST['olive_type'],
            'olive_weight' => $_POST['olive_weight']
        ));

        if(!$result){
            return false;
        }
        $query =$this->conn->db->prepare("INSERT INTO oil_appointment (user_id, olive_order_id, appointment_date) VALUES (:user_id, :olive_order_id, :appointment_date)");
        $result = $query->execute(array(
            'user_id' => $_SESSION['user_id'],
            'olive_order_id' => $this->conn->db->lastInsertId(),
            'appointment_date' => $_POST['appointment_date']
        ));
        if(!$result){
            return false;
        }
        
        $id = $this->conn->db->lastInsertId() - 1;
        $query = $this->conn->db->prepare("SELECT findPriceOfOilTransformation(:id)");
        $result = $query->execute(array(
            'id' => $id
        ));

        if($result){
            return true;
        } else{
            return false;
        }
    }else{
        return false;
    }
    }

    public function getDisabledSlots(){
        $query = $this->conn->db->prepare("SELECT getDisabledSlots()");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>