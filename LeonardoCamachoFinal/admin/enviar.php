<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
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

<h2>Enviar mensaje</h2>
<form method="post">
    Usuario destino: <input type="text" name="para" required><br>
    Asunto: <input type="text" name="asunto" required><br>
    Mensaje:<br>
    <textarea name="mensaje" required></textarea><br>
    <input type="submit" value="Enviar">
</form>
<p><?= $enviado ?></p>
<a href="../administrador.php">Volver</a>
