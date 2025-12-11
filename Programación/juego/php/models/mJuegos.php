<?php
    require_once __DIR__ .'/../models/conexion.php';
    
    class Mjuegos extends Conexion{
        
        public function obtenerJuegosPublicos(){
            //consulta para obtener juegos publicos
            //se obtienen los juegos por separado y luego sus temas
            $sql = "
                SELECT
                    juego.idJuego,
                    juego.descripcion AS titulo,
                    juego.publico
                FROM
                    juego
                WHERE
                    juego.publico = 1
                ORDER BY
                    juego.idJuego;
            ";

            try {
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute();
                $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Para cada juego, obtener sus temas asociados
                foreach ($juegos as &$juego) {
                    $sqlTemas = "
                        SELECT
                            tema.nombre
                        FROM
                            tema
                        JOIN
                            temas_juegos ON tema.idTema = temas_juegos.idTema
                        WHERE
                            temas_juegos.idJuego = :idJuego
                        ORDER BY
                            tema.nombre;
                    ";
                    
                    try {
                        $stmtTemas = $this->conexion->prepare($sqlTemas);
                        $stmtTemas->bindParam(':idJuego', $juego['idJuego'], PDO::PARAM_INT);
                        $stmtTemas->execute();
                        $temas = $stmtTemas->fetchAll(PDO::FETCH_COLUMN);
                        
                        // Devolver array de temas directamente, sin concatenar
                        $juego['temas'] = $temas;
                    } catch (PDOException $e) {
                        error_log("Error al obtener temas del juego: " . $e->getMessage());
                        $juego['temas'] = [];
                    }
                }
                
                return $juegos;
            } catch (PDOException $e) {
                // Manejo de errores
                error_log("Error al obtener juegos públicos: " . $e->getMessage());
                return false;
            }
        }
        //metodo para buscar un juego por su codigo
        public function buscarJuegoPorCodigo($codigo){
            $sql = "
                SELECT
                    juego.idJuego,
                    juego.descripcion AS titulo,
                    juego.codigo,
                    juego.publico
                FROM
                    juego
                WHERE
                    juego.codigo = :codigo;
            ";
            try {
                $stmt = $this->conexion->prepare($sql);
                // Usamos bindValue para mayor claridad y evitar conversiones inesperadas
                $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
                $stmt->execute();

                // Devuelve la primera fila como array asociativo o false si no la encuentra
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error al buscar juego por código: " . $e->getMessage());
                return false;
            }
        }
        
        //metodo para obtener los temas asociados a un juego por su id
        public function obtenerTemasPorJuego($idJuego){
            $sql = "
                SELECT tema.idTema, tema.nombre
                FROM tema
                JOIN temas_juegos ON tema.idTema = temas_juegos.idTema
                WHERE temas_juegos.idJuego = :idJuego
                ORDER BY tema.nombre
            ";
            try{
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindValue(':idJuego', (int)$idJuego, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e){
                error_log("Error al obtener temas por juego: " . $e->getMessage());
                return false;
            }
        }
    }
?>