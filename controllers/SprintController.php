<?php

require_once '../config/database.php';
require_once '../models/Sprint.php';

$db = (new Database())->connect();

$sprint = new Sprint($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $sprint->create($nombre, $fecha_inicio, $fecha_fin);

    header("Location: /taller_base_datos_monolitico/public/index.php");
    exit();
}