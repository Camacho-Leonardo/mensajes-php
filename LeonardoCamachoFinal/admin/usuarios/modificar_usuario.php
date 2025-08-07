<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso restringido";
    exit();
}
require_once "../../conexion.php";
require_once "../../classes/Usuario.php";
$con = conectar();
$user = new Usuario($con);

$id = $_GET['id'] ?? 0;
$usuario = $user->obtenerPorId($id);
if (!$usuario) {
    echo "Usuario no encontrado.";
    exit();
}
?>
<h3>Modificar usuario</h3>
<form action="../procesar_usuario.php" method="POST">
    <input type="hidden" name="accion" value="modificar">
    <input type="hidden" name="id" value="<?= $usuario['idUsuario'] ?>">
    Usuario: <input type="text" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required><br>
    Pass nueva (dejar vacío para no cambiar): <input type="password" name="pass"><br>
    Rol:
    <select name="rol">
        <option value="1" <?= $usuario['rol']==1 ? 'selected' : '' ?>>Administrador</option>
        <option value="2" <?= $usuario['rol']==2 ? 'selected' : '' ?>>Usuario</option>
    </select><br>
    <button type="submit">Guardar cambios</button>
</form>
<a href="gestionar_usuarios.php">Volver</a>
