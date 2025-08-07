<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajería</title>
     <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="carta-icons.png">

</head>
<body>
    <?php
    if(!isset($_SESSION['idUsuario']) or $_SESSION['rol']!=2){
        
        echo "Acceso restringido";
        exit();
    }
    ?>
    

    <div class="container">
    <h1>Bienvenido <?= $_SESSION['nombre'] ?></h1>
<a href="logout.php"><button>Cerrar Sesión</button></a>
<h2>Menú</h2>
<ul>
    <li><a href="usuario/enviar.php">Enviar mensaje</a></li>
    <li><a href="usuario/bandeja_entrada.php">Ver mensajes recibidos</a></li>
    <li><a href="usuario/bandeja_salida.php">Ver mensajes enviados</a></li>
</ul>
    </div>
    
</body>
</html>