<?php
$usuario=$_POST['usuario'];
$contra=$_POST['pass'];

try{
    require "conexion.php";
    $con=conectar();
    $sql="select * from usuarios where usuario='$usuario';";
    $res=mysqli_query($con,$sql);
    if(mysqli_affected_rows($con)>0){
        $user=mysqli_fetch_assoc($res);
        if($user['pass']==$contra){
            session_start();
            $_SESSION['idUsuario']=$user['idUsuario'];
            $_SESSION['nombre']=$user['nombre']." ".$user['apellido'];
            $_SESSION['usuario']=$user['usuario'];
            $_SESSION['rol']=$user['rol'];
            $_SESSION['hora_inicio'] = time();

            //setear time zone

            switch($_SESSION['rol']){

                case 1:
                    header("Location: administrador.php");
                    break;
                case 2:
                    header("Location: usuario.php");
                    break;
                
                default:
                header("Location: index.php");
                break;
            }




        }else{
            header("Location: index.php?failedPass");
        }

    }else{
        header("Location:index.php?noUsu=$usuario");
    }
    

}catch(Throwable $e){
    echo "Error".$e->getMessage();
    exit();
}

?>