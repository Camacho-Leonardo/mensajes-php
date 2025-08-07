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
$mensajes = $msg->bandejaEntrada($_SESSION['idUsuario']);
?>

<h2>Bandeja de Entrada</h2>
<table border="1">
    <tr><th>De</th><th>Asunto</th><th>Mensaje</th><th>Fecha</th><th>Feedback</th></tr>
    <?php while($m = $mensajes->fetch_assoc()): ?>
        <tr style="background-color:
            <?= $m['estado'] == 1 ? 'lightgreen' : 'khaki' ?>;">
            <td><?= $m['remitente'] ?></td>
            <td><?= $m['asunto'] ?></td>
            <td><?= $m['mensaje'] ?></td>
            <td><?= $m['fecha'] ?></td>
            <td><a href="admin_ver_mensaje.php?id=<?= $m['idMensaje'] ?>"><?= $m['asunto'] ?></a></td>

        </tr>
    <?php endwhile; ?>
</table>
<a href="../administrador.php">Volver</a>
