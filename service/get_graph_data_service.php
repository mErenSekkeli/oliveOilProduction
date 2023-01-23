<?php
require_once(realpath(dirname(__FILE__) . '/connection.php'));
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    session_start();
}
class get_graph_data_service{
    public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function getGraph(){
        $adminIncluded = "SELECT * FROM graphLastView";
        $adminNotIncluded = "SELECT * FROM graphLastView EXCEPT (SELECT * FROM graphLastView WHERE user_id IN (SELECT user_id FROM users WHERE is_admin = 1))";
        
        if(isset($_GET["isSelected"]) && $_GET["isSelected"] == "checked") {
            $query = $this->conn->db->prepare($adminIncluded);
            $query->execute();
            return $query;
        } else {
            $query = $this->conn->db->prepare($adminNotIncluded);
            $query->execute();
            return $query;
        }
    }

}
?>