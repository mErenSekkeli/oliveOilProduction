<?php
require_once(realpath(dirname(__FILE__) . '/../service/users_service.php'));

class users_controller{  
    public $users_service;
    public $users;

    public function __construct(){
        $this->users_service = new users_service();
        $this->getUsers();
    }

    public function getUsers(){
        $users = $this->users_service->getUsers();
        return $users;
    }

}

if(isset($_POST['searchUser'])){
    $con = new users_controller();
    $users = $con->users_service->searchUser();
    $users =  $users->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($users)){
        $_SESSION['users'] = $users;
        header('Location: ../users?search=success');
    }else{
        header('Location: ../users?search=error');
        $_SESSION['users'] = "empty";
    }
}

if(isset($_POST['changeRole'])){
    $con = new users_controller();
    if($con->users_service->changeRole()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}

?>