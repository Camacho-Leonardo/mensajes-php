-- Eliminar la base anterior si existe
-- DROP DATABASE IF EXISTS leonardocamachotp;

-- Crear base de datos
CREATE DATABASE leonardocamachotp;
USE leonardocamachotp;

-- Crear tabla de roles
CREATE TABLE roles (
    id TINYINT(4) PRIMARY KEY,
    rol VARCHAR(30)
);

-- Crear tabla de usuarios
CREATE TABLE usuarios (
    idUsuario INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30),
    apellido VARCHAR(30),
    usuario VARCHAR(30) UNIQUE,
    pass VARCHAR(30),
    rol TINYINT(4),
    FOREIGN KEY (rol) REFERENCES roles(id)
);

-- Crear tabla de estados
CREATE TABLE estados (
    id TINYINT(4) PRIMARY KEY,
    estado VARCHAR(30)
);

-- Crear tabla de mensajes
CREATE TABLE mensajes (
    idMensaje INT(11) AUTO_INCREMENT PRIMARY KEY,
    de INT(11),
    para INT(11),
    asunto VARCHAR(40),
    mensaje VARCHAR(500),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    origen INT(11),
    estado TINYINT(4),
    FOREIGN KEY (de) REFERENCES usuarios(idUsuario),
    FOREIGN KEY (para) REFERENCES usuarios(idUsuario),
    FOREIGN KEY (estado) REFERENCES estados(id)
);

-- Insertar datos de ejemplo
-- ROLES
INSERT INTO roles VALUES 
(1, 'administrador'),
(2, 'usuario');

-- USUARIOS
INSERT INTO usuarios VALUES 
(NULL, 'Leonardo','Camacho','Leonardosky','123456',1),
(NULL, 'Diela','LeonaD','Diela_','123456',2),
(NULL, 'Rafa','Gomez','ElRafael','123456',2),
(NULL, 'Sandia','Diver','SeniorSandia','123456',2);

-- ESTADOS
INSERT INTO estados VALUES 
(1, 'No leído'),
(2, 'Leído'),
(3, 'Archivado'),
(4, 'Eliminado');

-- Consulta para verificar datos
SELECT * FROM usuarios;
