<?php

class Departements {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAll() {
        $result = $this->mysqli->query("SELECT * FROM departements");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM departements WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function create($data) {
        $stmt = $this->mysqli->prepare("INSERT INTO departements (nom) VALUES (?)");
        $stmt->bind_param("s", $data['nom']);
        $stmt->execute();
        return $this->mysqli->insert_id;
    }

    public function update($id, $data) {
        if (!is_numeric($id)) {
            return false; // Invalid ID
        }
        $stmt = $this->mysqli->prepare("UPDATE departements SET nom = ? WHERE id = ?");
        $stmt->bind_param("si", $data['nom'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->mysqli->prepare("DELETE FROM departements WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}