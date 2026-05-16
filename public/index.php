<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../models/Sprint.php';

$database = new Database();
$db = $database->connect();


$sprintModel = new Sprint($db);

require '../views/layout/header.php';


$page = $_GET['page'] ?? 'home';


if ($page === 'retros') {

    require '../views/retros/index.php';
    require '../views/layout/footer.php';

    exit();
}

/* AQUÍ PA EDITAR RETRO */

if ($page === 'edit-retro') {

    require '../views/retros/edit.php';
    require '../views/layout/footer.php';

    exit();
}

/* AQUI PA OBTENER SPRINTS UWU*/

$result = $sprintModel->getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h2>Lista de Sprints</h2>

<!-- AQUI CREAMOS SPRINT uwu-->

<h3>Crear Sprint</h3>

<form method="POST"
      action="/taller_base_datos_monolitico/controllers/SprintController.php">

    <input
        type="text"
        name="nombre"
        placeholder="Nombre del sprint"
        required>

    <input
        type="date"
        name="fecha_inicio"
        required>

    <input
        type="date"
        name="fecha_fin"
        required>

    <button type="submit">
        Crear Sprint
    </button>

</form>

<hr>

<ul>

<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>

    <li>

        <strong>
            <?= htmlspecialchars($row['nombre']) ?>
        </strong>

        (
            <?= htmlspecialchars($row['fecha_inicio']) ?>
            -
            <?= htmlspecialchars($row['fecha_fin']) ?>
        )

        <!-- VER RETROSPECTIVA UWU-->
        <a href="?page=retros&sprint_id=<?= $row['id'] ?>">
            Ver retrospectiva
        </a>

        <!-- AQUI PUES PA ELIMINAR SHJAGHDJAS -->
        <a href="../controllers/SprintController.php?action=eliminar&id=<?= $row['id'] ?>"
           onclick="return confirm('¿Seguro que quieres eliminar este sprint?')">

            🗑 Eliminar

        </a>

    </li>

<?php endwhile; ?>

</ul>

<?php require '../views/layout/footer.php'; ?>
</body>
</html>