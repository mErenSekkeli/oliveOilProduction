<?php 
require_once(realpath(dirname(__FILE__) . '/../service/oil_transform_service.php'));
class oil_transform_controller{
    public $oil_transform_service;

    public function __construct(){
        $this->oil_transform_service = new oil_transform_service();
    }

    public function posted(){
        if($this->oil_transform_service->oil_transform()){
            $json_data['status'] = 'success';
        }else{
            $json_data['status'] = 'error';
        }
        echo json_encode($json_data);
    }

    public function getDisabledSlots(){
        return $this->oil_transform_service->getDisabledSlots();
    }
}
$con = new oil_transform_controller();
if(isset($_POST['appointment_date']) && isset($_POST['olive_type']) && !empty($_POST['olive_weight'])){
    $con->posted();
}else if(isset($_POST['appointment_date']) && empty($_POST['olive_weight'])){
    $json_data['status'] = 'empty_weight';
    echo json_encode($json_data);
}else if(isset($_POST['get_disabled_slots']) && !empty($_POST['get_disabled_slots'])){
    $json_data['status'] = 'success';
    $json_data['disabled_slots'] = $con->getDisabledSlots();
    echo json_encode($json_data);
}
?>