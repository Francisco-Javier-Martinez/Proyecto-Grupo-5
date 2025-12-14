<?php
require_once __DIR__ .'/../models/conexion.php';
class mJuego extends Conexion {
    
    public function crearJuegoConTemas($descripcion, $publico, $temasIds, $habilitado, $idUsuario) {
     try {
        // Generar código único
        $codigo = $this->generarCodigoUnico();
        
        // Iniciar transacción
        $this->conexion->beginTransaction();

        // 1. Insertar el juego - ¡CAMBIO CLAVE AQUÍ!
        // Usamos la función FIELD para asegurar que MySQL interprete el 1 o 0 como el valor BIT/BOOL deseado.
        $sqlJuego = "INSERT INTO juego (descripcion, codigo, publico, idUsuario, habilitado) 
                        VALUES (?, ?, FIELD(?, 0, 1) - 1, ?, FIELD(?, 0, 1) - 1)";
        
        // Explicación de FIELD(?, 0, 1) - 1:
        // Si publico es 1, FIELD retorna 2. (2 - 1 = 1)
        // Si publico es 0, FIELD retorna 1. (1 - 1 = 0)
        // Esto fuerza el resultado a 0 o 1, sin que MySQL lo interprete como cadena.
            
        $stmtJuego = $this->conexion->prepare($sqlJuego);
        $stmtJuego->execute([
            $descripcion, 
            $codigo, 
            (int)$publico,       // Valor de publico (0 o 1)
            (int)$idUsuario, 
            (int)$habilitado      // Valor de habilitado (0 o 1)
        ]); 
        
        $idJuego = $this->conexion->lastInsertId();

        // 2. Insertar relaciones en temas_juegos 
        $sqlRelacion = "INSERT INTO temas_juegos (idTema, idJuego) VALUES (?, ?)";
        $stmtRelacion = $this->conexion->prepare($sqlRelacion);

        foreach ($temasIds as $idTema) {
            $stmtRelacion->execute([(int)$idTema, (int)$idJuego]); 
        }

        // Confirmar transacción
        $this->conexion->commit();


        return [
            'success' => true,
            'idJuego' => $idJuego,
            'codigo' => $codigo
        ];

    } catch (PDOException $e) {
        // Revertir en caso de error
        if ($this->conexion->inTransaction()) {
            $this->conexion->rollBack();
        }
        
    }
}

    
    private function generarCodigoUnico() {
        do {
            $codigo = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 7);
            
            $sql = "SELECT COUNT(*) as count FROM juego WHERE codigo = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$codigo]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
        } while ($result['count'] > 0);
        
        return $codigo;
    }
    
    public function verificarJuegoExistente($descripcion, $idUsuario) {
        $sql = "SELECT COUNT(*) as count FROM juego 
                WHERE descripcion = ? AND idUsuario = ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$descripcion, $idUsuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0;
    }
    
    public function obtenerJuegosPorUsuario($idUsuario) {
        $sql = "SELECT j.*, COUNT(tj.idTema) as num_temas 
                FROM juego j 
                LEFT JOIN temas_juegos tj ON j.idJuego = tj.idJuego 
                WHERE j.idUsuario = ? 
                GROUP BY j.idJuego 
                ORDER BY j.idJuego DESC";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idUsuario]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerJuegos($idUsuario) {
        $sql = "
            SELECT
                juego.idJuego,
                juego.descripcion,
                juego.publico,
                juego.habilitado,
                juego.codigo
            FROM
                juego
            WHERE
                juego.idUsuario = ?
            ORDER BY
                juego.idJuego DESC;
        ";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$idUsuario]);
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
                    $stmtTemas->bindValue(':idJuego', (int)$juego['idJuego'], PDO::PARAM_INT);
                    $stmtTemas->execute();
                    $temas = $stmtTemas->fetchAll(PDO::FETCH_COLUMN);
                    
                    // Añadir temas al array del juego
                    $juego['temas'] = $temas;
                } catch (PDOException $e) {
                    error_log("Error al obtener temas del juego: " . $e->getMessage());
                    $juego['temas'] = [];
                }
            }
            
            return $juegos;
        } catch (PDOException $e) {
            error_log("Error al obtener juegos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerJuegoPorId($idJuego) {
        $sql = "SELECT * FROM juego WHERE idJuego = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idJuego]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarJuego($idJuego, $titulo, $publico, $habilitado) {
        try {
            $sql = "UPDATE juego 
                    SET descripcion = ?, publico = b?, habilitado = b?
                    WHERE idJuego = ?";
            
            $stmt = $this->conexion->prepare($sql);
            $resultado = $stmt->execute([
                $titulo,      
                $publico,
                $habilitado,
                $idJuego
            ]);
            
            return $resultado;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar juego: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarRelacionesTemas($idJuego) {
        $sql = "DELETE FROM temas_juegos WHERE idJuego = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$idJuego]);
    }

    public function eliminarJuego($idJuego) {
        $sql = "DELETE FROM juego WHERE idJuego = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$idJuego]);
    }

    public function verificarPropiedadJuego($idJuego, $idUsuario) {
        $sql = "SELECT idUsuario FROM juego WHERE idJuego = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idJuego]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($resultado && $resultado['idUsuario'] == $idUsuario);
    }
}
?>