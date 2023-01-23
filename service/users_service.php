<?php 
require_once(realpath(dirname(__FILE__) . '/connection.php'));
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    session_start();
}

class users_service{
    public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function getUsers(){
        $query = $this->conn->db->prepare("SELECT users.*, addresses.* FROM users, addresses WHERE users.user_id = addresses.user_id ORDER BY users.user_id ASC");
        $result = $query->execute();
        if($result){
            return $query;
        }else{
            return false;
        }
    }

    public function searchUser(){
        $search = (isset($_GET["search_key"]) ? $_GET["search_key"] : $_POST['search_key']);
        
        $query = $this->conn->db->prepare("SELECT users.user_id, users.user_name, users.user_surname, users.user_mail, users.is_admin, users.is_active, addresses.* FROM users, addresses WHERE users.user_id = addresses.user_id AND (users.user_name LIKE :search OR users.user_name_surname LIKE :search OR users.user_surname LIKE :search OR users.user_mail LIKE :search)");
        $result = $query->execute(array(
          'search' => "%$search%"
        ));
        if($result){
            return $query;
        }else{
            return false;
        }
    }

    public function changeRole(){
        $query = $this->conn->db->prepare("UPDATE users SET is_admin = :is_admin, is_active = :is_active WHERE user_id = :user_id");
        $result = $query->execute(array(
            'is_admin' => $_POST['is_admin'],
            'is_active' => $_POST['is_active'],
            'user_id' => $_POST['user_id']
        ));
        if($result){
            return true;
        }else{
            return false;
        }
    }
}

?>