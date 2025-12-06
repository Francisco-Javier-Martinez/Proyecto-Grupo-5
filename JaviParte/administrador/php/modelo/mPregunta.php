<?php
    require_once 'conexion.php';
    require_once __DIR__ . '/../../../config/configRT.php';
    class mPregunta extends Conexion{
        public function meterPreguntas($idTema, $nPregunta, $nombreImagen){
            try{
                //transacion para asegurar que si falla una parte no se inserte nada
                $this->conexion->beginTransaction();
                // Validar límite de 10 preguntas por tema
                /* if($nPregunta > 15){
                    $this->mensaje = "No se pueden insertar mas de 10 preguntas por tema";
                    return $this->mensaje;
                } */

                // Recoger datos del formulario
                $titulo = $_POST['titulo'];
                $explicacion = $_POST['explicacionPregunta'];
                $puntuacion = $_POST['puntuacion'];

                // Preparar consulta
                $sql = "INSERT INTO preguntas (idTema, nPregunta, titulo, explicacion, imagen, puntuacion) 
                VALUES (:idTema, :nPregunta, :titulo, :explicacion, :imagen, :puntuacion)";
                $stmt = $this->conexion->prepare($sql);
                // Vincular parametros
                $stmt->bindParam(':idTema', $idTema, PDO::PARAM_INT);
                $stmt->bindParam(':nPregunta', $nPregunta, PDO::PARAM_INT);
                $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
                $stmt->bindParam(':explicacion', $explicacion, PDO::PARAM_STR);
                $stmt->bindParam(':imagen', $nombreImagen, PDO::PARAM_STR);
                $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
                // Ejecutar consulta
                $stmt->execute();
                //el commmit lo que hace es confirmar la transaccion
                $this->conexion->commit();
                if($stmt->rowCount()>0){
                    return $nPregunta;
                }else{
                    $this->mensaje = "Error al insertar la pregunta";
                    return $this->mensaje;
                }
            }catch(PDOException $e){
                //si hay error hago rollback para que no se inserte nada
                $this->conexion->rollBack();
                $this->mensaje = 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensaje;
            }
        }
        //metodo para sacar el numero de la siguiente pregunta
        public function sacarNpregunta($idTema){
            try{
                // Obtener el máximo nPregunta existente y sumar 1 para evitar reusar números en huecos
                $sql = "SELECT MAX(nPregunta) AS maxN FROM preguntas WHERE idTema=:idTema";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':idTema', $idTema);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if($resultado && $resultado['maxN'] !== null){
                    return (int)$resultado['maxN'] + 1;
                }else{
                    return 1; // si no hay preguntas devuelvo 1
                }
            }catch(PDOException $e){
                $this->mensaje = 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensaje;
            }
        }

    public function sacarNombrePregunta($idTema){
        try{
            // Devolver información completa de la pregunta para mostrar en la vista
            //voy a ordenar por nPregunta ascendente para que se muestren en orden por si acaso que avece s no se muestran en orden
            $sql="SELECT * FROM preguntas WHERE idTema=:idTema ORDER BY nPregunta ASC"; 
            $stmt=$this->conexion->prepare($sql);
            $stmt->bindParam(':idTema', $idTema);
            $stmt->execute();
            $resultado=$stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll para devolver todas las filas y fetch para una sola fila
            //si hay resultados los devuelvo
            if($resultado){
                return $resultado;
            }else{
                //si no hay resultados devuelvo false
                return false;
            }
        }catch(PDOException $e){
            $this->mensaje='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            return $this->mensaje;
        }
    }
    //borrar una pregunta si se borrar una pregunta se borran tambien sus respuestas por la fk con on delete cascade
    public function borrarPregunta($idTema, $nPregunta){
        try{
            $sql="DELETE FROM preguntas WHERE idTema=:idTema AND nPregunta=:nPregunta";
            $stmt=$this->conexion->prepare($sql);
            $stmt->bindParam(':idTema', $idTema);
            $stmt->bindParam(':nPregunta', $nPregunta);
            $stmt->execute();
            if($stmt->rowCount()>0){
                return true;
            }else{
                $this->mensaje="No se encontró la pregunta para borrar";
                return false;
            }
        }catch(PDOException $e){
            $this->mensaje='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            return false;
        }
    }

    public function modificarPregunta($idTema, $nPregunta,$nombreImagen){
        try{
            //recoger datos del formulario
            $titulo=$_POST['titulo'];
            $explicacion=$_POST['explicacionPregunta'];
            $puntuacion=$_POST['puntuacion'];
            //preparar consulta
            $sql="UPDATE preguntas SET titulo=:titulo, explicacion=:explicacion, imagen=:imagen, puntuacion=:puntuacion 
            WHERE idTema=:idTema AND nPregunta=:nPregunta";
            $stmt=$this->conexion->prepare($sql);
            //vincular parametros
            $stmt->bindParam(':titulo', $titulo,  PDO::PARAM_STR);
            $stmt->bindParam(':explicacion', $explicacion,PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $nombreImagen, PDO::PARAM_STR);
            $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
            $stmt->bindParam(':idTema', $idTema, PDO::PARAM_INT);
            $stmt->bindParam(':nPregunta', $nPregunta, PDO::PARAM_INT);
            //ejecutar consulta
            $stmt->execute();
            if($stmt->rowCount()>0){
                return true;
            }else{
                $this->mensaje="No se pudo modificar la pregunta";
                return $this->mensaje;
            }
        }catch(PDOException $e){
            $this->mensaje='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            return $this->mensaje;
        }
    }
    public function obtenerDatosPregunta($idTema, $nPregunta){
        try{
            $sql="SELECT * FROM preguntas WHERE idTema=:idTema AND nPregunta=:nPregunta";
            $stmt=$this->conexion->prepare($sql);
            $stmt->bindParam(':idTema', $idTema);
            $stmt->bindParam(':nPregunta', $nPregunta);
            $stmt->execute();
            $resultado=$stmt->fetch(PDO::FETCH_ASSOC);
            if($resultado){
                return $resultado;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->mensaje='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            return null;
        }
    }
}
?>