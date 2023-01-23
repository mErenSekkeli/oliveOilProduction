<?php
require_once(realpath(dirname(__FILE__) . '/../service/my_orders_service.php'));


class my_orders_controller{

    public $my_orders_service;
    public $orders;

    public function __construct(){
        $this->my_orders_service = new my_orders_service();
        $this->getOrders();
    }

    public function getOrders(){
        $orders = $this->my_orders_service->getOrders();
        return $orders;
    }

}

if(isset($_POST['refundOrder'])){
    $con = new my_orders_controller();
    if($con->my_orders_service->refundOrder()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}

if(isset($_POST['deleteOrder'])){
    $con = new my_orders_controller();
    if($con->my_orders_service->deleteOrder()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}
?>