<?php

require_once '../config/database.php';
require_once '../models/Sprint.php';

$database = new Database();
$db = $database->connect();

$sprintModel = new Sprint($db);

/* CREAR SPRINT */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {

    $sprintModel->nombre = $_POST['nombre'];
    $sprintModel->fecha_inicio = $_POST['fecha_inicio'];
    $sprintModel->fecha_fin = $_POST['fecha_fin'];

    $sprintModel->create();

    header('Location: ../public/index.php');
    exit();
}

/* ELIMINAR SPRINT */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_sprint_id'])) {

    $id = $_POST['delete_sprint_id'];

    $sprintModel->delete($id);

    header('Location: ../public/index.php');
    exit();
}