<?php
    require_once __DIR__ .'/../config/configdb.php';
    class Conexion{
        protected $conexion;

        public function __construct() {
            try {
                // Crear una nueva conexión PDO
                $this->conexion = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BBDD, USUARIO, PASSWORD);
                // Establecer el modo de error de PDO a excepción
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error conexión BD: " . $e->getMessage());
            }
        }
    }
?>
