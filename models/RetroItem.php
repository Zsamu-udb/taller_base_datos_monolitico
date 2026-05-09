<?php

class RetroItem
{

    private $conn;

    private $table = "retro_items";

    /* PROPIEDADES OO JHASSA*/
    public $id;
    public $sprint_id;
    public $categoria;
    public $descripcion;
    public $cumplida;
    public $fecha_revision;
    public $created_at;
    public $updated_at;

    /* ESTE ES EL CONSTRUCTOR */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /* CREAR ITEM :3*/
    public function create()
    {

        $query = "INSERT INTO {$this->table}
                  (sprint_id, categoria, descripcion)
                  VALUES
                  (:sprint_id, :categoria, :descripcion)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sprint_id", $this->sprint_id);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":descripcion", $this->descripcion);

        return $stmt->execute();
    }

    /* OBTENER ITEMS POR SPRINT :3*/
    public function getBySprint($sprint_id)
    {

        $query = "SELECT *
                  FROM {$this->table}
                  WHERE sprint_id = :sprint_id
                  ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sprint_id", $sprint_id);

        $stmt->execute();

        return $stmt;
    }

    /* OBTENER ACCIONES ANTERIORES :3*/
    public function getPreviousActions($sprint_id)
    {

        $previous = $sprint_id - 1;

        $query = "SELECT *
                  FROM {$this->table}
                  WHERE sprint_id = :sprint_id
                  AND categoria = 'accion'";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sprint_id", $previous);

        $stmt->execute();

        return $stmt;
    }

    /* MARCAR COMO CUMPLIDA :3*/
    public function marcarCumplida($id)
    {

        $query = "UPDATE {$this->table}
                  SET cumplida = 1
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /* ELIMINAR :3*/
    public function delete($id)
    {

        $query = "DELETE FROM {$this->table}
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /* OBTENER POR ID :3*/
    public function getById($id)
    {

        $query = "SELECT *
                  FROM {$this->table}
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ACTUALIZAR :3*/
    public function update($id, $categoria, $descripcion)
    {

        $query = "UPDATE {$this->table}
                  SET categoria = :categoria,
                      descripcion = :descripcion
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":descripcion", $descripcion);

        return $stmt->execute();
    }
}
