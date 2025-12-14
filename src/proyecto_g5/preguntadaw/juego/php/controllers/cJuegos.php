<?php
require_once __DIR__ . '/../models/mJuegos.php';

class CJuegos{
    private $modeloJuegos;
    public $mensaje;
    public $vista;
    public $juegos = [];
    public $temasRuleta = [];
    public $codigoBuscar = '';

    public function __construct(){
        $this->modeloJuegos = new Mjuegos();
        $this->mensaje = '';
        $this->vista = '';
    }
    //metodo para iniciar el juego y cargar la vista de seleccionJuego.php
    public function iniciarJuego(){
        // Cargar juegos públicos
        $this->juegos = $this->modeloJuegos->obtenerJuegosPublicos();
        if(empty($this->juegos)) {
            $this->mensaje = "No hay juegos públicos disponibles.";
            $this->juegos = [];
        }
        $this->vista = 'seleccionJuego.php';
        return $this->juegos;
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
        $codigo = isset($_REQUEST['codigoJuego']) ? trim($_REQUEST['codigoJuego']) : '';

        // Cargar lista de juegos públicos para mostrar por defecto
        $this->juegos = $this->modeloJuegos->obtenerJuegosPublicos();

        // Validación básica: no vacío y longitud máxima 7
        if ($codigo === '' || strlen($codigo) > 7) {
            $this->mensaje = 'Ha de ser máximo 7 caracteres';
            $this->vista = 'seleccionJuego.php';
            return null;
        }

        // Búsqueda en la BD
        $juego = $this->modeloJuegos->buscarJuegoPorCodigo($codigo);

        if ($juego && !empty($juego)) {
            // El juego existe: redirigir al servidor para cargar la ruleta usando MVC
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
            $this->mensaje = 'Código de juego no existente';
                            header('Location: ./index.php?controller=Juegos&action=iniciarJuego');
            //$this->vista = 'seleccionJuego.php';
            return null;
        }
    }

    //metodo para mostrar la ruleta con los temas del juego seleccionado
    public function mostrarRuleta(){
        if(!isset($_GET['idJuego'])) {
            $this->vista = 'seleccionJuego.php';
            return [];
        }
        $idJuego = (int)$_GET['idJuego'];
        //guardarme el idJuego en un session para usarlo despues
        session_start();
        $_SESSION['idJuego'] = $idJuego;
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