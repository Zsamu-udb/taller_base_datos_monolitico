<?php

class Sprint
{

    /* CONEXIÓN */
    private $conn;

    /* TABLA */
    private $table = "sprints";

    /* PROPIEDADES */
    public $id;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;
    public $created_at;
    public $updated_at;

    /* CONSTRUCTOR */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /* OBTENER TODOS LOS SPRINTS */
    public function getAll()
    {

        $query = "SELECT * FROM {$this->table}
                  ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    /* CREAR SPRINT */
    public function create()
    {

        $query = "INSERT INTO {$this->table}
                  (nombre, fecha_inicio, fecha_fin)
                  VALUES
                  (:nombre, :fecha_inicio, :fecha_fin)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":fecha_inicio", $this->fecha_inicio);
        $stmt->bindParam(":fecha_fin", $this->fecha_fin);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM sprints WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
