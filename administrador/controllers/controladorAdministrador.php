<?php
    require_once __DIR__ . '/../models/modeloAdministrador.php';

    class ControladorAdministrador{
        private $modelo;
        private $mensaje;
        public $vista;

        function __construct(){
            $this->modelo = new ModeloAdministrador();
            $this->mensaje=null;
        }

        function instalacionSuperAdmin(){
            //if($_SERVER['REQUEST_METHOD'] === 'POST'){PREGUNTAR A ISA. SE USA PARA VER SI HAY POST (SE HA ENVIADO EL MENSAJE)
            $this->vista="instalacion.html"; /*SI LA INSTALACION FALLA, VUELVE AL MISMO*/
            if(!empty($_POST['email']) && !empty($_POST['nombre']) && !empty($_POST['password'])){
                $email=$_POST['email'];
                $nombre=$_POST['nombre'];
                $password=$_POST['password'];
                $tipo=$_GET['tipo'];
                
                $passwordEncript=password_hash($password, PASSWORD_DEFAULT);
                $resultado=$this->modelo->introducirSuperAdmin($nombre, $passwordEncript, $email,  $tipo);
                if($resultado){
                    $this->mensaje="ADMINISTRADOR INTRODUCIDO CORRECTAMENTE";
                    $this->vista="panelAdministrador.html"; /*NOS VAMOS A LA SIGUIENTE VISTA SI TODO OK*/
                    /*NO USAR EXIT A NO SER QUE SEA UN HEADER, ROMPE LA EJECUCIÓN EN EL INDEX*/
                }else{
                    $this->mensaje="ERROR AL INTRODUCIR EL USUARIO";
                }
            }else{
                $this->mensaje="ERROR, FALTAN DATOS OBLIGATORIOS";
            }

        }

        function iniciarSesion(){
            //if($_SERVER['REQUEST_METHOD'] === 'POST'){PREGUNTAR A ISA. SE USA PARA VER SI HAY POST (SE HA ENVIADO EL MENSAJE)

            $this->vista="inicio_sesion_admin.html";

            if(!empty($_POST['email']) && !empty($_POST['password'])){
                $email=$_POST['email'];
                $password=$_POST['password'];

                $resultado=$this->modelo->iniciarSesion($email);

                if($resultado && password_verify($password ,$resultado["contrasenia"])){
                    $this->mensaje="SESIÓN INICIADA CORRECTAMENTE";
                    $this->vista="panelAdministrador.html"; /*NOS VAMOS A LA SIGUIENTE VISTA SI TODO OK*/
                    /*NO USAR EXIT A NO SER QUE SEA UN HEADER, ROMPE LA EJECUCIÓN EN EL INDEX*/
                }else{
                    $this->mensaje="ERROR AL INICIAR SESION";
                    
                }
            }


        }

        function panelAdministrador(){
            $this->vista="panelAdministrador.html";
        }

    }
?>