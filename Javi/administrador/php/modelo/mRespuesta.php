<?php
//PDO
    require_once 'conexion.php';
    class mRespuesta extends Conexion{
        public $mensajeError;
        //metodo para insertar respuestas
        public function meterRespuestas($idTema,$nPregunta,$respuesta,$letra, $esCorrecta){            
                try{
                    // Preparar consulta usando los nombres de columna reales (script.sql usa 'texto')
                    $sql = "INSERT INTO respuestas (idTema, nPregunta, nLetra, texto, es_correcta) 
                            VALUES (:idTema, :nPregunta, :nLetra, :texto, :es_correcta)";
                    $stmt = $this->conexion->prepare($sql);
                    //Vincular parametros
                    $stmt->bindValue(':idTema', (int)$idTema, PDO::PARAM_INT);
                    $stmt->bindValue(':nPregunta', (int)$nPregunta, PDO::PARAM_INT);
                    $stmt->bindValue(':nLetra', (string)$letra, PDO::PARAM_STR);
                    $stmt->bindValue(':texto', (string)$respuesta, PDO::PARAM_STR);
                    // Es importante pasar como entero para la columna BIT
                    $stmt->bindValue(':es_correcta', (int)$esCorrecta, PDO::PARAM_INT);
                    //Ejecutar consulta
                    
                    $stmt->execute();
                    if($stmt->rowCount() > 0){
                        return true;
                    }else{
                        $this->mensajeError="Error al insertar la respuesta";
                        return $this->mensajeError;
                    }
                }catch(PDOException $e){
                        $this->mensajeError='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                        return $this->mensajeError;
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
                $this->mensajeError = 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensajeError;
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
                $this->mensajeError = 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensajeError;
            }
        }
    } 

?>