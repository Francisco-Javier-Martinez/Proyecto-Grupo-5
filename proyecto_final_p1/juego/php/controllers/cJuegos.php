<?php
require_once __DIR__ . '/../models/mJuegos.php';

class CJuegos{
    private $modeloJuegos;
    public $mensaje;
    public $vista;
    public $juegos = [];
    public $codigoStatus;
    public $temasRuleta = [];
    public $codigoBuscar = '';

    public function __construct(){
        $this->modeloJuegos = new Mjuegos();
        $this->mensaje = '';
        $this->vista = '';
    }
    //metodo para cargar los juegos publicos
    public function cargarJuegosPublicos(){
        $this->juegos = $this->modeloJuegos->obtenerJuegosPublicos();
        if(empty($this->juegos)) {
            $this->mensaje = "No hay juegos públicos disponibles.";
        } else {
            $this->vista = 'seleccionJuego.php';
        }
        return $this->juegos;
    }
    
    public function validarYBuscarJuegoPorCodigo(){
        // Leer el código desde la petición (form POST/GET)
        $codigo = isset($_REQUEST['codigoJuego']) ? trim($_REQUEST['codigoJuego']) : '';

        // Inicializar estado
        $this->codigoStatus = null;

        // Cargar lista de juegos públicos para mostrar por defecto
        $this->juegos = $this->modeloJuegos->obtenerJuegosPublicos();

        // Validación básica: no vacío y longitud máxima 7
        if ($codigo === '' || strlen($codigo) > 7) {
            $this->codigoStatus = 'invalid-length';
            $this->mensaje = 'Ha de ser máximo 7 caracteres';
            $this->vista = 'seleccionJuego.php';
            return null;
        }

        // Búsqueda en la BD
        $juego = $this->modeloJuegos->buscarJuegoPorCodigo($codigo);

        if ($juego && !empty($juego)) {
            // El juego existe: redirigir al servidor para cargar la ruleta usando MVC
            $this->codigoStatus = 'existente';
            $this->mensaje = 'Código existente';
            $this->codigoBuscar = $codigo;
            // Si conocemos el idJuego, redirigimos a la página de la ruleta con el id
            if (isset($juego['idJuego']) && (int)$juego['idJuego'] > 0) {
                $id = (int)$juego['idJuego'];
                // Redirigir al front controller para que cargue la vista de la ruleta
                header('Location: index.php?controller=Juegos&action=mostrarRuleta&idJuego=' . $id);
                exit();
            }
            // Si por alguna razón no hay id, dejamos que la vista muestre el estado
            $this->vista = 'seleccionJuego.php';
            return $juego;
        } else {
            $this->codigoStatus = 'no-existe';
            $this->mensaje = 'Código de juego no existente';
            $this->vista = 'seleccionJuego.php';
            return null;
        }
    }

    /**
     * Cargar la vista de la ruleta para un juego concreto.
     * Espera recibir `idJuego` en la petición (GET/POST). Carga los temas
     * y muestra la vista `Ruleta-cusomizable-main/ruleta.php`.
     */
    public function mostrarRuleta(){
        $idJuego = isset($_REQUEST['idJuego']) ? (int)$_REQUEST['idJuego'] : 0;
        $this->temasRuleta = [];
        if ($idJuego > 0) {
            $this->temasRuleta = $this->modeloJuegos->obtenerTemasPorJuego($idJuego);
            // limitar a 4 temas por si acaso
            $this->temasRuleta = array_slice($this->temasRuleta, 0, 4);
        }
        $this->vista = 'Ruleta-cusomizable-main/ruleta.php';
        return $this->temasRuleta;
    }
}

?>