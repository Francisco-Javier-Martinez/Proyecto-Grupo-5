<?php
require_once __DIR__ . '/../modelo/mRespuesta.php';
require_once __DIR__ . '/../modelo/mPregunta.php';

class cPreguntasRespuestas{
    private $modeloRespuestas;
    private $modeloPreguntas;
    public $mensaje;
    public $vista;

    public function __construct(){
        $this->modeloRespuestas = new mRespuesta();
        $this->modeloPreguntas = new mPregunta();
        $this->mensaje = '';
        $this->vista = '';
    }

    // Muestra el formulario de creación
    public function mostrarCreacion(){
        $this->vista = 'creacion_Preguntas.html';
    }

    //monstrar la vista de crear nueva pregunta
    public function mostrarNuevaPregunta(){
        $idTema = $_GET['idTema'];
        // Usar el mismo nombre de fichero que existe en la carpeta vistas (con tilde)
        $this->vista = 'creacion_Preguntas.html';
    }
    //metodo para mostrar la vista de gestionar temas
    public function monstrarGestionarTema(){
        $this->vista = 'gestiontemas.html';
    }

    // Método que llama al modelo para obtener las preguntas de un tema
    public function sacarNombrePregunta(){
        $this->vista = 'modificacion_Tema.php';
        $idTema = $_GET['idTema'] ?? 1; // Recibir idTema desde GET
        return $this->modeloPreguntas->sacarNombrePregunta($idTema);
    }

    // Cargar una pregunta y sus respuestas para modificarla
    public function editarPregunta(){
        // Preparar vista y datos para edición
        $this->vista = 'Modificar_Preguntas.php';
        $idTema = $_GET['idTema'];
        $nPregunta = $_GET['nPregunta'];

        $pregunta = $this->modeloPreguntas->obtenerDatosPregunta($idTema, $nPregunta); // Datos de pregunta
        $respuestas = $this->modeloRespuestas->obtenerRespuestas($idTema, $nPregunta); // Datos de respuestas
        //crear un array con todos los datos porque tengo que llamar a 2 metodos del modelo
        //para saccar la pregunta y las respuestas porque son 1 vista
        $datos = [
            'idTema' => $idTema,
            'nPregunta' => $nPregunta,
            'pregunta' => $pregunta,
            'respuestas' => $respuestas,
            'imagenPregunta' => RUTA_IMAGENES_PREGUNTAS . $pregunta['imagen']
        ];

        return $datos;
    }

