<?php 

function conectar(){
try{
    $ser="localhost";
    $usr="root";
    $pass="";
    $bd="leonardocamachotp";

    $con=mysqli_connect($ser,$usr,$pass,$bd);
    mysqli_set_charset($con,"utf8");
    return $con;
}catch(Throwable $e){
    echo "Problema de conexión, intente más tarde";
    ?><a href="index.php"><button>Volver</button></a><?php
    exit();
}


}


?>