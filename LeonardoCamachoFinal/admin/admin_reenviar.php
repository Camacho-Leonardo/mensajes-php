<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso restringido";
    exit();
}

require_once "../conexion.php";
require_once "../classes/Mensaje.php";

if (!isset($_GET['id'])) {
    echo "Mensaje no encontrado.";
    exit();
}

$con = conectar();
$idMensaje = intval($_GET['id']);

// Obtener datos para reenviar
$stmt = $con->prepare("SELECT * FROM mensajes WHERE idMensaje = ?");
$stmt->bind_param("i", $idMensaje);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    echo "Mensaje no encontrado.";
    exit();
}

$m = $res->fetch_assoc();
$asunto = (str_starts_with($m['asunto'], 'FWD:')) ? $m['asunto'] : 'FWD: ' . $m['asunto'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $msg = new Mensaje($con);
    $respuesta = $msg->enviar($_SESSION['idUsuario'], $_POST['para'], $_POST['asunto'], $_POST['mensaje']);
    echo $respuesta . "<br><a href='bandeja_entrada.php'>Volver</a>";
    exit();
}
?>

<h2>Reenviar mensaje</h2>
<form method="post">
    Usuario destino: <input type="text" name="para" required><br>
    Asunto: <input type="text" name="asunto" value="<?= htmlspecialchars($asunto) ?>" required><br>
    Mensaje original:<br>
    <textarea name="mensaje" required><?= htmlspecialchars($m['mensaje']) ?></textarea><br>
    <input type="submit" value="Reenviar">
</form>
