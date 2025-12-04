<?php
    require_once "models/modeloTemas.php";

    class ControladorTemas{
        private $modelo;
        public $mensaje;
        public $vista;


        public function __construct(){
            $this->modelo=new ModeloTemas();
            $this->mensaje=null;

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
                if($resultado){
                    $this->mensaje="TEMA CREADO CORRECTAMENTE";
                    $this->vista="creacion_Preguntas.html";
                }else{
                    $this->mensaje="Error al crear el tema";
                }

            }else{
                $this->mensaje="Faltan datos obligatorios";
            }
        }

        function obtenerTema(){
            $this->vista="modificacion_Tema.php";
            if(isset($_GET['idTema'])){
                $idTema=$_GET['idTema'];
                $resultado=$this->modelo->obtenerTema($idTema);
                if($resultado){
                    return $resultado;
                }
            }else{
                return $this->mensaje="Error";
            }
            
        }

       function modificarTemas(){
            $this->vista="modificacion_tema.php";
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