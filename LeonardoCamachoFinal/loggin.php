<?php
$usuario=$_POST['usuario'];
$contra=$_POST['pass'];

try{
    require "conexion.php";

}catch(Throwable $e){
    echo "Error".$e;
    exit();
}

?>