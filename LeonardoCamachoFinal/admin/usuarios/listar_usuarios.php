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
$usuarios = $user->listar();
?>

<h3>Listado de Usuarios</h3>
<table border="1">
    <tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Acciones</th></tr>
    <?php while($u = $usuarios->fetch_assoc()): ?>
    <tr>
        <td><?= $u['idUsuario'] ?></td>
        <td><?= htmlspecialchars($u['usuario']) ?></td>
        <td><?= $u['rol'] == 1 ? 'Administrador' : 'Usuario' ?></td>
        <td>
            <a href="modificar_usuario.php?id=<?= $u['idUsuario'] ?>">Modificar</a> |
            <form action="../procesar_usuario.php" method="POST" style="display:inline">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="id" value="<?= $u['idUsuario'] ?>">
                <button onclick="return confirm('¿Eliminar?')">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="gestionar_usuarios.php">Volver</a>
