<?php
    require_once "instalacionSuperAdministrador.php";

    $objAdmin = new IntroducirSuperAdministrador;
    if(!empty($_POST['email']) && !empty($_POST['nombre']) && !empty($_POST['password'])){
        $email=$_POST['email'];
        $nombre=$_POST['nombre'];
        $password=$_POST['password'];
        $tipo=$_GET['tipo'];
        
        $passwordEncript=password_hash($password, PASSWORD_DEFAULT);
        $resultado=$objAdmin->introducirSuperAdmin($nombre, $passwordEncript, $email,  $tipo);
        if($resultado){
            $mensaje= "ADMINISTRADOR INTRODUCIDO CORRECTAMENTE";
        }else{
            $mensaje= "ERROR AL INTRODUCIR EL SUPERADMINISTRADOR";
        }
    }else{
        $mensaje= "ERROR, FALTAN DATOS OBLIGATORIOS";
    }
    header("Location: index.php?mensaje=".$mensaje);

?>