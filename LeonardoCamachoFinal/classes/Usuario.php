<?php
class Usuario {
    private $con;

    public function __construct($conexion) {
        $this->con = $conexion;
    }

    public function agregar($usuario, $pass, $rol) {
        $stmt = $this->con->prepare("SELECT idUsuario FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return "El nombre de usuario ya existe.";
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $this->con->prepare("INSERT INTO usuarios (usuario, pass, rol) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $usuario, $hash, $rol);
        return $stmt->execute() ? true : "Error al agregar.";
    }

    public function listar() {
        return $this->con->query("SELECT * FROM usuarios ORDER BY idUsuario DESC");
    }

    public function buscar($usuario) {
        $stmt = $this->con->prepare("SELECT * FROM usuarios WHERE usuario LIKE ?");
        $busqueda = "%$usuario%";
        $stmt->bind_param("s", $busqueda);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function obtenerPorId($id) {
        $stmt = $this->con->prepare("SELECT * FROM usuarios WHERE idUsuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function modificar($id, $usuario, $pass, $rol) {
        $stmt = $this->con->prepare("SELECT idUsuario FROM usuarios WHERE usuario = ? AND idUsuario != ?");
        $stmt->bind_param("si", $usuario, $id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return "Ya existe otro usuario con ese nombre.";
        }

        if ($pass != "") {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $this->con->prepare("UPDATE usuarios SET usuario = ?, pass = ?, rol = ? WHERE idUsuario = ?");
            $stmt->bind_param("ssii", $usuario, $pass, $rol, $id);
        } else {
            $stmt = $this->con->prepare("UPDATE usuarios SET usuario = ?, rol = ? WHERE idUsuario = ?");
            $stmt->bind_param("sii", $usuario, $rol, $id);
        }

        return $stmt->execute() ? true : "Error al modificar.";
    }

    public function eliminar($id) {
        $stmt = $this->con->prepare("DELETE FROM usuarios WHERE idUsuario = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
