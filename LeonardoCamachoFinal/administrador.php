<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajería</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="carta-icons.png">
</head>
<body>

<?php
if(!isset($_SESSION['idUsuario']) or $_SESSION['rol'] != 1){
    echo "Acceso restringido";
    exit();
}
?>

<div class="container">
    <h1>Bienvenido Administrador <?= $_SESSION['nombre'] ?></h1>
    <a href="logout.php"><button>Cerrar Sesión</button></a>

    <h2>Panel de mensajería</h2>
    <ul>
        <li><a href="admin/enviar.php">Enviar mensaje</a></li>
        <li><a href="admin/bandeja_entrada.php">Ver mensajes recibidos</a></li>
        <li><a href="admin/bandeja_salida.php">Ver mensajes enviados</a></li>
    </ul>

    <h2>Gestión de usuarios</h2>
    <ul>
        <li><a href="admin/usuarios/gestionar_usuarios.php">Panel de usuarios</a></li>
    </ul>
</div>

</body>
</html>
