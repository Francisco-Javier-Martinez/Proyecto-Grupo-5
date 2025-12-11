<?php
require_once __DIR__ . '/../models/mPersonaje.php';

class cPersonajes {
    private $modelo;
    public $vista;
    public $mensaje;

    public function __construct() {
        $this->modelo = new Mpersonaje();
        $this->vista = '';
        $this->mensaje = '';
    }

    // Mostrar avatares
    public function mostrarAvatares() {
        $this->vista = "gestionAvatares.php";
        return $this->modelo->getAvatares();
    }

    // Insertar avatar
    public function crearAvatar() {
        $this->vista = "gestionAvatares.php";

        if (!isset($_FILES['imagenSubidaAvatar'])) {
            $this->mensaje = "No se recibió la imagen";
            return false;
        }

        $imagen = file_get_contents($_FILES['imagenSubidaAvatar']['tmp_name']);
        $nombreAvatar = trim($_POST['nombreAvatar']);

        if ($nombreAvatar == '') {
            $this->mensaje = "El nombre no puede ir vacío";
            return false;
        }

        $ok = $this->modelo->insertarAvatar($nombreAvatar, $imagen);

        if ($ok) {
            header("Location: ./index.php?controller=Personajes&action=mostrarAvatares&mensaje=Avatar creado");
            exit;
        } else {
            $this->mensaje = "Error guardando avatar.";
            return false;
        }
    }

    // Borrar avatar
    public function borrarAvatar() {
        $id = $_GET['id'];

        $ok = $this->modelo->borrarAvatar($id);

        if ($ok) {
            header("Location: ./index.php?controller=Personajes&action=mostrarAvatares&mensaje=Borrado");
            exit;
        } else {
            $this->mensaje = "Error borrando avatar";
        }

        $this->vista = "gestionAvatares.php";
    }
}
?>
