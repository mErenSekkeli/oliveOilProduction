<?php 
require_once(realpath(dirname(__FILE__) . '/../service/order_oil_service.php'));

class order_oil_controller{
    public $order_oil_service;

    public function __construct(){
        $this->order_oil_service = new order_oil_service();
    }

    public function getProducts(){
        return $this->order_oil_service->getProducts();
    }

}

if(isset($_POST['oilRequest'])){
    $con = new order_oil_controller();
    $stock = $con->order_oil_service->requestOil();
    if($stock['checkifstockenough'] == -1){
        if($con->order_oil_service->insertOrder()){
            $json_data['status'] = "EnoughStock";
        }else{
            $json_data['status'] = "error";
        }     
    }else{
        $json_data['status'] = "notEnoughStock";
        $json_data['stock'] = $stock;
    }
    echo json_encode($json_data);
}

?>