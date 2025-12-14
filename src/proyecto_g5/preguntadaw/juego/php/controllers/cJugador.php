<?php
    require_once __DIR__ . '/../models/mJugador.php';

    class CJugador{
        private $modeloJugador;
        public $mensaje;
        public $vista;

        public function __construct(){
            $this->modeloJugador = new  MJugador();
            $this->mensaje = '';
            $this->vista = '';
        }
        
        function guardarJugador(){
            // Vista por defecto
            $this->vista = "iniciarJuego.html";

            if(!isset($_GET['nombre']) || !isset($_GET['idAvatar'])){
                $this->mensaje = "Faltan datos obligatorios.";
                $this->vista = "formJugador.html";
                return;
            }
            $nombre =$_GET['nombre'];
            $idAvatar =$_GET['idAvatar'];

            // Validar los datos
            if ($nombre === '' || $idAvatar <= 0) {
                $this->mensaje = "Todos los campos son obligatorios.";
                $this->vista = "formJugador.html";
                return;
            }

            try {
                //resultado guarda el id del jugador 
                $resultado = $this->modeloJugador->guardarJugador($nombre, $idAvatar);
                //si se guardo correctamente
                if ($resultado) {
                    // Guardar idJugador en sesión
                    session_start();
                    $_SESSION['idJugador'] = (int)$resultado;
                    
                    // Redirigir a la pantalla de juego
                    header('Location: ./index.php?controller=Juegos&action=iniciarJuego');
                    exit();
                } else {
                    $this->mensaje = "Error al guardar el jugador.";
                    $this->vista = "iniciarJuego.html";
                }
            } catch (Exception $e) {
                $this->mensaje = 'Error: ' . $e->getMessage();
                $this->vista = "iniciarJuego.html";
            }
        }
    }
?>