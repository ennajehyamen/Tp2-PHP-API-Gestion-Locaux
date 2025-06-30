<?php

require_once 'config/Database.php';
require_once 'models/Departements.php';
require_once 'utils/Helper.php';

class DepartementsController {
    private $mysqli;
    private $model;
    private $method;
    private $id;

    public function __construct($mysqli, $method, $id = null) {
        $this->mysqli = $mysqli;
        $this->model = new Departements($mysqli);
        $this->method = $method;
        $this->id = $id;
    }

    public function handleRequest() {
        if ($this->method === "GET") {
            if ($this->id) {
                $departement = $this->model->getById($this->id);
                if ($departement) {
                    echo json_encode($departement);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Departement not found"]);
                }
            } else {
                $departements = $this->model->getAll();
                echo json_encode($departements);
            }
            exit;
        }

        if ($this->method === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['nom'])) {
                $newDepartement = $this->model->create($data);
                if ($newDepartement) {
                    http_response_code(201);
                    echo json_encode(["id" => $newDepartement]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Failed to create departement"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Invalid data"]);
            }
            exit;
        }

        if ($this->method === "PUT" && $this->id) {
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['nom'])) {
                $updated = $this->model->update($this->id, $data);
                if ($updated) {
                    echo json_encode(["success" => true]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Failed to update departement"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Invalid data"]);
            }
            exit;
        }

        if ($this->method === "DELETE" && $this->id) {
            $deleted = $this->model->delete($this->id);
            if ($deleted) {
                http_response_code(204);
                echo json_encode(["success" => true]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Failed to delete departement"]);
            }
            exit;
        }

    }

}
