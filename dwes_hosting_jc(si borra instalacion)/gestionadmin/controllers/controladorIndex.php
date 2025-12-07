<?php
    class ControladorIndex{
        public $vista;
        public $mensaje;
        function __construct(){
            $this->mensaje=null;
        }

        function vistaInicial(){
            $this->vista="inicio_sesion_admin.php";
  
        }

    }
?>