<?php
require_once __DIR__ . '/../models/conexion.php';

class Mpersonaje extends Conexion {

    // Obtener todos los avatares
    public function getAvatares() {
        try {
            $sql = "SELECT * FROM personajes";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Insertar avatar
    public function insertarAvatar($nombre, $imagenBinaria) {
        try {
            $sql = "INSERT INTO personajes (nombre, imagen) VALUES (:nombre, :imagen)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":imagen", $imagenBinaria, PDO::PARAM_LOB);
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    // Borrar avatar
    public function borrarAvatar($idPersonaje) {
        try {
            $sql = "DELETE FROM personajes WHERE idPersonaje=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(":id", $idPersonaje);
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>
