<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 2) {
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver mensaje</title>
        <link rel="icon" type="image/png" href="../carta-icons.png">

    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h2>Mensaje de <?= $m['remitente'] ?></h2>

        <p><strong>Asunto:</strong> <?= htmlspecialchars($m['asunto']) ?></p>
        <p><strong>Mensaje:</strong><br><?= nl2br(htmlspecialchars($m['mensaje'])) ?></p>
        <p><strong>Fecha:</strong> <?= $m['fecha'] ?></p>

        <div class="button-group">
            <a href="responder.php?id=<?= $idMensaje ?>"><button>Responder</button></a>
            <a href="reenviar.php?id=<?= $idMensaje ?>"><button>Reenviar</button></a>
            <a href="eliminar.php?id=<?= $idMensaje ?>" onclick="return confirm('¿Seguro que deseas eliminar este mensaje?')"><button>Eliminar</button></a>
            <a href="bandeja_entrada.php"><button>Volver</button></a>
        </div>
    </div>
</body>
</html>
