<?php
// api/Config/Conexion.php
require_once "configdb.php";

class Conexion {
    public $conexion;  // Cambiado de protected a public
    
    public function __construct() {
        $this->conexion = new mysqli(host, user, password, database);
        
        if ($this->conexion->connect_error) {
            // Devuelve error en JSON
            die(json_encode([
                'success' => false,
                'error' => 'MySQLi Error: ' . $this->conexion->connect_error
            ]));
        }
        
        $this->conexion->set_charset("utf8");
    }
    
    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>