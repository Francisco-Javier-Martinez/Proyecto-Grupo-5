<?php
    require_once __DIR__ ."/../models/modeloTemas.php";
    require_once __DIR__ ."/../models/mPregunta.php";
    class CTemas{
        private $modelo;
        private $modeloPreguntas;
        public $mensaje;
        public $vista;


        public function __construct(){
            $this->modelo=new ModeloTemas();
            $this->mensaje=null;
            $this->modeloPreguntas = new Mpregunta();
        }

        public function mostrarCreacion(){
            $this->vista = 'creacion_Preguntas.php';
        }

        function listarTemas(){
            session_start();
            $idUsuario = $_SESSION['idUsuario'];
            $this->vista="gestiontemas.php";
            $resultado=$this->modelo->listarTemas($idUsuario);
            if(empty($resultado)){
                return []; /*RETORNAMOS ARRAY VACÍO*/
            }else{
                return $resultado;
            }
        }

        function introducirTemas(){
            $this->vista="creartemas.php";
            session_start();


            if(!empty($_POST['nombreTema']) && !empty($_POST['abreviatura']) && !empty($_POST['descripcion'])){
                $nombre=$_POST['nombreTema'];
                $abreviatura=$_POST['abreviatura'];
                $descripcion=$_POST['descripcion'];

                if(!isset($_POST['publico'])){
                    $publico = 0;
                }else{
                    $publico=1;
                }

                $idUsuario = $_SESSION['idUsuario']; // ----------------- SE SACARÁ DE LA SESIÓN ------------------------ PONEMOS 17 PORQ ES EL PRIMERO, ANTES HEMOS TENIDO Q BORRAR

                $resultado=$this->modelo->crearTema($nombre, $publico, $abreviatura, $descripcion, $idUsuario);
                if(!$resultado){
                    $this->mensaje="Error al crear el tema";
                    //$this->mensaje="TEMA CREADO CORRECTAMENTE";

                }else{
                    header("Location: index.php?controller=Temas&action=mostrarCreacion&idTema=$resultado");
                    exit();
                }
            }
        }

        function obtenerTema(){
            $this->vista="modificacion_Tema.php";
            if(isset($_GET['idTema'])){
                $idTema=$_GET['idTema'];
                $resultado=$this->modelo->obtenerTema($idTema);
                $pregunta = $this->modeloPreguntas->sacarNombrePregunta($idTema);
                $datos=[
            // nombre de todas las cosas que necesita la vista
                'pregunta' => $pregunta,
                'resultado' => $resultado
                ];
                if($resultado){
                    return $datos;
                }
            }else{
                return $this->mensaje="Error";
            }
            
        }

       function modificarTema(){
            session_start();
            $this->vista="modificacion_tema.php";
            if(!empty($_POST['nombreTema']) && !empty($_POST['abreviatura']) && !empty($_POST['descripcion'])){
                $nombre=$_POST['nombreTema'];
                $abreviatura=$_POST['abreviatura'];
                $descripcion=$_POST['descripcion'];

                if(!isset($_POST['publico'])){
                    $publico = 0;
                }else{
                    $publico=1;
                }

                $idUsuario = $_SESSION['idUsuario']; // ----------------- SE SACARÁ DE LA SESIÓN ------------------------ PONEMOS 17 PORQ ES EL PRIMERO, ANTES HEMOS TENIDO Q BORRAR
                $idTema=$_GET['idTema'];
                $resultado=$this->modelo->modificarTema($nombre, $publico, $abreviatura, $descripcion, $idUsuario, $idTema);
                
                if($resultado){
                    $this->mensaje="TEMA Modificado CORRECTAMENTE";
                    $this->vista="gestiontemas.php";
                }else{
                    $this->mensaje="Error al modificar el tema";
                }

            }else{
                $this->mensaje="Faltan datos obligatorios";
            }
            return $this->modelo->listarTemas($idUsuario); /*ME DEVUELVE TODO EL LISTADO MODIFICADO*/
        }

        function eliminarTema(){
            $this->vista="modificacion_tema.php";
            session_start();

            $idTema=$_GET["idTema"];
            $resultado = $this->modelo->eliminarTema($idTema);
            
            $idUsuario = $_SESSION['idUsuario'];

            if($resultado){
                $this->mensaje="TEMA Modificado CORRECTAMENTE";
                $this->vista="gestiontemas.php";
            }else{
                $this->mensaje="Error al modificar el tema";
            }
            return $this->modelo->listarTemas($idUsuario);/*ME DEVUELVE TODO EL LISTADO MODIFICADO*/
        }
    }
?>