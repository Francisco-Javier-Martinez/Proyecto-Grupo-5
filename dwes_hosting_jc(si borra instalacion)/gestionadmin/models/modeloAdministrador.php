<?php
    require_once __DIR__ .'/../models/conexion.php';

    class ModeloAdministrador extends Conexion{

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