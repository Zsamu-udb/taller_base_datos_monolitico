<?php

require_once '../config/database.php';
require_once '../models/Sprint.php';

$database = new Database();
$db = $database->connect();

$sprint = new Sprint($db);

/*CREAR SPRINT*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sprint->setNombre($_POST['nombre']);
    $sprint->setFechaInicio($_POST['fecha_inicio']);
    $sprint->setFechaFin($_POST['fecha_fin']);

    $sprint->create();

    header("Location: /taller_base_datos_monolitico/public/index.php");
    exit();
}

/* ELIMINAR SPRINT*/

if (isset($_GET['action']) && $_GET['action'] === 'eliminar') {

    $id = $_GET['id'] ?? null;

    if ($id) {

        $sprint->delete((int)$id);

        header("Location: /taller_base_datos_monolitico/public/index.php");
        exit();
    }
}