<?php 
require_once(realpath(dirname(__FILE__) . '/connection.php'));
class header_service{
    public $user;
    public $conn;

    public function __construct(){
        $conn = new connection();
        $this->conn = $conn;
    }

    public function get_user(){
        $query =$this->conn->db->prepare("SELECT getUser.*, addresses.* FROM users as getUser, addresses WHERE getUser.user_id=:id AND addresses.user_id=:id");
        $query->execute(array(
            'id' => $_SESSION['user_id']
        ));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if($row){
            return $row;
        } else{
            return false;
        }
    }

    public function changeUserInfos(){
        $query =$this->conn->db->prepare("UPDATE users SET user_name=:user_name, user_surname=:user_surname WHERE user_id=:id");
        $query->execute(array(
            'user_name' => $_POST['user_name'],
            'user_surname' => $_POST['user_surname'],
            'id' => $_SESSION['user_id']
        ));
        $query =$this->conn->db->prepare("UPDATE addresses SET address=:address, phone_number=:phone_number WHERE user_id=:id");
        $query->execute(array(
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'id' => $_SESSION['user_id']
        ));

        return true;
    }
}
?>