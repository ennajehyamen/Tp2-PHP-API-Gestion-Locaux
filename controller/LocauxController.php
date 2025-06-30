<?php
require_once 'config/Database.php';
require_once 'models/Locaux.php';
require_once 'utils/Helper.php';
class LocauxController {
    private $mysqli;
    private $method;
    private $id;
    private $model;

    public function __construct($mysqli, $method, $id = null) {
        $this->mysqli = $mysqli;
        $this->method = $method;
        $this->id = $id;
        $this->model = new Locaux($mysqli);
    }

    public function handleRequest() {
        if ($this->method === "GET") {
            if (isset($_GET['departement'])) {
                $locals = $this->model->getByDepartement($_GET['departement']);
                if ($locals) {
                    echo json_encode($locals);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "No locals found for this department"]);
                }   
            }
            if ($this->id) {
                $local = $this->model->getById($this->id);
                if ($local) {
                    echo json_encode($local);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Local not found"]);
                } 
            } else {
                $locaux = $this->model->getAll();
                echo json_encode($locaux);
            }
            exit;
        }
        if ($this->method === "POST") {

            $data = $this->getBody();
            //var_dump($data);
            $newLocal = $this->model->create($data);
            if ($newLocal) {
                http_response_code(201);
                echo json_encode(["id" => $newLocal]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to create local"]);
            }
        }
        if ($this->method === "PUT" && $this->id) {
            $data = $this->getBody();
            $updated = $this->model->update($this->id, $data);
            if ($updated) {
                echo json_encode(["success" => true]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to update local"]);
            }   
        }
        if ($this->method === "DELETE" && $this->id) {
            $deleted = $this->model->delete($this->id);
            if ($deleted) { 
                http_response_code(204);
                echo json_encode(["success" => true]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to delete local"]);
            }       
        }
    }

    private function getBody() {
        return json_decode(file_get_contents('php://input'), true);
    }
}
  