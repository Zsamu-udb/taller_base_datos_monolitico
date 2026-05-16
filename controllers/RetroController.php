<?php

require_once '../config/database.php';
require_once '../models/RetroItem.php';

/* NUESTRA CONEXIÓN JEJEJEJEJEJEE*/
$database = new Database();
$db = $database->connect();

/* MODELO JUAS*/
$retro = new RetroItem($db);

/* PETICIONES POST */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*CREAR ITEM juaas*/

    if (isset($_POST['descripcion']) && !isset($_POST['edit_id'])) {

        $retro->setSprintId((int) $_POST['sprint_id']);
        $retro->setCategoria($_POST['categoria']);
        $retro->setDescripcion($_POST['descripcion']);

        $retro->create();

        $sprint_id = $_POST['sprint_id'];
    }

    /*ACTUALIZAR ITEM JEJHWERHGFRE*/

    if (isset($_POST['edit_id'])) {

        $retro->setId((int) $_POST['edit_id']);
        $retro->setCategoria($_POST['categoria']);
        $retro->setDescripcion($_POST['descripcion']);

        $retro->update();

        $sprint_id = $_POST['sprint_id'];
    }


    if (isset($_POST['cumplir_id'])) {

        $retro->marcarCumplida((int) $_POST['cumplir_id']);

        $sprint_id = $_POST['sprint_id'];
    }


    if (isset($_POST['delete_id'])) {

        $retro->delete((int) $_POST['delete_id']);

        $sprint_id = $_POST['sprint_id'];
    }

    header("Location: /taller_base_datos_monolitico/public/index.php?page=retros&sprint_id=$sprint_id");

    exit();
}