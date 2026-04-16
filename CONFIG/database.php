<?php
class Database {
    private $host_db = "localhost";
    private $user_db = "root";
    private $pwd_db = "BASES202610";
    private $name_db = "registro_retro_db";
    public function connect() {
        $connDb = new mysqli(
            $this->host_db,
            $this->user_db,
            $this->pwd_db,
            $this->name_db
        );
        if ($connDb->connect_error) {
            die("Error de conexión: " . $connDb->connect_error);
        }
        return $connDb;
    }
}