<?php
require_once __DIR__ ."/../models/modeloAdministrador.php";

class CAdministrador {
    private $modelo;
    public $mensaje;
    public $vista;

    function __construct() {
        $this->modelo = new ModeloAdministrador();
        $this->mensaje = null;
            
    }

    function vistaInicial() {
        $this->vista = "inicio_sesion_admin.php";
    }

    function volverPanelInicial() {
        $this->vista = "panelAdministrador.php";
    }

    function vistaGestionAvatares(){
        $this->vista="gestionAvatares.php";
    }
    
    function iniciarSesion() {
        $this->vista = "inicio_sesion_admin.php";
        session_start();

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $resultado = $this->modelo->iniciarSesion($email);

            if ($resultado && password_verify($password, $resultado["contrasenia"])) {
                $_SESSION['idUsuario'] = $resultado['idUsuario'];
                $_SESSION['nombre'] = $resultado['nombre'];
                $_SESSION['tipo'] = $resultado['tipo']; //tipo de administrador (super o profesor. Lo necesitaremos para el nav)
                
                // Redirigir directamente a listar juegos
                header("Location: index.php?controller=Juego&action=listarJuegos");
                exit();
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

            $resultado = $this->modelo->añadirAdministrador($nombre, $contrasenia, $email, $tipo);

            if (is_numeric($resultado)) {
                header("Location: index.php?controller=Administrador&action=listarAdministradores&mensaje=Administrador agregado correctamente");
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
        $id = $_GET['id'] ?? 0;
        
        // Si es una petición GET, mostrar formulario con datos actuales
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id > 0) {
            $this->vista = "modificar_Usuario.php";
            $administrador = $this->modelo->traerAdministrador($id);
            
            if ($administrador) {
                return ['administrador' => $administrador];
            } else {
                $this->mensaje = "Administrador no encontrado";
                header("Location: index.php?controller=Administrador&action=listarAdministradores");
                exit();
            }
        }
        
        // Si es una petición POST, procesar la actualización
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $nombre = trim($_POST['userName'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            if (empty($nombre) || empty($email) || empty($id)) {
                $this->mensaje = "Datos incompletos";
                $this->vista = "modificar_Usuario.php";
                
                // CORRECCIÓN: Usar traerAdministrador
                $administrador = $this->modelo->traerAdministrador($id);
                return ['administrador' => $administrador];
            }
            
            // CORRECCIÓN: Pasar solo 3 parámetros
            $resultado = $this->modelo->modificarAdministrador($id, $nombre, $email);
            
            if ($resultado === true) {
                header("Location: index.php?controller=Administrador&action=listarAdministradores&mensaje=Administrador actualizado");
                exit();
            } else {
                $this->mensaje = $resultado;
                $this->vista = "modificar_Usuario.php";
                
                // CORRECCIÓN: Usar traerAdministrador
                $administrador = $this->modelo->traerAdministrador($id);
                return ['administrador' => $administrador];
            }
        }
        
        // Si no es GET ni POST válido, redirigir
        header("Location: index.php?controller=Administrador&action=listarAdministradores");
        exit();
    }

    function panelAdministrador() {
        session_start();
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
        session_start();
        session_destroy();
        // Opcional: Limpiar variables de sesión
        $_SESSION = array();
    }
}
?>