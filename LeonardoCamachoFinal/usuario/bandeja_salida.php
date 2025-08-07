<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 2) {
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";
require_once "../classes/Mensaje.php";

$con = conectar();
$msg = new Mensaje($con);
$mensajes = $msg->bandejaSalida($_SESSION['idUsuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bandeja de salida</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h2>Bandeja de salida</h2>

        <table class="tabla">
            <tr>
                <th>Para</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
            </tr>
            <?php while ($m = $mensajes->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($m['destinatario']) ?></td>
                    <td><?= htmlspecialchars($m['asunto']) ?></td>
                    <td><?= htmlspecialchars($m['mensaje']) ?></td>
                    <td><?= $m['fecha'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <a href="../usuario.php"><button>Volver</button></a>
    </div>
</body>
</html>
