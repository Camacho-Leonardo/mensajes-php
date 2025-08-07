<?php
session_start();
if(!isset($_SESSION['idUsuario']) or $_SESSION['rol'] != 2){
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";
require_once "../classes/Mensaje.php";

$con = conectar();
$msg = new Mensaje($con);
$mensajes = $msg->bandejaEntrada($_SESSION['idUsuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bandeja de Entrada</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/png" href="../carta-icons.png">
</head>
<body>
    <div class="container">
        <h2>Bandeja de Entrada</h2>
        <table class="tabla">
            <tr>
                <th>De</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Feedback</th>
            </tr>
            <?php while($m = $mensajes->fetch_assoc()): ?>
                <tr class="<?= $m['estado'] == 1 ? 'leido' : 'no-leido' ?>">
                    <td><?= $m['remitente'] ?></td>
                    <td><?= $m['asunto'] ?></td>
                    <td><?= $m['mensaje'] ?></td>
                    <td><?= $m['fecha'] ?></td>
                    <td><a href="ver_mensaje.php?id=<?= $m['idMensaje'] ?>"><?= $m['asunto'] ?></a></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="../usuario.php"><button>Volver</button></a>
    </div>
</body>
</html>
