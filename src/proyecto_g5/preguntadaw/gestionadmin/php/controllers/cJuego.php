<?php
// php/controllers/CJuego.php
require_once __DIR__ . '/../models/mJuego.php';
require_once __DIR__ . '/../models/modeloTemas.php';

class CJuego {
    private $modeloJuego;
    public $mensaje;
    public $vista;

    function __construct() {
        $this->modeloJuego = new mJuego();
        $this->mensaje = null;
    }

    // SOLO maneja POST (creación del juego)
    function crearJuego() {
        $this->vista = "creacion_Juegos.php";
        
        // Solo procesar si es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->procesarCreacion();
        }
        
        // Si es GET, solo mostrar formulario vacío
        return [];
    }
    
    private function procesarCreacion() {
        session_start();
        if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] == 0) {
            header("Location: index.php?controller=Administrador&action=iniciarSesion");
            exit();
        }

        $titulo = trim($_POST['tituloJuego'] ?? '');
        $temasIds = trim($_POST['temasSeleccionados'] ?? '');
        $idUsuario = $_SESSION['idUsuario'];
        $publico = isset($_POST['juegoPublico']) ? 1 : 0;
        $habilitado = isset($_POST['juegoHabilitado']) ? 1 : 0;

        // Convertir string "1,2,3,4" a array
        $temasArray = $temasIds ? explode(',', $temasIds) : [];
        $temasArray = array_filter($temasArray, 'is_numeric');
        $temasArray = array_unique($temasArray);

        // VALIDACIÓN DESPUÉS
        if (count($temasArray) !== 4) {
            $this->mensaje = "Debes seleccionar exactamente 4 temas";
            return [];
        }

        $resultado = $this->modeloJuego->crearJuegoConTemas(
            $titulo, 
            $publico, 
            $temasArray,
            $habilitado,
            $idUsuario 
        );
        
        if ($resultado['success']) {
            header("Location: index.php?controller=Juego&action=listarJuegos");
            exit();
        } else {
            $this->mensaje = " Error: " . $resultado['message'];
        }

        return [];
    }


    public function listarJuegos(){
        session_start();
        $this->vista = "panelAdministrador.php";
        
        $idUsuario = $_SESSION['idUsuario'] ?? 0;
        
        if ($idUsuario == 0) {
            header("Location: index.php?controller=Administrador&action=iniciarSesion");
            exit();
        }
        
        $juegos = $this->modeloJuego->obtenerJuegos($idUsuario);
        
        return ['juegos' => $juegos];
    }

    public function editarJuego() {
        session_start();
        $this->vista = "panelAdministrador.php";
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->mensaje = "Método no permitido";
            return [];
        }
        
        $idJuego = (int)$_POST['idJuego'];
        $titulo = trim($_POST['titulo']);
        $publico = (int)$_POST['publico']; 
        $habilitado = (int)$_POST['habilitado'];
        $idUsuario = $_SESSION['idUsuario'];
        
        
        // Validaciones básicas
        if ($idUsuario == 0) {
            $this->mensaje = "Debes iniciar sesión";
            return [];
        }
        
        if ($idJuego == 0) {
            $this->mensaje = "ID de juego no válido";
            return [];
        }
        
        if (empty($titulo)) {
            $this->mensaje = "El título es obligatorio";
            return [];
        }
        
        // Actualizar el juego
        $resultado = $this->modeloJuego->actualizarJuego(
            $idJuego,
            $titulo,
            $publico,
            $habilitado
        );
        
        if ($resultado) {
            $this->mensaje = "<h1>Juego actualizado correctamente</h1>";
        } else {
            $this->mensaje = "<h1>Error al actualizar el juego</h1>";
        }
        
        // Obtener la lista actualizada de juegos
        $juegos = $this->modeloJuego->obtenerJuegos($idUsuario);
        
        return ['juegos' => $juegos];
    }

    public function eliminarJuego() {
        $this->vista = "panelAdministrador.php";
        
        // Obtener datos
        $idJuego = $_POST['idJuego'] ?? $_GET['idJuego'] ?? 0;
        $idUsuario = $_SESSION['idUsuario'] ?? 0;
        
        // Verificar datos
        if ($idUsuario && $idJuego) {
            // 1. Eliminar relaciones con temas
            $this->modeloJuego->eliminarRelacionesTemas($idJuego);
            
            // 2. Eliminar el juego
            $resultado = $this->modeloJuego->eliminarJuego($idJuego);
            
            if ($resultado) {
                $this->mensaje = "<h1>Juego eliminado correctamente</h1>";
            } else {
                $this->mensaje = "<h1>Error al eliminar el juego</h1>";
            }
        }
        
        // Obtener lista actualizada
        $juegos = $this->modeloJuego->obtenerJuegos($idUsuario);
        
        return ['juegos' => $juegos];
    }

}