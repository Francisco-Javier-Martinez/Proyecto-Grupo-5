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
    }

    //monstrar la vista de crear nueva pregunta
    public function mostrarNuevaPregunta(){
        $idTema = $_GET['idTema'];
        // Usar el mismo nombre de fichero que existe en la carpeta vistas (con tilde)
        $this->vistaCargar = 'creación_Preguntas.html';
    }
    //metodo para mostrar la vista de gestionar temas
    public function monstrarGestionarTema(){
        $this->vistaCargar = 'gestiontemas.html';
    }

    // Método que llama al modelo para obtener las preguntas de un tema
    public function sacarNombrePregunta(){
        $this->vistaCargar = 'modificacion_Tema.php';
        $idTema = $_GET['idTema'] ?? 1; // Recibir idTema desde GET
        return $this->modeloPreguntas->sacarNombrePregunta($idTema);
    }

    // Cargar una pregunta y sus respuestas para modificarla
    public function editarPregunta(){
        // Preparar vista y datos para edición
        $this->vistaCargar = 'Modificar_Preguntas.php';
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
            $this->mensajeError = "Todos los campos son obligatorios meterlos";
            return false;

        }
        if($_POST['respuestas'][0]=='' || $_POST['respuestas'][1]=='' || $_POST['respuestas'][2]=='' || $_POST['respuestas'][3]==''){
            $this->mensajeError = "Todas las respuestas son obligatorias meterlas";
            return false;
        }
        // Verificar si se subió una nueva imagen porque si no se sube hay que mantener la que ya estaba
            //si el input file tiene algo es que se ha subido una imagen nueva
        if(isset($_FILES['imagen'])){
            // Obtener la extensión del archivo
            //repito el mismo proceso que en insertar pregunta para subir la imagen
            $imagenOriginal=$_FILES['imagen']['name']; //reocoger el nombre original de la imagen
            $extension = pathinfo($imagenOriginal, PATHINFO_EXTENSION);//sacar la extension del archivo
            // Renombrar la imagen como pregunta[nPregunta]
            $nombreImagen = 'pregunta' . $nPregunta . '.' . $extension;//renombrar la imagen
            // Eliminar la imagen anterior si existe
            //como se va a llamar pregunta+nPregunta tengo que borrar la imagen anterior para no tenre conflictos
            $preguntaActual = $this->modeloPreguntas->obtenerDatosPregunta($idTema, $nPregunta);//sacar los datos de la pregunta actual para sacar el nombre de la imagen
            //la ruta de la imagen anterior para eliminarla 
            $rutaImagenAnterior = __DIR__ . '/../' . RUTA_IMAGENES_PREGUNTAS . $preguntaActual['imagen'];
            //si el archivo existe lo elimino
            if(file_exists($rutaImagenAnterior)){ //file_exists comprueba si el archivo existe
                unlink($rutaImagenAnterior);//unlink elimina el archivo
            }
            // Subir la nueva imagen
            $rutaTemporal=$_FILES['imagen']['tmp_name']; //ruta de la memoria temporal
            $rutaDestino=__DIR__ . '/../' . RUTA_IMAGENES_PREGUNTAS . $nombreImagen;// ruta donde se va a guardar la imagen
            move_uploaded_file($rutaTemporal, $rutaDestino);// y la movemos a su destino
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
            if($resultadoRespuestas === true){
                return true;
            } else {
                // Error al modificar respuestas
                $this->mensajeError = "No se pudieron modificar las respuestas: " . $resultadoRespuestas; //concateno con el error devuelto
                return false;
            }
        } else {
            $this->mensajeError = "No se pudo modificar la pregunta: " . $resultadoPregunta;
            return false;
        }
    }

    // Método que llama al modelo para modificar las respuestas
    private function modificarRespuestas($idTema, $nPregunta, $respuestas){
        //reutilizo el mismo codigo que en meter respuestas pero llamando al metodo modificar
        $this->vistaCargar = 'panelAdministrador.html';
        $letras = ['a','b','c','d'];
        $respuestas = $_POST['respuestas'];
        $opcionCorrecta = $_POST['opcion']; // letra de la respuesta correcta
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
        $resultado= $this->modeloPreguntas->borrarPregunta($idTema, $nPregunta);
        if($resultado === true){
            $this->vistaCargar = 'panelAdministrador.html';
        } else {
            $this->mensajeError = $resultado;
            return false;
        }
    }
    // Método que llama al modelo para guardar las preguntas
    public function meterPreguntas(){
        $idTema = 1; // Temporalmente para pruebas
        $this->mensajeError = '';

        // validar los datos recibidos
        if(isset($_POST['puntuacion']) && $_POST['puntuacion'] < 200){
            $this->mensajeError = "La puntuacion no puede ser menor a 200";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
        if(!isset($_POST['opcion'])){
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

        //validar que haya 4 respuestas esto lo pongo aqui porque no quiero llamar al modelo si no hay 4 respuestas
        if(!isset($_POST['respuestas']) || !is_array($_POST['respuestas']) || count($_POST['respuestas']) != 4){
            $this->mensajeError = "Deben ser 4 respuestas obligatoriamente";
            return false;
        }
        //si no se ha subido ninguna imagen, el [error]!= UPLOAD_ERR_OK es para comprobar que no haya errores en la subida
        if(!isset($_FILES['imagenPregunta']) || $_FILES['imagenPregunta']['error'] != UPLOAD_ERR_OK){
            $this->mensajeError = "Debe subir una imagen para la pregunta";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }

        /* Validar que la imagen sea .png, .jpg o .jpeg */
        $extensionesPermitidas = ['png', 'jpg', 'jpeg'];
        //[nmae] devuelve el nombre del archivo subido
        $nombreArchivo = $_FILES['imagenPregunta']['name'];
        //en extension guardo la extension del archivo en minusculas porque no voy a permitir que me meta un .exe o algo raro
        //el pathinfo devuelve un array con informacion del archivo
        //el PATHINFO_EXTENSION devuelve solo la extension
        //con el strtolower lo paso a minusculas
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        //si la extension no esta en el array de extensiones permitidas significa que no es valida
        if(!in_array($extension, $extensionesPermitidas)){
            $this->mensajeError = "Solo se permiten archivos .png, .jpg o .jpeg";
            $this->vistaCargar = 'creación_Preguntas.html';
            return false;
        }
        // Llamar al modelo para insertar la pregunta
        $nPregunta = $this->modeloPreguntas->meterPreguntas($idTema);
        //si se ha insertado correctamente la pregunta
        if((int)$nPregunta > 0){
            //Meto las respuestas les paso el idTema y el nPregunta que me ha devuelto el metodo anterior
            if($this->meterRespuestas($idTema, (int)$nPregunta)){
                $this->vistaCargar = 'siguientePregunta.html';
                return true;
            } else {
                // Error al insertar respuestas
                $this->vistaCargar = 'creación_Preguntas.html';
                $this->mensajeError = "No se pudieron guardar las respuestas: ";
                return false;
            }
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
        //recorro las respuestas para guardar las 4 respuestas
        foreach($respuestas as $indice => $respuesta){
            $letraC = $letras[$indice]; //primera letra del array
            $esCorrecta = 0; // por defecto no es correcta
            //si la letra coincide con la opcion correcta siginifica que es correcta
            if($letraC === $opcionCorrecta){
                $esCorrecta = 1;
            }
            // Llamar al modelo para insertar la respuesta
            $resultado = $this->modeloRespuestas->meterRespuestas($idTema, $nPregunta, $respuesta, $letraC, $esCorrecta);
            //si no se ha insertado correctamente
            if($resultado !== true){
                return $resultado; //resulta tiene el mensaje de error dentro por si os liais a quien lea estoy de mi grupo
            }
        }
        return true;
    }
}

?>