<?php

class Sprint {
    private $conn;
    private $table = "sprints";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function create($nombre, $fecha_inicio, $fecha_fin) {

        $query = "INSERT INTO {$this->table}
                  (nombre, fecha_inicio, fecha_fin)
                  VALUES
                  (:nombre, :fecha_inicio, :fecha_fin)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":fecha_inicio", $fecha_inicio);
        $stmt->bindParam(":fecha_fin", $fecha_fin);

        return $stmt->execute();
    }
}