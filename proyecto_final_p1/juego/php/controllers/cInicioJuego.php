<?php
class CInicioJuego{
    public $mensaje;
    public $vista;

    public function __construct(){
        $this->mensaje = '';
        $this->vista = '';
    }
    
    public function mostrarInicioJuego(){
        $this->vista = 'iniciarJuego.html';
    }

    
}

?>