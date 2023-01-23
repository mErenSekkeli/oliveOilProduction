<?php
require_once(realpath(dirname(__FILE__) . '/connection.php'));
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    session_start();
}
class all_appointments_service{
public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function getAppointments(){
        $query = $this->conn->db->prepare("SELECT app.*, olive.*, u.user_name_surname FROM oil_appointment as app, olive_orders as olive, users as u 
        WHERE olive.olive_id = app.olive_order_id AND u.user_id = app.user_id
        ORDER BY app.appointment_id DESC");
        $result = $query->execute();
        if($result){
            return $query;
        }else{
            return false;
        }
    }

    public function changeStatus(){
        $query = $this->conn->db->prepare("UPDATE oil_appointment SET status = :status WHERE appointment_id = :id");
        $result = $query->execute(array(
            'status' => $_POST['status'],
            'id' => $_POST['appointment_id']
        )
        );
        if($result){
            return true;
        }else{
            return false;
        }
    }

    // public function getGraphData() {
    //     $query = $this->conn->db->prepare("SELECT c.product_id, b.product_name, c.thesum FROM (SELECT product_id, SUM(order_price) AS thesum FROM user_orders WHERE is_refund = 0 GROUP BY product_id HAVING SUM(order_price) > ORDERAVG()) c, company_products b WHERE c.product_id = b.product_id");

    //     $result = $query->execute();

    //     if($result) {
    //         return $query;
    //     } else {
    //         return false;
    //     }
    // }
}
?>