<?php
require_once(realpath(dirname(__FILE__) . '/connection.php'));
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    session_start();
}
class my_appointment_service{
public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function getGraphData() {
        $query = $this->conn->db->prepare("SELECT c.product_id, b.product_name, c.thesum FROM (SELECT product_id, SUM(order_price) AS thesum FROM user_orders WHERE is_refund = 0 GROUP BY product_id HAVING SUM(order_price) > ORDERAVG()) c, company_products b WHERE c.product_id = b.product_id");

        $result = $query->execute();

        if($result) {
            return $query;
        } else {
            return false;
        }
    }

    public function getBestUsers() {
        $query = $this->conn->db->prepare("SELECT u.user_id, u.user_name_surname, b.income FROM users u, bestUserMeta b WHERE b.user_id = u.user_id ORDER BY income DESC LIMIT 10");

        $result = $query->execute();

        if($result) {
            return $query;
        } else {
            return false;
        }
    }

    public function getAppointments(){
        $query = $this->conn->db->prepare("SELECT app.*, olive.* FROM oil_appointment as app, olive_orders as olive
        WHERE app.user_id = :user_id AND olive.olive_id = app.olive_order_id
        ORDER BY app.appointment_date DESC");
        $query->execute(array(
            'user_id' => $_SESSION['user_id']
        ));
        if($query){
            return $query;
        }else{
            return false;
        }
    }

    public function getAnalysis(){
        $query = $this->conn->db->prepare("SELECT summary.* FROM summary");
        $result = $query->execute();
        if($result){
            return $query;
        }else{
            return false;
        }
    }

    public function cancelAppointment(){
        $id = $_POST['appointment_id'];
        $query = $this->conn->db->prepare("UPDATE oil_appointment SET status = :status WHERE appointment_id = :appointment_id");
        $query->execute(array(
            'status' => 4,
            'appointment_id' => $id
        ));
        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function deleteAppointment(){
        $id = $_POST['appointment_id'];
        $query = $this->conn->db->prepare("DELETE FROM oil_appointment WHERE appointment_id = :appointment_id");
        $query->execute(array(
            'appointment_id' => $id
        ));
        $query = $this->conn->db->prepare("DELETE FROM olive_orders WHERE olive_id = :olive_id");
        $query->execute(array(
            'olive_id' => $id - 1
        ));
        if($query){
            return true;
        }else{
            return false;
        }
    }
}
?>