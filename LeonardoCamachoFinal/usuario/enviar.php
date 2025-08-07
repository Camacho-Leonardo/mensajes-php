<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 2) {
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";
require_once "../classes/Mensaje.php";

$enviado = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = conectar();
    $msg = new Mensaje($con);
    $enviado = $msg->enviar($_SESSION['idUsuario'], $_POST['para'], $_POST['asunto'], $_POST['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar mensaje</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h2>Enviar mensaje</h2>

        <form method="post">
            Usuario destino:<br>
            <input type="text" name="para" required><br>

            Asunto:<br>
            <input type="text" name="asunto" required><br>

            Mensaje:<br>
            <textarea name="mensaje" rows="5" cols="30" required></textarea><br>

            <input type="submit" value="Enviar">
        </form>

        <p><?= $enviado ?></p>

        <a href="../usuario.php"><button>Volver</button></a>
    </div>
</body>
</html>
