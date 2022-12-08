<?php

require '../comunes/auxiliar.php';

function insertar_alumno($codigo, $denominacion)
{
    $pdo = conectar();
    $sent = $pdo->prepare("INSERT
                             INTO alumnos (codigo, denominacion)
                           VALUES (:codigo, :denominacion)");
    $sent->execute([
        ':codigo' => $codigo,
        ':denominacion' => $denominacion,
    ]);
}

function validar_codigo_insertar($codigo, &$error)
{
    validar_digitos($codigo, 'codigo', $error);
    validar_longitud($codigo, 'codigo', 1, 4, $error);
    if (!isset($error['codigo'])) {
        validar_existe_codigo_alumno($codigo, $error);
    }
}

function validar_codigo_modificar($id, $codigo, $pdo, &$error)
{
    if(!mismo_codigo($id, $codigo, $pdo)){
        validar_digitos($codigo, 'codigo', $error);
        validar_longitud($codigo, 'codigo', 1, 4, $error);
        if (!isset($error['codigo'])) {
            validar_existe_codigo_alumno($codigo, $error);
        }
    }
}

function validar_existe_codigo_alumno($codigo, &$error): bool
{
    return validar_existe(
        'alumnos',
        'codigo',
        $codigo,
        'codigo',
        $error
    );
}

function validar_denominacion($denominacion, &$error)
{
    validar_longitud($denominacion, 'denominacion', 1, 255, $error);
}



function insertar_alumnos($par, $pdo)
{
    $columnas = implode(', ', array_keys($par));
    $marcadores = implode(', ', array_map(fn ($s) => ":$s", array_keys($par)));

    $sent = $pdo->prepare("INSERT INTO alumnos ($columnas)
                           VALUES ($marcadores)");
    $execute = [];
    foreach ($par as $k => $v) {
        $execute[":$k"] = $v;
    }
    $sent->execute($execute);
}


function mismo_codigo($id, $codigo, $pdo)
{
    $sent = $pdo->prepare("SELECT COUNT(*)
                             FROM alumnos
                            WHERE id = :id AND codigo = :codigo");
    $sent->execute([':id' => $id, ':codigo' => $codigo]);
    $total = $sent->fetchColumn();
    if ($total == 0) {
        return false;
    }
    return true;
}

function modificar_alumnos($codigo, $denominacion, $id, $pdo)
{
    $sent = $pdo->prepare("UPDATE alumnos 
                              SET codigo = :codigo,
                            denominacion = :denominacion
                              WHERE id = :id");

    $sent->execute([
        ':codigo' => $codigo,
        ':denominacion' => $denominacion,
        ':id' => $id,
    ]);
}
