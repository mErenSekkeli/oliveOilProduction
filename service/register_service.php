<?php
require_once(realpath(dirname(__FILE__) . '/connection.php'));

class register_service{
    public $conn;

    public function __construct(){
        $this->conn = new connection();
    }

    public function register(){
        $query =$this->conn->db->prepare("INSERT INTO users (user_name, user_surname, user_mail, user_password) VALUES (:user_name, :user_surname, :user_mail, :user_password)");
        $query->execute(array(
            'user_name' => $_POST['user_name'],
            'user_surname' => $_POST['user_surname'],
            'user_mail' => $_POST['user_mail'],
            'user_password' => md5($_POST['user_password'])
        ));
        $query =$this->conn->db->prepare("INSERT INTO addresses (user_id, phone_number) VALUES (:user_id, :phone_number)");
        $query->execute(array(
            'user_id' => $this->conn->db->lastInsertId(),
            'phone_number' => $_POST['phone_number']
        ));
        return true;
    }
}
?>