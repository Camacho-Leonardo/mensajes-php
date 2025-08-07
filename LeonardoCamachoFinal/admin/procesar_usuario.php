<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";
require_once "../classes/Usuario.php";

$con = conectar();
$user = new Usuario($con);

$accion = $_POST['accion'] ?? '';

if ($accion === "agregar") {
    $res = $user->agregar($_POST['usuario'], $_POST['pass'], $_POST['rol']);
    header("Location: usuarios/gestionar_usuarios.php?msg=" . urlencode($res === true ? "Usuario agregado" : $res));
}

if ($accion === "modificar") {
    $res = $user->modificar($_POST['id'], $_POST['usuario'], $_POST['pass'], $_POST['rol']);
    header("Location: usuarios/gestionar_usuarios.php?msg=" . urlencode($res === true ? "Usuario modificado" : $res));
}

if ($accion === "eliminar") {
    $user->eliminar($_POST['id']);
    header("Location: usuarios/gestionar_usuarios.php?msg=" . urlencode("Usuario eliminado"));
}
