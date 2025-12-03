<?php
require_once __DIR__ . '/../modelo/mRespuesta.php';
require_once __DIR__ . '/../modelo/mPregunta.php';

class cPreguntasRespuestas{
    private $modeloRespuestas;
    private $modeloPreguntas;
    public $mensajeError;
    public $vistaCargar;

    public function __construct(){
        $this->modeloRespuestas = new mRespuesta();
        $this->modeloPreguntas = new mPregunta();
        $this->mensajeError = '';
        $this->vistaCargar = '';
    }

    // Muestra el formulario de creación
    public function mostrarCreacion(){
        $this->vistaCargar = 'creación_Preguntas.html';
        return true;
    }

    public function monstrarGestionarTema(){
        $this->vistaCargar = 'gestiontemas.html';
        return true;
    }

    // Método que llama al modelo para guardar las preguntas
    public function meterPreguntas(){
        $idTema = 1; // Temporalmente para pruebas
        $this->mensajeError = '';

        // Validaciones básicas
        if(isset($_POST['puntuacion']) && $_POST['puntuacion'] < 200){
            $this->mensajeError = "La puntuacion no puede ser menor a 200";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
        if(!isset($_POST['opcion']) || empty($_POST['opcion'])){
            $this->mensajeError = "Debe seleccionar la respuesta correcta";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
        if(empty($_POST['titulo'])){
            $this->mensajeError = "El titulo de la pregunta no puede estar vacio";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
        if(empty($_POST['explicacionPregunta'])){
            $this->mensajeError = "La explicación de la pregunta no puede estar vacia";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
        if(!isset($_FILES['imagenPregunta']) || $_FILES['imagenPregunta']['error'] != UPLOAD_ERR_OK){
            $this->mensajeError = "Debe subir una imagen para la pregunta";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }

        /* Validar que la imagen sea .png, .jpg o .jpeg */
        $extensionesPermitidas = ['png', 'jpg', 'jpeg'];
        //[nmae] devuelve el nombre del archivo subido
        $nombreArchivo = $_FILES['imagenPregunta']['name'];
        //en extension guardo la extension del archivo en minusculas 
        //el pathinfo devuelve un array con informacion del archivo
        // el PATHINFO_EXTENSION devuelve solo la extension
        //con el strtolower lo paso a minusculas
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        if(!in_array($extension, $extensionesPermitidas)){
            $this->mensajeError = "Solo se permiten archivos .png, .jpg o .jpeg";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
        $nPregunta = $this->modeloPreguntas->meterPreguntas($idTema);
        if(is_numeric($nPregunta) && (int)$nPregunta > 0){
            if($this->meterRespuestas($idTema, (int)$nPregunta)){
                $this->vistaCargar = 'siguientePregunta.html';
                return true;
            } else {
                // Error al insertar respuestas
                $this->vistaCargar = 'creación_Preguntas.html';
                $this->mensajeError = "No se pudieron guardar las respuestas: ";
                return false;
            }
        } else {
            // Fallo al insertar la pregunta (registro interno omitido)
            if(is_string($nPregunta)){
                $this->mensajeError = "No se pudo guardar la pregunta.";
            } else {
                $this->mensajeError = "Error al guardar la pregunta.";
            }
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
    }

    // Método que llama al modelo para guardar las respuestas
    public function meterRespuestas($idTema, $nPregunta){
        if(!isset($_POST['respuestas']) || !is_array($_POST['respuestas']) || count($_POST['respuestas']) != 4){
            $this->mensajeError = "Deben ser 4 respuestas obligatoriamente";
            return false;
        }
        
        $letras = ['a','b','c','d'];
        $respuestas = $_POST['respuestas'];
        $opcionCorrecta = $_POST['opcion']; // letra de la respuesta correcta
        foreach($respuestas as $indice => $respuesta){
            $letraC = $letras[$indice]; // 'a','b','c' o 'd'
            $esCorrecta = 0; // por defecto no es correcta
            //si la opcion correcta no es nula y la letra coincide con la opcion correcta
            if($opcionCorrecta !== null && $letraC === $opcionCorrecta){
                $esCorrecta = 1; // es correcta
            }
            // Llamar al modelo para insertar la respuesta
            $resultado = $this->modeloRespuestas->meterRespuestas($idTema, $nPregunta, $respuesta, $letraC, $esCorrecta);
            if($resultado !== true){
                if(is_string($resultado)){
                    $this->mensajeError .= "Error al guardar la respuesta " . $letraC . ": " . $resultado . " ";
                } else {
                    $this->mensajeError .= "Error desconocido al guardar la respuesta " . $letraC . ". ";
                }
                return false;
            }
        }

        return true;
    }
}

?>