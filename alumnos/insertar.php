<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo alumnos</title>
    <style>
        .error {
            font-size: small;
            color: red;
        }

        .campo-error {
            color: red;
            border-color: red;
        }
    </style>
</head>
<body>
    <?php
    require 'auxiliar.php';

    const PAR = [
        'codigo',
        'denominacion',
    ];

    $par = obtener_parametros(PAR, $_POST);
    extract($par);

    $pdo = conectar();
    $error = [];

    if (comprobar_parametros($par)) {
        validar_codigo_insertar($codigo, $error);
        validar_denominacion($denominacion, $error);
        if (!hay_errores($error)) {
            insertar_alumnos($par, $pdo);
            return volver_alumnos();
        }
    }



    

    cabecera();
    ?>
    <div>
        <form action="" method="post">
            <?php token_csrf() ?>
            <div>
                <label <?= css_campo_error('codigo', $error) ?>>
                    Código:
                    <input type="text" name="codigo" size="10"
                    value="<?= $codigo ?>"
                    <?= css_campo_error('codigo', $error) ?>
                    >
                </label>
                <?php mostrar_errores('codigo', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('denominacion', $error) ?>>
                    Denominación:
                    <input type="text" name="denominacion"
                    value="<?= $denominacion ?>"
                    <?= css_campo_error('denominacion', $error) ?>
                    >
                </label>
                <?php mostrar_errores('denominacion', $error) ?>
            </div>
            <div>
                <button type="submit">Insertar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
