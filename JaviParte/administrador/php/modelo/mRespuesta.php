<?php
//PDO
    require_once 'conexion.php';
    class mRespuesta extends Conexion{
        //metodo para insertar respuestas
        public function meterRespuestas($idTema, $nPregunta, $letra, $respuesta, $esCorrecta){
            try{
                //transacion para asegurar que si falla una parte no se inserte nada
                $this->conexion->beginTransaction();
                // Preparar consulta usando los nombres de columna reales (script.sql usa 'texto')
                $sql = "INSERT INTO respuestas (idTema, nPregunta, nLetra, texto, es_correcta) 
                        VALUES (:idTema, :nPregunta, :nLetra, :texto, :es_correcta)";
                $stmt = $this->conexion->prepare($sql);
                //Vincular parametros (asegurar orden correcto)
                $stmt->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT);
                $stmt->bindValue(':nPregunta', (int)$nPregunta, PDO::PARAM_INT);
                $stmt->bindValue(':nLetra', (string)$letra, PDO::PARAM_STR);
                $stmt->bindValue(':texto', (string)$respuesta, PDO::PARAM_STR);
                // Es importante pasar como entero para la columna BIT
                $stmt->bindValue(':es_correcta', (int)$esCorrecta, PDO::PARAM_INT);
                //Ejecutar consulta
                $stmt->execute();
                //el commmit lo que hace es confirmar la transaccion
                $this->conexion->commit();
                if($stmt->rowCount() > 0){
                    return true;
                }else{
                    $this->mensaje="Error al insertar la respuesta";
                    return $this->mensaje;
                }
            }catch(PDOException $e){
                //si hay error hago rollback para que no se inserte nada
                $this->conexion->rollBack();
                $this->mensaje='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensaje;
            }
        } 

        // Modificar una respuesta específica
        public function modificarRespuesta($idTema, $nPregunta, $letra, $texto, $esCorrecta){
            try{
                $sql = "UPDATE respuestas SET texto = :texto, es_correcta = :es_correcta 
                        WHERE idTema = :idTema AND nPregunta = :nPregunta AND nLetra = :nLetra";
                //recoger la variable texto y esCorrecta
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindValue(':texto', (string)$texto, PDO::PARAM_STR);
                $stmt->bindValue(':es_correcta', (int)$esCorrecta, PDO::PARAM_INT);
                $stmt->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT);
                $stmt->bindValue(':nPregunta', (int)$nPregunta, PDO::PARAM_INT);
                $stmt->bindValue(':nLetra', (string)$letra, PDO::PARAM_STR);
                $stmt->execute();
                //si el usuario no toco las respuestas no habra filas afectadas por eso pongo >=0
                if($stmt->rowCount() >= 0){
                    return true;
                }
            }catch(PDOException $e){
                $this->mensaje = 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensaje;
            }
        }
        // Obtener todas las respuestas de una pregunta
        public function obtenerRespuestas($idTema, $nPregunta){
            try{
                $sql = "SELECT * FROM respuestas WHERE idTema = :idTema AND nPregunta = :nPregunta ORDER BY nLetra ASC";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT);
                $stmt->bindValue(':nPregunta', (int)$nPregunta, PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($resultado){
                    return $resultado;
                }else{
                    return [];
                }
            }catch(PDOException $e){
                $this->mensaje = 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensaje;
            }
        }

        // Borrar todas las respuestas de una pregunta (útil para limpiar inserciones parciales)
        public function borrarRespuestasPorPregunta($idTema, $nPregunta){
            try{
                $sql = "DELETE FROM respuestas WHERE idTema = :idTema AND nPregunta = :nPregunta";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT);
                $stmt->bindValue(':nPregunta', (int)$nPregunta, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            }catch(PDOException $e){
                $this->mensaje = 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensaje;
            }
        }
    } 

?>