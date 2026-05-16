<?php

require_once '../config/database.php';
require_once '../models/Sprint.php';

$database = new Database();
$db = $database->connect();

$sprint = new Sprint($db);

/* CREAR SPRINT */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';

    if (
        !empty($nombre) &&
        !empty($fecha_inicio) &&
        !empty($fecha_fin)
    ) {

        $sprint->setNombre($nombre);
        $sprint->setFechaInicio($fecha_inicio);
        $sprint->setFechaFin($fecha_fin);

        $sprint->create();
    }

    header("Location: /taller_base_datos_monolitico/public/index.php");
    exit();
}

/* ELIMINAR SPRINT */

if (
    isset($_GET['action']) &&
    $_GET['action'] === 'eliminar'
) {

    $id = $_GET['id'] ?? null;

    if ($id !== null) {

        $sprint->delete((int)$id);
    }

    header("Location: /taller_base_datos_monolitico/public/index.php");
    exit();
}