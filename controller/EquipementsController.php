<?php
require_once 'config/Database.php';
require_once 'models/Equipements.php';
require_once 'utils/Helper.php';

class EquipementsController {
    private $mysqli;
    private $method;
    private $id;
    private $model;

    public function __construct($mysqli, $method, $id = null) {
        $this->mysqli = $mysqli;
        $this->method = $method;
        $this->id = $id;
        $this->model = new Equipements($this->mysqli);
    }

    public function handleRequest() {
        if ($this->method === "GET") {
            if ($this->id) {
                $equipement = $this->model->getById($this->id);
                if ($equipement) {
                    echo json_encode($equipement);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Equipment not found"]);
                }
            } else {
                $equipements = $this->model->getAll();
                echo json_encode($equipements);
            }
            exit;
        }
        if ($this->method === "POST") {
            if (isset($_GET['local_id'])) {
                $data = $this->getBody();
                $data['local_id'] = $_GET['local_id'];
                //var_dump($data);
                
            } else {
                
                $data = $this->getBody();
                //var_dump($data);
                $newEquipement = $this->model->create($data);
                if ($newEquipement) {
                    http_response_code(201);
                    echo json_encode(["id" => $newEquipement]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Failed to create equipment"]);
                }
            }   
        }
        if ($this->method === "PUT" && $this->id) {
            $data = $this->getBody();
            //var_dump($data);
            $updated = $this->model->update($this->id, $data);
            if ($updated) {
                echo json_encode(["success" => true]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to update equipment"]);
            }   
        }
        if ($this->method === "DELETE" && $this->id) {
            $deleted = $this->model->delete($this->id);
            if ($deleted) { 
                http_response_code(204);
                echo json_encode(["success" => true]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to delete equipment"]);
            }       
        }
    }

    private function getBody() {
        return json_decode(file_get_contents('php://input'), true);
    }
}
