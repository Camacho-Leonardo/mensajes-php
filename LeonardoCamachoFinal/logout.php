<?php
session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['hora_inicio'])) {
    $usuario = $_SESSION['usuario'];
    $hora_inicio = $_SESSION['hora_inicio'];
    $hora_fin = time();

    $duracion = $hora_fin - $hora_inicio;
    $minutos = floor($duracion / 60);
    $segundos = $duracion % 60;

    date_default_timezone_set('America/Argentina/Buenos_Aires'); 
    $fecha = date("Y-m-d H:i:s");

    $registro = "$usuario | Fecha: $fecha | Tiempo conectado: ";
    $registro .= ($minutos < 1) ? "$segundos segundos" : "$minutos minutos y $segundos segundos";
    $registro .= PHP_EOL;

    file_put_contents("accesos.txt", $registro, FILE_APPEND);
}

$mensaje = "Hasta pronto " . ($_SESSION['nombre'] ?? 'usuario desconocido');
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sesión finalizada</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="carta-icons.png">
</head>
<body>
    <div class="container">
        <h1><?= $mensaje ?></h1>
        <p>Sesión Finalizada</p>
        <a href="index.php"><button>Volver a iniciar</button></a>
    </div>
</body>
</html>
