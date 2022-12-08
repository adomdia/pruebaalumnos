<?php
session_start();

require 'auxiliar.php';

$id = obtener_post('id');

if (!comprobar_csrf()) {
    return volver_alumnos();
}

if (!isset($id)) {
    return volver_alumnos();
}



$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE alumnos IN SHARE MODE');
$sent = $pdo->prepare("DELETE FROM alumnos WHERE id = :id");
$sent->execute([':id' => $id]);
$_SESSION['mensaje'] = 'El departamento se ha borrado correctamente';
$pdo->commit();
volver_alumnos();
