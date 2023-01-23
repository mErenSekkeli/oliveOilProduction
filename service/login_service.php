<?php
ob_start();
require_once(realpath(dirname(__FILE__) . '/connection.php'));
/* @var $db connection.php */
function login_checker(){
    $conn = new connection();
    $user_mail = $_POST['user_mail'];
    $user_password = md5($_POST['user_password']);
    $query =$conn->db->prepare("SELECT users.* FROM users WHERE user_mail=:mail AND user_password=:password");
    $query->execute(array(
        'mail' => $user_mail,
        'password' => $user_password
    ));
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if($row){
        return $row;
    } else{
        return false;
    }
}
?>