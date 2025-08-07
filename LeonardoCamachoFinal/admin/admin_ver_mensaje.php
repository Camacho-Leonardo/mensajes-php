<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";
require_once "../classes/Mensaje.php";

if (!isset($_GET['id'])) {
    echo "Mensaje no encontrado.";
    exit();
}

$idMensaje = intval($_GET['id']);
$con = conectar();
$msg = new Mensaje($con);

// Marcar como leído
$msg->marcarLeido($idMensaje);

// Obtener datos del mensaje
$stmt = $con->prepare("SELECT m.*, u.usuario AS remitente FROM mensajes m 
                       JOIN usuarios u ON m.de = u.idUsuario 
                       WHERE m.idMensaje = ? AND m.para = ?");
$stmt->bind_param("ii", $idMensaje, $_SESSION['idUsuario']);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    echo "Mensaje no disponible.";
    exit();
}

$m = $res->fetch_assoc();
?>

<h2>Mensaje de <?= htmlspecialchars($m['remitente']) ?></h2>
<p><strong>Asunto:</strong> <?= htmlspecialchars($m['asunto']) ?></p>
<p><strong>Mensaje:</strong><br><?= nl2br(htmlspecialchars($m['mensaje'])) ?></p>
<p><strong>Fecha:</strong> <?= $m['fecha'] ?></p>

<a href="admin_responder.php?id=<?= $idMensaje ?>">Responder</a> |
<a href="admin_reenviar.php?id=<?= $idMensaje ?>">Reenviar</a> |
<a href="admin_eliminar.php?id=<?= $idMensaje ?>" onclick="return confirm('¿Seguro que deseas eliminar este mensaje?')">Eliminar</a> |
<a href="bandeja_entrada.php">Volver</a>
