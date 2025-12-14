<?php
    require_once __DIR__ .'/../models/conexion.php';

    class MJugador extends Conexion{

        function guardarJugador($nombre, $idPersonaje){
            $sql="INSERT INTO jugador (nombre, idPersonaje) VALUES (:nombre, :idPersonaje)";
            $preparacion=$this->conexion->prepare($sql);
            $preparacion->bindValue(':idPersonaje', (int)$idPersonaje, PDO::PARAM_INT);
            $preparacion->bindValue(':nombre', $nombre, PDO::PARAM_STR);

            $preparacion->execute();

            if ($preparacion->rowCount() > 0) {
                return $this->conexion->lastInsertId();
            } else {
                return false;
            }
        }
    }
?>