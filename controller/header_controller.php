<?php
session_start();
if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])) { 
    header("Location: login.php");
    exit;
}
require_once(realpath(dirname(__FILE__) . '/../service/header_service.php'));

class header_controller{
    public $user;
    public $header_service;

    public function __construct(){
        $this->header_service = new header_service();
        $this->user = $this->header_service->get_user();
        if(!$this->user){
            header("Location: login.php");
            exit;
        }
    }

    public function changeUserInfo(){
        if($this->header_service->changeUserInfos()){
            header("Location: ../profile?situation=success");
        }else{
            header("Location: ../profile?situation=error");
        }

    }
}
$con = new header_controller();
if(isset($_POST['changeUserInfo']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $con->changeUserInfo();
}

?>