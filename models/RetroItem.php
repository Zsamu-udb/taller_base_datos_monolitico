<?php

require_once 'Model.php';

class RetroItem extends Model
{
    private string $table = "retro_items";

    private ?int $id = null;
    private int $sprint_id;
    private string $categoria;
    private string $descripcion;
    private ?bool $cumplida = null;
    private ?string $fecha_revision = null;



    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setSprintId(int $sprint_id): void
    {
        $this->sprint_id = $sprint_id;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSprintId(): int
    {
        return $this->sprint_id;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }


    public function getAll()
    {
        $query = "SELECT * FROM {$this->table}
                  ORDER BY id DESC";

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return $stmt;
    }



    public function create(): bool
    {
        $query = "INSERT INTO {$this->table}
                  (sprint_id, categoria, descripcion)
                  VALUES
                  (:sprint_id, :categoria, :descripcion)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':sprint_id', $this->sprint_id);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':descripcion', $this->descripcion);

        return $stmt->execute();
    }



    public function getBySprint(int $sprint_id)
    {
        $query = "SELECT *
                  FROM {$this->table}
                  WHERE sprint_id = :sprint_id
                  ORDER BY id DESC";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':sprint_id', $sprint_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }



    public function getPreviousActions(int $sprint_id)
    {
        $previous = $sprint_id - 1;

        $query = "SELECT *
                  FROM {$this->table}
                  WHERE sprint_id = :sprint_id
                  AND categoria = 'accion'";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':sprint_id', $previous, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }



    public function getById(int $id)
    {
        $query = "SELECT *
                  FROM {$this->table}
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function update(): bool
    {
        $query = "UPDATE {$this->table}
                  SET categoria = :categoria,
                      descripcion = :descripcion
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':descripcion', $this->descripcion);

        return $stmt->execute();
    }



    public function marcarCumplida(int $id): bool
    {
        $query = "UPDATE {$this->table}
                  SET cumplida = 1
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this->table}
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
