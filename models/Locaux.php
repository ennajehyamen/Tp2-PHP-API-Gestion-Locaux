<?php
class Locaux {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAll() {
        $result = $this->mysqli->query("SELECT * FROM locaux");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM locaux WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function getByDepartement($departement) {
        $stmt = $this->mysqli->prepare("SELECT * FROM locaux WHERE departement = ?");
        $stmt->bind_param("s", $departement);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $stmt = $this->mysqli->prepare("INSERT INTO locaux ( `nom`, `departement`, `capacite`, `type`, `etage`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $data['nom'], $data['departement'], $data['capacite'], $data['type'], $data['etage']);
        $stmt->execute();
        return $this->mysqli->insert_id;
    }

    public function update($id, $data) {
        // Prepare the SQL statement
        if (!is_numeric($id)) {
            return false; // Invalid ID
        }
        $local = $this->getById($id);
        if (!$local) {
            return false; // Local not found
        }else{
            $data = array_merge($local, $data); // Merge existing data with new data
        }

        $stmt = $this->mysqli->prepare("UPDATE locaux SET nom = ?, departement = ?, capacite = ?, type = ?, etage = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $data['nom'], $data['departement'], $data['capacite'], $data['type'], $data['etage'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->mysqli->prepare("DELETE FROM locaux WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
