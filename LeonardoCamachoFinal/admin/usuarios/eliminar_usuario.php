<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso denegado";
    exit();
}

require_once "../../classes/Usuario.php";
require_once "../procesar_usuario.php";

$con = conectar();
$usuario = new Usuario($con);

if (!isset($_GET['id'])) {
    echo "ID de usuario no especificado.";
    exit();
}

$id = intval($_GET['id']);
$datos = $usuario->obtenerPorId($id);

if (!$datos) {
    echo "Usuario no encontrado.";
    exit();
}

// Si se confirmó la eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($usuario->eliminar($id)) {
        header("Location: listar_usuarios.php");
        exit();
    } else {
        echo "Error al eliminar usuario.";
    }
}
?>

<h2>Eliminar Usuario</h2>
<p>¿Estás seguro de que deseas eliminar al usuario <strong><?= htmlspecialchars($datos['usuario']) ?></strong>?</p>

<form method="post">
    <button type="submit">Sí, eliminar</button>
    <a href="listar_usuarios.php">Cancelar</a>
</form>
