<?php
require_once(realpath(dirname(__FILE__) . '/../service/all_appointments_service.php'));

class all_appointments_controller{
public $all_appointments_service;
public $appointments;
    public function __construct(){
        $this->all_appointments_service = new all_appointments_service();
        //$this->getAppointments();
        
    }
    public function getAllAppointments(){
        $appointments = $this->all_appointments_service->getAppointments();
        return $appointments;
    }
    // public function getGraphData() {
    //     $graph = $this->all_appointments_service->getGraphData();
    //     return $graph;
    // }

}

if(isset($_POST['changeApp'])){
    $con = new all_appointments_controller();
    $graph = $con->all_appointments_service->changeStatus();
    if($graph){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}

// if(isset($_POST['cancelAppointment'])){
//     $con = new all_appointments_service();
//     if($con->my_appointment_service->cancelAppointment()){
//         $json_data['status'] = "success";
//     }else{
//         $json_data['status'] = "error";
//     }
//     echo json_encode($json_data);
// }

// if(isset($_POST['deleteAppointment'])){
//     $con = new my_appointment_controller();
//     if($con->my_appointment_service->deleteAppointment()){
//         $json_data['status'] = "success";
//     }else{
//         $json_data['status'] = "error";
//     }
//     echo json_encode($json_data);
// }

?>