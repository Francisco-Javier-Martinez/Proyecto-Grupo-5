<?php
require_once __DIR__ ."/../models/modeloAdministrador.php";

class CAdministrador {
    private $modelo;
    public $mensaje;
    public $vista;

    function __construct() {
        $this->modelo = new ModeloAdministrador();
        $this->mensaje = null;
        // Iniciar sesión una sola vez en el constructor
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    function vistaInicial() {
        $this->vista = "inicio_sesion_admin.php";
    }

    function volverPanelInicial() {
        $this->vista = "panelAdministrador.php";
    }
    
    function iniciarSesion() {
        $this->vista = "inicio_sesion_admin.php";

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $resultado = $this->modelo->iniciarSesion($email);

            if ($resultado && password_verify($password, $resultado["contrasenia"])) {
                $this->mensaje = "SESIÓN INICIADA CORRECTAMENTE";
                $this->vista = "panelAdministrador.php";
                $_SESSION['idUsuario'] = $resultado['idUsuario'];
                $_SESSION['nombre'] = $resultado['nombre'];
                $_SESSION['tipo'] = $resultado['tipo'];
            } else {
                $this->mensaje = "Usuario o contraseña incorrectos";
            }
        } else {
            $this->mensaje = "FALTAN DATOS OBLIGATORIOS";
        }
    }

    function añadirAdministrador() {
        $this->vista = "gestion_Usuarios.php";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $contrasenia = $_POST['contrasenia'] ?? '';
            $tipo = 0;

            if (empty($nombre) || empty($email) || empty($contrasenia)) {
                $this->mensaje = "Todos los campos son obligatorios";
                return $this->listarAdministradores();
            }

            $resultado = $this->modelo->añadirAdministrador($nombre, $contrasenia, $email, $tipo);

            if (is_numeric($resultado)) {
                header("Location: index.php?controller=Administrador&action=listarAdministradores&mensaje=Administrador creado");
                exit();
            } else {
                $this->mensaje = "Error: " . $resultado;
            }
        }

        return $this->listarAdministradores();
    }

    function eliminarAdministrador() {
        $id = $_GET['id'] ?? 0;
        
        if ($id > 0) {
            $resultado = $this->modelo->eliminarAdministrador($id);
            
            if ($resultado === true) {
                header("Location: index.php?controller=Administrador&action=listarAdministradores&mensaje=Administrador eliminado");
            } else {
                header("Location: index.php?controller=Administrador&action=listarAdministradores&mensaje=Error: $resultado");
            }
            exit();
        }
        
        header("Location: index.php?controller=Administrador&action=listarAdministradores");
        exit();
    }

    function editarAdministrador() {
        $this->vista = "modificar_Usuario.php";
        
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $id = $_POST['id'] ?? 0;
            
            if (empty($nombre) || empty($email) || empty($id)) {
                $this->mensaje = "Datos incompletos";
                return ['administrador' => null];
            }
            
            $resultado = $this->modelo->modificarAdministrador($id, $nombre, $email, 0);
            
            if ($resultado === true) {
                header("Location: index.php?controller=Administrador&action=listarAdministradores&mensaje=Administrador actualizado");
                exit();
            } else {
                $this->mensaje = $resultado;
                return ['administrador' => null];
            }
        }
        
        return ['administrador' => null];
    }

    function panelAdministrador() {
        $this->vista = "panelAdministrador.php";
        return $_SESSION['nombre'] ?? '';
    }

    function listarAdministradores() {
        $this->vista = "gestion_Usuarios.php";
        
        $resultado = $this->modelo->listarAdministradores();
        
        if (empty($resultado)) {
            return []; // Retornamos array vacío
        } else {
            return $resultado;
        }
    }
    
    function cerrarSesion() {
        $this->vista = "inicio_sesion_admin.php";
        session_destroy();
        // Opcional: Limpiar variables de sesión
        $_SESSION = array();
    }
}
?>