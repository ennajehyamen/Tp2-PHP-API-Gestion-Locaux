<?php
require_once 'config/Database.php';
require_once 'models/Equipements.php';
require_once 'utils/Helper.php';

class EquipementsController
{
    private $mysqli;
    private $method;
    private $id;
    private $model;

    public function __construct($mysqli, $method, $id = null)
    {
        $this->mysqli = $mysqli;
        $this->method = $method;
        $this->id = $id;
        $this->model = new Equipements($this->mysqli);
    }

    public function handleRequest()
    {
        if ($this->method === "GET") {
            if (isset($_GET['local_id'])) {
                $local_id = $_GET['local_id'];
                $equipements = $this->model->getByLocal($local_id);
                if ($equipements) {
                    echo json_encode($equipements);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "No equipment found for this local"]);
                }
                exit;
            }
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
        if ($this->method === "PUT" && $this->id) {
            $data = $this->getBody();
            if (isset($_GET['local_id'])) {
                $data['local_id'] = $_GET['local_id'];
                //var_dump($data);
                $updated = $this->model->assciate($this->id, $data['local_id']);
                if ($updated) {
                    echo json_encode(["success" => "Equipment associated with local successfully"]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Failed to associate equipment with local"]);
                }

            } else {
                $updated = $this->model->update($this->id, $data);
                if ($updated) {
                    echo json_encode(["success" => "Equipment updated successfully"]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Failed to update equipment"]);
                }
            }
        }
        if ($this->method === "DELETE" && $this->id) {
            $deleted = $this->model->delete($this->id);
            if ($deleted) {
                http_response_code(204);
                echo json_encode(["success" => "Equipment deleted successfully"]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to delete equipment"]);
            }
        }
    }

    private function getBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}
