<?php

class Database
{
    /* PROPIEDADES PRIVADAS pa que Martha no diga que no es OO */
    private $host = "localhost";
    private $db_name = "registro_retro_db";
    private $username = "root";
    private $password = "";

    /* CONEXIÓN UWU*/
    private $conn;

    /* MÉTODO DE CONEXIÓN  UWU*/
    public function connect()
    {
        $this->conn = null;

        try {

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {

            die("Error de conexión: " . $e->getMessage());
        }

        return $this->conn;
    }
}
