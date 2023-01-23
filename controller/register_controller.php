<?php
session_start();
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) { 
    header("Location: index.php");
    exit;
}
require_once(realpath(dirname(__FILE__) . '/../service/register_service.php'));

if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) { 
    header("Location: index.php");
    exit();
}

class register_controller{
    public $register_service;
    public function __construct(){
        $this->register_service = new register_service();
        if($this->register_service->register()){
            header("Location: ../login.php?situation=success");
        }else{
            header("Location: ../register.php?situation=error");
        }
    }
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $con = new register_controller();
}


?>