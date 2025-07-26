create database leonardocamachotp;
use leonardocamachotp;



-- Tablas
create table roles(
rol tinyint primary key,
descripcion varchar(20));

create table usuarios(
id int auto_increment primary key,
nombre varchar(20),
apellido varchar(20),
usuario varchar(20),
pass varchar(20),
unique(usuario),
rol tinyint,
foreign key(rol) references roles(rol));

-- Insertar datos a tablas
-- ROLES
insert into roles values(1,"administrador"),(2,"usuario");

-- USUARIOS
insert into usuarios values 
(null, "Leonardo","Camacho","Leonardosky","123456",1),
(null, "Diela","LeonaD","Diela_","123456",2),
(null, "Rafa","Gomez","ElRafael","123456",2),
(null, "Sandia","Diver","SeniorSandia","123456",2);

-- VER DATOS CARGADOS
select * from usuarios;