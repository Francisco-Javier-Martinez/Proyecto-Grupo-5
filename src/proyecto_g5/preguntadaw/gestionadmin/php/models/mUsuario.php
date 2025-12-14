<?php
require_once __DIR__ . '/../models/conexion.php';

class MUsuario extends Conexion {

    /**
     * Obtener datos de un usuario por ID
     */
    public function obtenerDatosUsuario($idUsuario){
        try {
            $sql = "SELECT idUsuario, nombre, email, tipo FROM usuarios WHERE idUsuario = :idUsuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario ?: null;
        } catch(PDOException $e) {
            return null;
        }
    }

    /**
     * Guardar código de recuperación en la base de datos
     */
    public function guardarCodigoRecuperacion($idUsuario, $codigo, $caducidad){
        try {
            // Creamos tabla si no existe
            $sqlCrear = "CREATE TABLE IF NOT EXISTS recuperacion (
                idUsuario SMALLINT UNSIGNED NOT NULL,
                codigo CHAR(7) NOT NULL,
                caducidad DATETIME NOT NULL,
                PRIMARY KEY(idUsuario),
                CONSTRAINT fk_recuperacion_usuario FOREIGN KEY(idUsuario) REFERENCES usuarios(idUsuario)
                    ON DELETE CASCADE
            )";
            $this->conexion->exec($sqlCrear);

            // Insertar o actualizar código
            $sql = "REPLACE INTO recuperacion (idUsuario, codigo, caducidad) 
                    VALUES (:idUsuario, :codigo, :caducidad)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindParam(':caducidad', $caducidad, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch(PDOException $e){
            return 'Error al guardar código: ' . $e->getMessage();
        }
    }

    /**
     * Verificar que el código de recuperación sea válido y no esté caducado
     */
    public function verificarCodigo($idUsuario, $codigo){
        try {
            $sql = "SELECT codigo, caducidad FROM recuperacion 
                    WHERE idUsuario = :idUsuario AND codigo = :codigo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$resultado) return false;

            $ahora = new DateTime();
            $caducidad = new DateTime($resultado['caducidad']);

            return $ahora <= $caducidad;
        } catch(PDOException $e){
            return false;
        }
    }

    /**
     * Actualizar la contraseña del usuario
     */
    public function actualizarContrasenia($idUsuario, $hash){
        try {
            $sql = "UPDATE usuarios SET contrasenia = :hash WHERE idUsuario = :idUsuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0 ? true : "No se pudo actualizar la contraseña";
        } catch(PDOException $e){
            return 'Error al actualizar contraseña: ' . $e->getMessage();
        }
    }
}