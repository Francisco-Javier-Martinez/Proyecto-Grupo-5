<?php
    require_once __DIR__ .'/../models/conexion.php';
    
    class ModeloTemas extends Conexion{
        
        function listarTemas($idUsuario){
            $sql= "SELECT * FROM tema where idUsuario= :idUsuario";
            // Preparamos la consulta con PDO
            $preparacion=$this->conexion->prepare($sql);
            $preparacion->bindValue(':idUsuario', (int)$idUsuario, PDO::PARAM_INT);
            $preparacion->execute();
            $resultado = $preparacion->fetchAll(PDO::FETCH_ASSOC);//devuelve un array asociativo con los datos

            return $resultado; /*Si no hay resultados return TRUE*/
        }

        function crearTema($nombre, $publico, $abreviatura, $descripcion, $idUsuario){
            $sql= "INSERT INTO tema (nombre, publico, abreviatura, descripcion, idUsuario) VALUES(:nombre, :publico, :abreviatura, :descripcion, :idUsuario)";
            // Preparamos la consulta con PDO;
            $preparacion=$this->conexion->prepare($sql);

            // Los placeholders :nombre, :contrasenia, :email, :tipo se reemplazan por los valores reales pasados por parámetros. Se dice su tipo de dato

            $preparacion->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $preparacion->bindValue(':publico', (int)$publico, PDO::PARAM_INT); // forzamos a entero
            $preparacion->bindValue(':abreviatura', $abreviatura, PDO::PARAM_STR);
            $preparacion->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $preparacion->bindValue(':idUsuario', (int)$idUsuario, PDO::PARAM_INT); // también entero

            /*la ejecución*/
            $preparacion->execute();

            if ($preparacion->rowCount() > 0) {
                return $this->conexion->lastInsertId();
            } else {
                return false;
            }
        }

        function obtenerTema($idTema){
            $sql="SELECT * FROM tema WHERE idTema = :idTema";
            $preparacion=$this->conexion->prepare($sql);

            $preparacion->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT);

            $preparacion->execute();
            
            $resultado= $preparacion->fetch(PDO::FETCH_ASSOC);

            return $resultado;
        }

        function modificarTema($nombre, $publico, $abreviatura, $descripcion, $idUsuario, $idTema){
            $sql="UPDATE tema
                SET nombre = :nombre,
                    descripcion = :descripcion,
                    publico= :publico,
                    abreviatura= :abreviatura,
                    idUsuario = :idUsuario
                WHERE idTema=:idTema";
                $preparacion=$this->conexion->prepare($sql);

            $preparacion->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $preparacion->bindValue(':publico', (int)$publico, PDO::PARAM_INT); // forzamos a entero
            $preparacion->bindValue(':abreviatura', $abreviatura, PDO::PARAM_STR);
            $preparacion->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $preparacion->bindValue(':idUsuario', (int)$idUsuario, PDO::PARAM_INT); // también entero
            $preparacion->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT); // también entero

            return $preparacion->execute(); /*TRUE O FALSE*/
        }

        function eliminarTema($idTema){
            $sql="DELETE FROM tema WHERE idTema=:idTema";
            
            $preparacion=$this->conexion->prepare($sql);
            $preparacion->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT); //entero

            return $preparacion->execute(); /*BOOLEANO*/
        }
    }
?>