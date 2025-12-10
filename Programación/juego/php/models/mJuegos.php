<?php
    require_once __DIR__ .'/../models/conexion.php';
    
    class Mjuegos extends Conexion{
        
        public function obtenerJuegosPublicos(){
            //consulta para obtener juegos publicos junto con sus temas
            //nos la ha tenido que dar la ia porque nos eramos capaces de hacerla
            //la idea es usar GROUP_CONCAT para juntar los nombres de los temas en una sola columna separados por |
            //segun la explicacion de la ia
            $sql = "
                SELECT
                    juego.idJuego,
                    juego.descripcion AS titulo,
                    juego.publico,
                    GROUP_CONCAT(tema.nombre ORDER BY tema.nombre SEPARATOR '|') AS temas_nombres
                FROM
                    juego
                JOIN
                    temas_juegos ON juego.idJuego = temas_juegos.idJuego
                JOIN
                    tema ON temas_juegos.idTema = tema.idTema
                WHERE
                    juego.publico = 1
                GROUP BY
                    juego.idJuego, juego.descripcion, juego.publico
                ORDER BY
                    juego.idJuego;
            ";

            try {
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute();
                // Devuelve todos los juegos públicos con sus temas concatenados.
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Manejo de errores
                error_log("Error al obtener juegos públicos: " . $e->getMessage());
                return []; // Retorna un array vacío en caso de error
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