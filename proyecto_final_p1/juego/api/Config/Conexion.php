<?php
// api/Config/Conexion.php
require_once "configdb.php";

class Conexion {
    public $conexion;

    public function __construct() {
        // Usar las constantes definidas en configdb.php
        $this->conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD);

        if ($this->conexion->connect_error) {
            // Lanzar una excepción para que el controlador/llamador lo gestione
            throw new Exception('MySQLi Error: ' . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>