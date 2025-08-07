<?php
class Mensaje {
    private $con;

    public function __construct($conexion) {
        $this->con = $conexion;
    }

    public function enviar($de, $paraUsuario, $asunto, $mensaje, $origen = 1) {
        // Buscar ID del destinatario
        $stmt = $this->con->prepare("SELECT idUsuario FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $paraUsuario);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 0) {
            return "Usuario destinatario no encontrado.";
        }

        $destinatario = $res->fetch_assoc()['idUsuario'];

        // Insertar mensaje
        $estado = 1; // No leído
        $stmt = $this->con->prepare("INSERT INTO mensajes (de, para, asunto, mensaje, origen, estado) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissii", $de, $destinatario, $asunto, $mensaje, $origen, $estado);
        $stmt->execute();

        return $stmt->affected_rows > 0 ? "Mensaje enviado." : "Error al enviar mensaje.";
    }

    public function bandejaEntrada($idUsuario) {
        $stmt = $this->con->prepare("SELECT m.idMensaje, u.usuario AS remitente, m.asunto, m.mensaje, m.fecha, m.estado 
                                     FROM mensajes m 
                                     JOIN usuarios u ON m.de = u.idUsuario 
                                     WHERE m.para = ? AND m.estado != 4
                                     ORDER BY m.fecha DESC");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function bandejaSalida($idUsuario) {
        $stmt = $this->con->prepare("SELECT m.idMensaje, u.usuario AS destinatario, m.asunto, m.mensaje, m.fecha 
                                     FROM mensajes m 
                                     JOIN usuarios u ON m.para = u.idUsuario 
                                     WHERE m.de = ? ORDER BY m.fecha DESC");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function marcarLeido($idMensaje) {
        $stmt = $this->con->prepare("UPDATE mensajes SET estado = 2 WHERE idMensaje = ?");
        $stmt->bind_param("i", $idMensaje);
        $stmt->execute();
    }
}
?>
