<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../models/Sprint.php';

$db = (new Database())->connect();

require '../views/layout/header.php';

$sprintModel = new Sprint($db);

$page = $_GET['page'] ?? null;

/* RETROSPECTIVA */
if ($page === 'retros') {
    require '../views/retros/index.php';
    require '../views/layout/footer.php';
    exit();
}

/* EDITAR ITEM */
if ($page === 'edit-retro') {
    require '../views/retros/edit.php';
    require '../views/layout/footer.php';
    exit();
}

/* LISTAR SPRINTS */
$result = $sprintModel->getAll();

?>

<h1>Lista de Sprints</h1>

<!-- FORM CREAR SPRINT -->
<h3>Crear Sprint</h3>

<form method="POST" action="/taller_base_datos_monolitico/controllers/SprintController.php">

    <input
        type="text"
        name="nombre"
        placeholder="Nombre del sprint"
        required
    >

    <input
        type="date"
        name="fecha_inicio"
        required
    >

    <input
        type="date"
        name="fecha_fin"
        required
    >

    <button type="submit">
        Crear Sprint
    </button>

</form>

<hr>

<ul>

<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>

    <li>

        <strong><?= $row['nombre'] ?></strong>

        (<?= $row['fecha_inicio'] ?> - <?= $row['fecha_fin'] ?>)

        <a href="?page=retros&sprint_id=<?= $row['id'] ?>">
            Ver retrospectiva
        </a>

    </li>

<?php endwhile; ?>

</ul>

<?php require '../views/layout/footer.php'; ?>