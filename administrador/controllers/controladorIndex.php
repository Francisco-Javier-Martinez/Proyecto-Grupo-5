<?php
    class ControladorIndex{
        public $vista;

        function iniciarVista(){
            $this->vista="inicio_sesion_admin.html";
           // $this->vista="instalacion.html";
        }
        public function inicio() {
        // Aquí puedes cargar datos si los necesitas
        $this->vista = 'panelAdministrador.html'; 
        }
    }
?>