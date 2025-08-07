<?php
session_start();
if(!isset($_SESSION['idUsuario']) or $_SESSION['rol']!=1){
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";
require_once "../classes/Mensaje.php";

$con = conectar();
$msg = new Mensaje($con);
$mensajes = $msg->bandejaSalida($_SESSION['idUsuario']);
?>

<h2>Bandeja de salida</h2>
<table border="1">
    <tr><th>Para</th><th>Asunto</th><th>Mensaje</th><th>Fecha</th></tr>
    <?php while($m = $mensajes->fetch_assoc()): ?>
        <tr>
            <td><?= $m['destinatario'] ?></td>
            <td><?= $m['asunto'] ?></td>
            <td><?= $m['mensaje'] ?></td>
            <td><?= $m['fecha'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="../administrador.php">Volver</a>
