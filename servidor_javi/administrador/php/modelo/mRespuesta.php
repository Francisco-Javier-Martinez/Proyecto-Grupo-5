<?php
//PDO
    require_once 'conexion.php';
    class mRespuesta extends Conexion{
        public $mensajeError;

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
    } 

?>