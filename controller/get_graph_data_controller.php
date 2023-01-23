<?php
require_once(realpath(dirname(__FILE__) . '/../service/get_graph_data_service.php'));

class get_graph_data_controller{
public $get_graph_data_service;
public $appointments;
    public function __construct(){
        $this->get_graph_data_service = new get_graph_data_service();
    }

    public function getGraphData() {
        $graph = $this->get_graph_data_service->getGraph();

        $graph = $graph->fetchAll(PDO::FETCH_ASSOC);
        return $graph;
    }

}

if(isset($_GET['isSelected'])){
    $con = new get_graph_data_controller();
    $results = $con->getGraphData();
    echo json_encode($results);
}


?>