<?php

require_once 'Model.php';

class Sprint extends Model
{
    private string $table = "sprints";

    /* ATRIBUTOS */
    private ?int $id = null;
    private string $nombre;
    private string $fecha_inicio;
    private string $fecha_fin;

    /* SETTERS */

    public function setNombre(string $nombre): void
    {
        $this->nombre = trim($nombre);
    }

    public function setFechaInicio(string $fecha_inicio): void
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setFechaFin(string $fecha_fin): void
    {
        $this->fecha_fin = $fecha_fin;
    }

    /* GETTERS */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getFechaInicio(): string
    {
        return $this->fecha_inicio;
    }

    public function getFechaFin(): string
    {
        return $this->fecha_fin;
    }

    /* OBTENER TODOS */

    public function getAll(): PDOStatement
    {
        $query = "SELECT *
                  FROM {$this->table}
                  ORDER BY id DESC";

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    /* CREAR :P */

    public function create(): bool
    {
        $query = "INSERT INTO {$this->table}
                  (nombre, fecha_inicio, fecha_fin)
                  VALUES
                  (:nombre, :fecha_inicio, :fecha_fin)";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':nombre', $this->nombre);
        $stmt->bindValue(':fecha_inicio', $this->fecha_inicio);
        $stmt->bindValue(':fecha_fin', $this->fecha_fin);

        return $stmt->execute();
    }

    /* ELIMINAR :p */

    public function delete(int $id): bool
    {
        $query = "DELETE
                  FROM {$this->table}
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}