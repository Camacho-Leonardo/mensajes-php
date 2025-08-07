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

// Obtener datos para armar respuesta
$stmt = $con->prepare("SELECT m.*, u.usuario AS remitente FROM mensajes m 
                       JOIN usuarios u ON m.de = u.idUsuario 
                       WHERE m.idMensaje = ?");
$stmt->bind_param("i", $idMensaje);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    echo "Mensaje no encontrado.";
    exit();
}

$m = $res->fetch_assoc();
$asunto = (str_starts_with($m['asunto'], 'RE:')) ? $m['asunto'] : 'RE: ' . $m['asunto'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $msg = new Mensaje($con);
    $respuesta = $msg->enviar($_SESSION['idUsuario'], $m['remitente'], $_POST['asunto'], $_POST['mensaje']);
    echo $respuesta . "<br><a href='bandeja_entrada.php'>Volver</a>";
    exit();
}
?>

<h2>Responder a <?= $m['remitente'] ?></h2>
<form method="post">
    Asunto: <input type="text" name="asunto" value="<?= htmlspecialchars($asunto) ?>" required><br>
    Mensaje:<br>
    <textarea name="mensaje" required></textarea><br>
    <input type="submit" value="Enviar respuesta">
</form>
