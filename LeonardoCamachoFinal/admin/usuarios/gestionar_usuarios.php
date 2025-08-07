<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso restringido";
    exit();
}
?>
<h2>Panel de Gestión de Usuarios</h2>

<?php if (isset($_GET['msg'])): ?>
<p><?= htmlspecialchars($_GET['msg']) ?></p>
<?php endif; ?>

<ul>
    <li><a href="agregar_usuario.php">Agregar usuario</a></li>
    <li><a href="listar_usuarios.php">Listar todos</a></li>
    <li><a href="buscar_usuario.php">Buscar usuario</a></li>
</ul>
<a href="../../administrador.php">Volver</a>
