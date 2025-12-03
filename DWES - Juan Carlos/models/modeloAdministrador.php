<?php
    include "conexion.php";

    class ModeloAdministrador extends Conexion{
        
        function introducirSuperAdmin($nombre, $contrasenia, $email, $tipo){
            $sql= "INSERT INTO usuarios (nombre, contrasenia, email, tipo) VALUES(:nombre, :contrasenia, :email, :tipo)";
             // Preparamos la consulta con PDO;
            $preparacion=$this->conexion->prepare($sql);

            // Ejecutamos la consulta pasando un array asociativo con los valores reales
            // Los placeholders :nombre, :contrasenia, :email, :tipo se reemplazan por los valores reales pasados por parámetros
            // Devuelve true si la inserción fue correcta, false si falló
            return $preparacion->execute([
                ':nombre' => $nombre,
                ':contrasenia' => $contrasenia,
                ':email' => $email,
                ':tipo' => $tipo
            ]);
        }

        function iniciarSesion($email){
            $sql= "SELECT * FROM usuarios WHERE email= :email";
             // Preparamos la consulta con PDO;
            $preparacion=$this->conexion->prepare($sql);

            $preparacion->execute([
                ':email' => $email,
            ]);
            
            $resultado = $preparacion->fetch(PDO::FETCH_ASSOC);//devuelve un array asociativo con los nombres de columna como claves
            return $resultado; /*Si no hay resultados return TRUE*/
        }
    }
?>