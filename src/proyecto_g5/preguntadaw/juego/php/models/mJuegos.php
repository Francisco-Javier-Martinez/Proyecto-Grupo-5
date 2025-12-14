<?php
    require_once __DIR__ .'/../models/conexion.php';
    
    class Mjuegos extends Conexion{
    
        public function obtenerJuegosPublicos(){
            
            // 1. Consulta para obtener todos los juegos públicos con su información de tema,
            //    lo que resultará en múltiples filas por juego si tiene varios temas.
            $sql = "
                SELECT
                    juego.idJuego,
                    juego.descripcion AS titulo,
                    juego.publico,
                    tema.nombre AS nombre_tema,
                    tema.idTema
                FROM
                    juego
                JOIN
                    temas_juegos ON juego.idJuego = temas_juegos.idJuego
                JOIN
                    tema ON temas_juegos.idTema = tema.idTema
                WHERE
                    juego.publico = 1
                ORDER BY
                    juego.idJuego, tema.nombre;
            ";

            try {
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 2. Procesamiento de los resultados en PHP para agrupar los temas por juego.
                $juegos_agrupados = [];
                foreach ($resultados as $fila) {
                    $idJuego = $fila['idJuego'];

                    // Si el juego no ha sido inicializado en el array de agrupados, lo hacemos ahora.
                    if (!isset($juegos_agrupados[$idJuego])) {
                        $juegos_agrupados[$idJuego] = [
                            'idJuego' => $idJuego,
                            'titulo' => $fila['titulo'],
                            'publico' => $fila['publico'],
                            // Inicializamos temas como un array para la lógica posterior
                            'temas_nombres' => [], 
                            // Opcional: para el caso de devolver un array de objetos tema
                            'temas' => [],
                        ];
                    }

                    // Agregamos el nombre del tema para simular la funcionalidad de GROUP_CONCAT
                    $juegos_agrupados[$idJuego]['temas_nombres'][] = $fila['nombre_tema'];
                    
                    // También podemos devolver un array de temas, que es más útil
                    $juegos_agrupados[$idJuego]['temas'][] = [
                        'idTema' => $fila['idTema'],
                        'nombre' => $fila['nombre_tema']
                    ];
                }

                // 3. Formatear la salida para que 'temas_nombres' sea una cadena separada por '|' 
                //    y convertir el array asociativo de juegos en un array indexado de juegos.
                $juegos_final = [];
                foreach ($juegos_agrupados as $juego) {
                    // Convertimos el array de nombres de temas a una cadena separada por '|'
                    $juego['temas_nombres'] = implode('|', $juego['temas_nombres']);
                    
                    // Si solo necesitas el string de nombres y no el array de temas
                    unset($juego['temas']); 
                    
                    $juegos_final[] = $juego;
                }

                return $juegos_final;

            } catch (PDOException $e) {
                // Manejo de errores
                error_log("Error al obtener juegos públicos (sin GROUP_CONCAT): " . $e->getMessage());
                return []; // Retorna un array vacío en caso de error
            }
        }
        
        // --- Los otros métodos de la clase permanecen SIN CAMBIOS ---
        
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
                    juego.codigo = :codigo && habilitado = 1;
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