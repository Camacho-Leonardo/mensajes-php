<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajería</title>
    <link rel="icon" type="image/png" href="carta-icons.png">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Inicio de Sesión</h1>
    <form method="post" action="loggin.php">
    <input type="text" name="usuario" placeholder="Ingrese Usuario" maxlength="20" required><br>
    <input type="password" name="pass" placeholder="Contraseña" required><br>
    <input type="submit" value="Iniciar Sesion">
    </form>

    <?php 
    if(isset($_GET['noUsu'])){
        echo "No se encontró el usuario ".$_GET['noUsu'];
    }
    if(isset($_GET['failedPass'])){
        echo "Contraseña Incorrecta";
    }
    
    ?>

</body>
</html>

 