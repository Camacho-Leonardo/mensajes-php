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
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $resultado = $user->buscar($_POST['usuario']);
}
?>

<h3>Buscar Usuario</h3>
<form method="POST">
    Nombre de usuario: <input type="text" name="usuario">
    <button type="submit">Buscar</button>
</form>

<?php if ($resultado): ?>
<table border="1">
    <tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Acciones</th></tr>
    <?php while($u = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?= $u['idUsuario'] ?></td>
        <td><?= htmlspecialchars($u['usuario']) ?></td>
        <td><?= $u['rol'] == 1 ? 'Administrador' : 'Usuario' ?></td>
        <td>
            <a href="modificar_usuario.php?id=<?= $u['idUsuario'] ?>">Modificar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php endif; ?>

<a href="gestionar_usuarios.php">Volver</a>
