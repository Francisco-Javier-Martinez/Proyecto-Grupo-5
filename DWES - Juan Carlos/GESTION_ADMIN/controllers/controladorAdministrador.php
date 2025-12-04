<?php
    include "models/modeloAdministrador.php";

    class ControladorAdministrador{
        private $modelo;
        public $mensaje;
        public $vista;

        function __construct(){
            $this->modelo = new ModeloAdministrador();
            $this->mensaje=null;
        }

        function iniciarSesion(){
            //if($_SERVER['REQUEST_METHOD'] === 'POST'){PREGUNTAR A ISA. SE USA PARA VER SI HAY POST (SE HA ENVIADO EL MENSAJE)
            session_start();

            $this->vista="inicio_sesion_admin.php";

            if(!empty($_POST['email']) && !empty($_POST['password'])){
                $email=$_POST['email'];
                $password=$_POST['password'];

                $resultado=$this->modelo->iniciarSesion($email);

                if($resultado && password_verify($password ,$resultado["contrasenia"])){
                    $this->mensaje="SESIÓN INICIADA CORRECTAMENTE";
                    $this->vista="panelAdministrador.php"; /*NOS VAMOS A LA SIGUIENTE VISTA SI TODO OK*/
                    /*NO USAR EXIT A NO SER QUE SEA UN HEADER, ROMPE LA EJECUCIÓN EN EL INDEX*/
                    $_SESSION['idUsuario'] = $resultado['idUsuario'];
                    $_SESSION['nombre'] = $resultado['nombre'];
                    return $_SESSION['nombre'] = $resultado['nombre']; /*RETORNAMOS EL NOMBRE DEL USUARIO*/
                }else{
                    $this->mensaje="Usuario no encontrado";
                }
            }else{
                $this->mensaje="FALTAN DATOS OBLIGATORIOS";
            }
            
        }

        function panelAdministrador(){
            session_start();
            $this->vista="panelAdministrador.php";
            return $_SESSION['nombre'];
        }

        
        function cerrarSesion(){
            $this->vista="inicio_sesion_admin.php";
            session_start();
            session_destroy();
        }

    }
?>