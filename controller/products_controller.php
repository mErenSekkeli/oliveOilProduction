<?php 
require_once(realpath(dirname(__FILE__) . '/../service/products_service.php'));

class products_controller{
    public $products_service;

    public function __construct(){
        $this->products_service = new products_service();
    }

    public function getProducts(){
        return $this->products_service->getProducts();
    }

    public function getProduct($id){
        return $this->products_service->getProduct($id);
    }
}

if(isset($_POST['add_product'])){
    $con = new products_controller();
    if($con->products_service->addProduct()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}

if(isset($_POST['editProduct'])){
    $con = new products_controller();
    if($con->products_service->editProduct()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}

if(isset($_POST['deleteProduct'])){
    $con = new products_controller();
    if($con->products_service->deleteProduct()){
        $json_data['status'] = "success";
    }else{
        $json_data['status'] = "error";
    }
    echo json_encode($json_data);
}
?>