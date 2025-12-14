<?php
    require_once __DIR__ .'/../models/conexion.php';
    
    class MRanking extends Conexion{
        //metodo para cargar el ranking de un juego
        public function cargarRanking($idjuego){
            $sql = "SELECT j.nombre AS nombre_usuario, r.puntuacion AS puntaje
                    FROM ranking r 
                    INNER JOIN jugador j ON r.idJugador = j.idJugador 
                    WHERE r.idJuego = :idjuego 
                    ORDER BY r.puntuacion DESC
                    LIMIT 10";
            
            try {
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':idjuego', $idjuego, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                return false;
            }
        }
        
        //metodo para guardar el puntaje en el ranking del jugador
        public function guardarJugadorRanking($idUsuario, $idJuego, $puntuaje){
            // Corregido: Usar idJugador en lugar de idUsuario
            $sql = "INSERT INTO ranking (idJugador, idJuego, puntuacion) VALUES (:idJugador, :idJuego, :puntuaje);";
            
            try {
                $stmt = $this->conexion->prepare($sql);
                
                // Corregido: Usar :idJugador para el bind
                // Nota: la variable que llega ($idUsuario) contiene el ID del jugador, lo usamos para el bind
                $stmt->bindParam(':idJugador', $idUsuario, PDO::PARAM_INT);
                $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
                $stmt->bindParam(':puntuaje', $puntuaje, PDO::PARAM_INT);
                
                return $stmt->execute();
            } catch (PDOException $e) {
                // Opcional: Descomenta esto temporalmente para ver el error exacto si falla:
                // error_log("Error de inserción en ranking: " . $e->getMessage()); 
                return false;
            }
        }
    }

?>