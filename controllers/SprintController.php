<?php

require_once '../config/database.php';
require_once '../models/Sprint.php';


$database = new Database();
$db = $database->connect();


$sprint = new Sprint($db);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ASIGNAR PROPIEDADES :3 */
    $sprint->nombre = $_POST['nombre'];
    $sprint->fecha_inicio = $_POST['fecha_inicio'];
    $sprint->fecha_fin = $_POST['fecha_fin'];


    $sprint->create();


    header("Location: /taller_base_datos_monolitico/public/index.php");

    exit();


if (isset($_GET['action']) && $_GET['action'] == 'eliminar') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        if ($sprintModel->delete($id)) {
            header("Location: ../public/index.php");
            exit();
        } else {
            echo "Error al eliminar de la base de datos";
        }
    }
}
}
