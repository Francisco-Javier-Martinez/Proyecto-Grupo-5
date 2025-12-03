<?php
    require_once 'config/configdb.php';

    class Conexion{
        protected $conexion;

        function __construct(){
            try{
                // DSN: cadena necesaria para que PDO sepa cómo conectarse.
                // Indica motor (mysql), servidor (SERVIDOR), base de datos (BBDD)
                $dsn = "mysql:host=" . SERVIDOR . ";dbname=" . BBDD . ";charset=utf8mb4";

                // Nueva forma de conectarse usando PDO (sustituye a new mysqli)
                $this->conexion = new PDO($dsn, USUARIO, PASSWORD);

                // Activa el modo de errores de PDO para que lance excepciones. En mysqli vienen activado por defecto, en PDO no
                // Similar a que mysqli lance excepciones pero más uniforme.
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Establece que los resultados se devuelvan como arrays asociativos.
                // Para no tener que usar fetch_assoc manualmente.
                $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            }catch(PDOException $e){
                die("FALLO EN LA CONEXIÓN CON LA BASE DE DATOS");
            }
        }

        function obtenerConexion(){
            return $this->conexion;
        }

        function __destruct(){
            // En PDO no existe close(), se cierra poniendo la conexión a null
            $this->conexion = null;
        }
    }
?>
