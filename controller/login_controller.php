<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../service/login_service.php'));
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) { 
    header("Location: index.php");
    exit();
}

if(isset($_POST['loginSubmit'])) {
    $user = login_checker();
    if($user){
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_mail'] = $user['user_mail'];
        header("Location: ../index.php");
    }else{
        header("Location: ../login.php?error=wrongInfo");
    }
}

?>