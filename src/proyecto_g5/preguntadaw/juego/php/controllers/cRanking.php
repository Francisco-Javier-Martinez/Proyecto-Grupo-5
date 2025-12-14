<?php
require_once __DIR__ . '/../models/mRanking.php';
class cRanking{

    public $mensaje;
    public $vista;
    private $modelo;
    public function __construct(){
        $this->modelo = new MRanking();
        $this->mensaje = '';
        $this->vista = '';
    }
    //metodo para mostrar el ranking
    /*public function mostrarRanking(){
        $this->vista = 'ranking.php';
    }*/
    //metodo para insertar un jugador en el ranking
    public function meterJugadorRanking(){
        session_start();
        $idUsuario = $_SESSION['idJugador'];
        $idJuego = $_SESSION['idJuego'];
        $puntuacion = $_GET['puntos']; // Asumiendo que 'puntos' siempre existe
        
        $resultado = $this->modelo->guardarJugadorRanking($idUsuario, $idJuego, $puntuacion);
        
        if($resultado != false){
            header("Location: index.php?controller=Ranking&action=mostrarRanking");
            exit;
        }else{
            $this->mensaje = 'Error al insertar el jugador en el ranking';
            echo 'Error al insertar el jugador en el ranking';
                $this->vista = 'ranking.php'; // Si falla, sigue queriendo mostrar la vista, pero vacía
                return []; 
            }
    }
    
    public function mostrarRanking(){
        $this->vista = 'ranking.php';
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Comprobación de existencia de sesión (buena práctica)
        if (!isset($_SESSION['idJuego'])) {
            $this->mensaje = 'Error: ID de juego no encontrado en la sesión.';
        }else{
            $idJuego = $_SESSION['idJuego'];
            $ranking = $this->modelo->cargarRanking($idJuego);

            $ranking_formateado = [];
            if (is_array($ranking)) {
            foreach ($ranking as $index => $r) {
                $ranking_formateado[] = [
                    'puesto' => $index + 1,
                    'nombre' => $r['nombre_usuario'],
                    'puntos' => $r['puntaje']
                ];      
            }
                session_destroy();
            }
        }
        return $ranking_formateado; 
    }
}

?>