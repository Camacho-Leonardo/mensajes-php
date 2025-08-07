<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";

if (!isset($_GET['id'])) {
    echo "Mensaje no encontrado.";
    exit();
}

$id = intval($_GET['id']);
$con = conectar();

// Solo puede eliminar si es destinatario
$stmt = $con->prepare("UPDATE mensajes SET estado = 4 WHERE idMensaje = ? AND para = ?");
$stmt->bind_param("ii", $id, $_SESSION['idUsuario']);
$stmt->execute();

echo "Mensaje eliminado.<br><a href='bandeja_entrada.php'>Volver</a>";
