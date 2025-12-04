<?php
    include "conexion.php";
    class IntroducirSuperAdministrador extends Conexion{
        function introducirSuperAdmin($nombre, $contrasenia, $email, $tipo){
            try{
                $sql= "INSERT INTO usuarios (nombre, contrasenia, email, tipo) VALUES(:nombre, :contrasenia, :email, :tipo)";
                // Preparamos la consulta con PDO;
                $preparacion=$this->conexion->prepare($sql);

                //PONEMOS EN PREPARACIÓN LOS VALORES. INDICAMOS EL TIPO DE DATO
                $preparacion->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $preparacion->bindValue(':contrasenia', $contrasenia, PDO::PARAM_STR); // forzamos a entero
                $preparacion->bindValue(':email', $email, PDO::PARAM_STR);
                $preparacion->bindValue(':tipo', $tipo, PDO::PARAM_STR);

                return $preparacion->execute();

            }catch(PDOException $e){
                return false;
            }
        }
    }
    

?>