    // Método que llama al modelo para modificar una pregunta
    public function modificarPregunta(){
        $idTema = $_POST['idTema'];
        $nPregunta = $_POST['nPregunta'];
        $respuesta= $_POST['respuestas'];
        //validar los datos recibidos si dejo algo si poner le digo que no se puede dejar vacio
        if(empty($_POST['titulo']) || empty($_POST['explicacionPregunta']) || !isset($_POST['puntuacion']) || !isset($_POST['opcion'])){
            $this->mensaje = "Todos los campos son obligatorios meterlos";
            $this->vista = 'error.php';
            return false;
        }
        if($_POST['respuestas'][0]=='' || $_POST['respuestas'][1]=='' || $_POST['respuestas'][2]=='' || $_POST['respuestas'][3]==''){
            $this->mensaje = "Todas las respuestas son obligatorias meterlas";
            $this->vista = 'error.php';
            return false;
        }
        // Verificar si se subió una nueva imagen porque si no se sube hay que mantener la que ya estaba
            //si el input file tiene algo es que se ha subido una imagen nueva
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK){
            // Intentar guardar la imagen mediante el modelo. Si falla, no continuar.
            $preguntaActual = $this->modeloPreguntas->obtenerDatosPregunta($idTema, $nPregunta);
            //llamo al metodo meterImagenCarpeta
            $nombreImagenNueva = $this->meterImagenCarpeta($idTema, $nPregunta, $_FILES['imagen']);
            //si ha habido un error al subir la imagen
            if($nombreImagenNueva == false){
                $this->mensaje = $this->modeloPreguntas->mensaje;
                $this->vista = 'error.php';
            }
            // Borrar la imagen anterior sólo si existe y es distinta
            if($preguntaActual && !empty($preguntaActual['imagen']) && $preguntaActual['imagen'] !== $nombreImagenNueva){
                $rutaImagenAnterior = __DIR__ . '/../' . RUTA_IMAGENES_PREGUNTAS . $preguntaActual['imagen'];
                if(file_exists($rutaImagenAnterior)){
                    unlink($rutaImagenAnterior);
                }
            }
            $nombreImagen = $nombreImagenNueva;
        } else {
            // No se subió imagen, mantener la actual
            $preguntaActual = $this->modeloPreguntas->obtenerDatosPregunta($idTema, $nPregunta);
            $nombreImagen = $preguntaActual['imagen'];
        }
        //modificamos la pregunta
        $resultadoPregunta = $this->modeloPreguntas->modificarPregunta($idTema, $nPregunta,$nombreImagen);
        //si la modificacion de la pregunta es correcta
        if($resultadoPregunta == true){
            //modificamos las respuestas
            $resultadoRespuestas = $this->modificarRespuestas($idTema, $nPregunta, $respuesta);
            //si la modificacion de las respuestas es correcta
            if($resultadoRespuestas == true){
                return true;
            } else {
                // Error al modificar respuestas
                $this->mensaje = "No se pudieron modificar las respuestas: " . $resultadoRespuestas; //concateno con el error devuelto
                $this->vista = 'error.php';
            }
        } else {
            $this->mensaje = "No se pudo modificar la pregunta: " . $resultadoPregunta;
            $this->vista = 'error.php';
        }
    }

    // Guarda la imagen en la carpeta de preguntas; devuelve el nombre de archivo o false si falla
    private function meterImagenCarpeta($idTema, $nPregunta, $file){
        try{
            if(!isset($file)){
                $this->mensaje = 'No se recibió el fichero de imagen';
                $this->vista = 'error.php';
                return false;
            }
            if($file['error']!=UPLOAD_ERR_OK){
                $this->mensaje = 'Error en la subida de la imagen)';
                $this->vista = 'error.php';
                return false;
            }
            $extensionesPermitidas = ['png','jpg','jpeg'];
            //obtengo la extension del archivo subido
            //el pathinfo devuelve un array con informacion del archivo
            //y el PATHINFO_EXTENSION devuelve solo la extension
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if(!in_array($extension, $extensionesPermitidas)){
                $this->mensaje = 'Solo se permiten archivos .png, .jpg o .jpeg';
                $this->vista = 'error.php';
                return false;
            }
            //el nombre de la imagen sera pregunta +idTema + nPregunta + . + extension
            $nombreImagen = 'pregunta' . $idTema  . '_' . $nPregunta . '.' . $extension;
            $rutaCarpeta = __DIR__ . '/../' . RUTA_IMAGENES_PREGUNTAS;
            //ruta destino es la ruta completa donde se va a guardar la imagen
            $rutaDestino = $rutaCarpeta . $nombreImagen;
            //si no se puede mover el archivo a la carpeta destino
            //devuelve false
            //el ['tmp_name'] es el nombre temporal que le da php al archivo subido
            if(!move_uploaded_file($file['tmp_name'], $rutaDestino)){
                $this->mensaje = 'No se pudo mover la imagen al destino';
                $this->vista = 'error.php';
                return false;
            }
            //si todo fue bien devuelve el nombre de la imagen
            return $nombreImagen;
        }catch(Exception $e){
            $this->mensaje = 'Error al guardar la imagen: ' . $e->getMessage();
            $this->vista = 'error.php';
            return false;
        }
    }

    // Método que llama al modelo para modificar las respuestas
    private function modificarRespuestas($idTema, $nPregunta, $respuestas){
        //reutilizo el mismo codigo que en meter respuestas pero llamando al metodo modificar
        $this->vista = 'panelAdministrador.html';
        $letras = ['a','b','c','d'];
        $respuestas = $_POST['respuestas'];
        $opcionCorrecta = $_POST['opcion'] ?? null; // letra de la respuesta correcta
        if ($opcionCorrecta == null) {
            $this->mensaje = 'No se indicó la opción correcta';
            $this->vista = 'error.php';
            return false;
        }
        //recorro las respuestas 
        foreach($respuestas as $indice => $respuesta){
            $letraC = $letras[$indice]; // 'a','b','c' o 'd'
            $esCorrecta = 0; // por defecto no es correcta
            //si la opcion correcta no es nula y la letra coincide con la opcion correcta
            if($letraC==$opcionCorrecta){
                $esCorrecta = 1; // es correcta
            }
            // Llamar al modelo para modificar la respuesta
            $resultado = $this->modeloRespuestas->modificarRespuesta($idTema, $nPregunta, $letraC, $respuesta, $esCorrecta);
            //si no se ha modificado correctamente
            if($resultado !== true){
                return $resultado;
            }            
        }
        return true; // todas las respuestas se modificaron exitosamente
    }
    // Método que llama al modelo para borrar una pregunta
    public function borrarPregunta(){
        $idTema = $_GET['idTema'];
        $nPregunta = $_GET['nPregunta'];
        // Obtener datos de la pregunta antes de borrarla (para conocer el nombre de la imagen)
        $pregunta = $this->modeloPreguntas->obtenerDatosPregunta($idTema, $nPregunta);

        $resultado = $this->modeloPreguntas->borrarPregunta($idTema, $nPregunta);
        if($resultado == true){
            // Si existía una imagen asociada, intentar borrarla del disco
            if($pregunta && !empty($pregunta['imagen'])){
                $rutaImagen = __DIR__ . '/../' . RUTA_IMAGENES_PREGUNTAS . $pregunta['imagen'];
                // Verificar si el archivo existe antes de intentar borrarlo
                if(file_exists($rutaImagen)){
                    unlink($rutaImagen);
                }
            }
            $this->vista = 'panelAdministrador.html';
        } else {
            $this->mensaje = $resultado;
            $this->vista = 'error.php';
        }
    }
    // Método que llama al modelo para guardar las preguntas
    public function meterPreguntas(){
        // Obtener idTema desde POST (o dejar 1 si no viene)
        $idTema = isset($_POST['idTema']) ? intval($_POST['idTema']) : 1;

        // validar los datos recibidos
        if(isset($_POST['puntuacion']) && $_POST['puntuacion'] < 200){
            $this->mensaje = "La puntuacion no puede ser menor a 200";
            $this->vista = 'error.php';
            return false;
        }
        if(!isset($_POST['opcion'])){
            $this->mensaje = "Debe seleccionar la respuesta correcta";
            $this->vista = 'error.php';
            return false;
        }
        if(empty($_POST['titulo'])){
            $this->mensaje = "El titulo de la pregunta no puede estar vacio";
            $this->vista = 'error.php';
            return false;
        }
        if(empty($_POST['explicacionPregunta'])){
            $this->mensaje = "La explicación de la pregunta no puede estar vacia";
            $this->vista = 'error.php';
            return false;
        }

        // validar respuestas
        if(!isset($_POST['respuestas']) || count($_POST['respuestas'])!=4){
            $this->mensaje = "Deben ser 4 respuestas obligatoriamente";
            $this->vista = 'error.php';
            return false;
        }
        // validar respuestas: debe haber 4 y no estar vacías
        if(!isset($_POST['respuestas']) || count($_POST['respuestas'])!=4){
            $this->mensaje = "Deben ser 4 respuestas obligatoriamente";
            $this->vista = 'error.php';
            return false;
        }
        // comprobar que ninguna respuesta esté vacía
        $respuestasTmp = $_POST['respuestas'];
        foreach ($respuestasTmp as $respuesta) {
            if ($respuesta == '') {
                $this->mensaje = "Ninguna respuesta puede estar vacía";
                $this->vista = 'error.php';
                return false;
            }
        }
        // validar imagen subida
        if(!isset($_FILES['imagenPregunta']) || $_FILES['imagenPregunta']['error']!=UPLOAD_ERR_OK){
            $this->mensaje = "Debe subir una imagen para la pregunta";
            $this->vista = 'error.php';
            return false;
        }

        // Obtener siguiente número de pregunta desde el modelo
        $nPregunta = $this->modeloPreguntas->sacarNpregunta($idTema);
        if(!is_int($nPregunta)){
            $this->mensaje = "No se pudo determinar el número de la pregunta: " . $nPregunta;
            $this->vista = 'error.php';
            return false;
        }
        $nPregunta = (int)$nPregunta;

        // Guardar imagen usando método privado del controlador
        $nombreImagen = $this->meterImagenCarpeta($idTema, $nPregunta, $_FILES['imagenPregunta']);
        if($nombreImagen == false){
            $this->mensaje = $this->mensaje;
            $this->vista = 'error.php';
            return false;
        }

        // Llamar al modelo para insertar la pregunta (ahora requiere nPregunta y nombreImagen)
        $resultado = $this->modeloPreguntas->meterPreguntas($idTema, $nPregunta, $nombreImagen);
        if((int)$resultado > 0){
            // Guardar las respuestas
            if($this->meterRespuestas($idTema, $nPregunta)){
                $this->vista = 'siguientePregunta.html';
                return true;
            } else {
                $this->vista = 'creacion_Preguntas.html';
                $this->mensaje = "No se pudieron guardar las respuestas";
                $this->vista = 'error.php';
            }
            } else {
                //si no se ha insertado la pregunta debo borrar la imagen que se subio
                unlink(__DIR__ . '/../' . RUTA_IMAGENES_PREGUNTAS . $nombreImagen);
                $this->mensaje = $resultado;
                $this->vista = 'error.php';
                return false;
            }
    }

    // Método que llama al modelo para guardar las respuestas
    public function meterRespuestas($idTema, $nPregunta){
        // letra es un array cual voy a usar para identificar las respuestas
        $letras = ['a','b','c','d'];
        //recojo las respuestas del formulario
        $respuestas = $_POST['respuestas'];
        //guardo la letra de la respuesta correcta porque en el formulario envia a b c d
        $opcionCorrecta = $_POST['opcion'];
        if ($opcionCorrecta == null) {
            $this->mensaje = 'Debe seleccionar la respuesta correcta';
            $this->vista = 'error.php';
            return false;
        }
        //recorro las respuestas para guardar las 4 respuestas
        foreach($respuestas as $indice => $respuesta){
            $letraC = $letras[$indice]; //primera letra del array
            $esCorrecta = 0; // por defecto no es correcta
            //si la letra coincide con la opcion correcta siginifica que es correcta
            if($letraC == $opcionCorrecta){
                $esCorrecta = 1;
            }
            // Llamar al modelo para insertar la respuesta (letra, respuesta, esCorrecta)
            $resultado = $this->modeloRespuestas->meterRespuestas($idTema, $nPregunta, $letraC, $respuesta, $esCorrecta);
            //si no se ha insertado correctamente
            if($resultado !== true){
                return $resultado; //resulta tiene el mensaje de error dentro
            }
        }
        return true;
    }
}

?>