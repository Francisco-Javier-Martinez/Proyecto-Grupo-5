<?php
    require_once 'conexion.php';
    require_once __DIR__ . '/../../../config/configRT.php';
    class mPregunta extends Conexion{
        public $mensajeError;
        public function meterPreguntas($idTema){
            try{
                //Sacar el numero de la pregunta ya que la pk es idTema+nPregunta
                $nPregunta=$this->sacarNpregunta($idTema);
                //limitar a 10 preguntas por tema
                if($nPregunta==10){
                    $this->mensajeError="No se pueden insertar mas de 10 preguntas por tema";
                    return $this->mensajeError;
                }
                //Recoger datos del formulario
                $titulo=$_POST['titulo']; //titulo de la pregunta
                $explicacion=$_POST['explicacionPregunta']; //explicacion de la pregunta
                //Subir imagen al servidor
                $imagenOriginal=$_FILES['imagenPregunta']['name']; //imagen original sin que le haya cambiado el nombre
                //Obtener la extensión del archivo para concatenarla al nuevo nombre de la imagen que va a ser pregunta+nPregunta porque si no es un lio
                //asi que se guarda la imagen con el nombre pregunta1.jpg o png o jpeg que son los 3 tipos que yo permito
                $extension = pathinfo($imagenOriginal, PATHINFO_EXTENSION);
                //renombrar la imagen
                $nombreImagen = 'pregunta' . $nPregunta . '.' . $extension;
                //creo una ruta temporal donde se guarda la imagen como asi decirlo que queda guardad en la memoria temporal del servidor
                $rutaTemporal=$_FILES['imagenPregunta']['tmp_name'];
                //Guardar en la ruta preterminada de las imagenes de las preguntas que se llama img esta guardado en el configRT.php
                $rutaDestino=__DIR__ . '/../' . RUTA_IMAGENES_PREGUNTAS . $nombreImagen;
                //uso la funcion move_uploaded_file para mover la imagen a la ruta destino, uso la temporal para moverla a la ruta destino
                move_uploaded_file($rutaTemporal, $rutaDestino);
                //recoger la puntuacion
                $puntuacion=$_POST['puntuacion'];
                //Preparar consulta
                //he decidido usar la nomenclatura de los nombres de :titulo en ve de de ? porque me parece mas claro
                // y asi no tengo que ir con el binParam diciendo el orden de los parametros directamente asigno el nombre a la variable
                $sql="INSERT INTO preguntas (idTema, nPregunta, titulo, explicacion, imagen, puntuacion) 
                VALUES (:idTema, :nPregunta, :titulo, :explicacion, :imagen, :puntuacion)";
                $stmt=$this->conexion->prepare($sql);
                //Vincular parametros
                //PDO::PARAM_STR es para cadena de texto y PDO::PARAM_INT para enteros 
                $stmt->bindParam(':idTema', $idTema, PDO::PARAM_INT); //el PDO::PARAM_INT es para decir que es un entero lo que debe recibir
                $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
                $stmt->bindParam(':explicacion', $explicacion, PDO::PARAM_STR);
                $stmt->bindParam(':imagen', $nombreImagen, PDO::PARAM_STR);
                $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
                $stmt->bindParam(':nPregunta', $nPregunta, PDO::PARAM_INT);
                //Ejecutar consulta
                $stmt->execute();
                //si se ha insertado correctamente es que funciona , el rowCount es lo mismo que el affectedRows de mysqli
                if($stmt->rowCount()>0){//Si se ha insertado correctamente
                    return $nPregunta; // asegurar que devolvemos un entero
                }else{
                    return $this->mensajeError="Error al insertar la pregunta";
                }
            }catch(PDOException $e){
                $this->mensajeError='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensajeError;
            }
        }
        //metodo para sacar el numero de la siguiente pregunta
        private function sacarNpregunta($idTema){
            try{
                //esta consulta sacara el numero de preguntas que hay en ese tema
                $sql="SELECT COUNT(*) AS nPregunta FROM preguntas WHERE idTema=:idTema"; 
                $stmt=$this->conexion->prepare($sql); //Preparar consulta
                $stmt->bindParam(':idTema', $idTema);//Vincular parametro
                $stmt->execute();//Ejecutar consulta
                $resultado=$stmt->fetch(PDO::FETCH_ASSOC);// el fetch(PDO::FETCH_ASSOC) devuelve un array  si yo solo quiero 1 fila es con el fetch
                if($resultado){ //si hay preguntas devuelvo el numero de la siguiente pregunta
                    return $resultado['nPregunta'] + 1;//+1 porque si hay 3 preguntas la siguiente es la 4 es lo que hace el count que me va a decir cuantas hay en ese momento
                }else{
                    return 1; //si no hay preguntas devuelvo 1 porque es la primera pregunta
                }
            }catch(PDOException $e){
                $this->mensajeError='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
                return $this->mensajeError;
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
            $this->mensajeError='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            return $this->mensajeError;
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
                $this->mensajeError="No se encontró la pregunta para borrar";
                return false;
            }
        }catch(PDOException $e){
            $this->mensajeError='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
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
                $this->mensajeError="No se pudo modificar la pregunta";
                return $this->mensajeError;
            }
        }catch(PDOException $e){
            $this->mensajeError='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            return $this->mensajeError;
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
            $this->mensajeError='Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            return null;
        }
    }
}
?>