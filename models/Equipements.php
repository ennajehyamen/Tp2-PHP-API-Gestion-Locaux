<?php


class Equipements {
    private $conn;
    private $table = 'equipements';

        public function __construct($mysqli) {
        $this->conn = $mysqli;
    }

    // Create equipment
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (nom, etat, est_mobile, local_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $data['nom'], $data['etat'], $data['est_mobile'], $data['local_id']);
        return $stmt->execute();
    }

    public function assciate($equipement_id, $local_id) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET local_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $local_id, $equipement_id);
        return $stmt->execute();
    }

    // Read all equipment
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Read one equipment by id
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update equipment
    public function update($id, $data) {
        // Prepare the SQL statement
        if (!is_numeric($id)) {
            return false; // Invalid ID
        }
        $equipement = $this->getById($id);
        if (!$equipement) {
            return false; // equipement not found
        }else{
            $data = array_merge($equipement, $data); // Merge existing data with new data
        }
        $stmt = $this->conn->prepare("UPDATE $this->table SET nom = ?, etat = ?, est_mobile = ?, local_id = ? WHERE id = ?");
        $stmt->bind_param("ssiii", $data['nom'], $data['etat'], $data['est_mobile'], $data['local_id'], $id);
        return $stmt->execute();
    }

    // Delete equipment
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

