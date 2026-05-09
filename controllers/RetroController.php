<?php

require_once '../config/database.php';
require_once '../models/RetroItem.php';

$db = (new Database())->connect();

$retro = new RetroItem($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['descripcion']) && !isset($_POST['edit_id'])) {

        $retro->sprint_id = $_POST['sprint_id'];
        $retro->categoria = $_POST['categoria'];
        $retro->descripcion = $_POST['descripcion'];

        $retro->create();

        $sprint_id = $_POST['sprint_id'];
    }


    if (isset($_POST['edit_id'])) {

        $retro->update(
            $_POST['edit_id'],
            $_POST['categoria'],
            $_POST['descripcion']
        );

        $sprint_id = $_POST['sprint_id'];
    }


    if (isset($_POST['cumplir_id'])) {

        $retro->marcarCumplida($_POST['cumplir_id']);

        $sprint_id = $_POST['sprint_id'];
    }


    if (isset($_POST['delete_id'])) {

        $retro->delete($_POST['delete_id']);

        $sprint_id = $_POST['sprint_id'];
    }

    header("Location: /taller_base_datos_monolitico/public/index.php?page=retros&sprint_id=$sprint_id");

    exit();
}
