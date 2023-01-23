<?php
require_once(realpath(dirname(__FILE__) . '/../service/my_appointment_service.php'));

class my_appointment_controller{
public $my_appointment_service;
public $appointments;
    public function __construct(){
        $this->my_appointment_service = new my_appointment_service();
        $this->getAppointments();
        $this->getAnalysis();
    }

    public function getGraphData() {
        $graph = $this->my_appointment_service->getGraphData();
        return $graph;
    }

    public function getBestUsers() {
        $bestUsers = $this->my_appointment_service->getBestUsers();
        return $bestUsers;
    }

    public function getAppointments(){
        $appointments = $this->my_appointment_service->getAppointments();
        return $appointments;
    }
    public function getAnalysis(){
        $analysis = $this->my_appointment_service->getAnalysis();
        return $analysis;
    }
}

if(isset($_POST['cancelAppointment'])){
    $con = new my_appointment_controller();
    if($con->my_appointment_service->cancelAppointment()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}

if(isset($_POST['deleteAppointment'])){
    $con = new my_appointment_controller();
    if($con->my_appointment_service->deleteAppointment()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}

?>