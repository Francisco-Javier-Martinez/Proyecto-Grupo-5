<?php
require_once __DIR__ . '/../models/mUsuario.php';

class CUsuario {
    public $mensaje;
    public $vista;
    private $modeloUsuario;

    public function __construct(){
        $this->modeloUsuario = new MUsuario();
        $this->mensaje = '';
        $this->vista = '';
    }

    /**
     * Mostrar datos del usuario
     */
    public function verDatos(){
        session_start();
        $this->vista = 'verDatos.php';
        $usuario = $this->modeloUsuario->obtenerDatosUsuario($_SESSION['idUsuario'] ?? 0);
        return ['usuario' => $usuario];
    }

    //Generar código de recuperación y mostrarlo en pantalla

    public function generarCodigoRecuperacion(){
        session_start();
        $this->vista = 'codigo.php';
        $idUsuario = $_SESSION['idUsuario'] ?? 0;
        $usuario = $this->modeloUsuario->obtenerDatosUsuario($idUsuario);

        if(!$usuario){
            $this->mensaje = "Usuario no encontrado";
            return [];
        }

        // Generar código aleatorio de 7 caracteres
        $codigo = substr(strtoupper(bin2hex(random_bytes(4))), 0, 7);
        $caducidad = (new DateTime('+15 minutes'))->format('Y-m-d H:i:s');

        $res = $this->modeloUsuario->guardarCodigoRecuperacion($idUsuario, $codigo, $caducidad);
        if($res !== true){
            $this->mensaje = $res;
        }

        return ['usuario' => $usuario, 'codigo' => $codigo];
    }


    // Modificar la contraseña usando el código de recuperación

    public function modificarContraseña(){
        session_start();
        $this->vista = 'codigo.php';
        $idUsuario = $_SESSION['idUsuario'] ?? 0;
        $usuario = $this->modeloUsuario->obtenerDatosUsuario($idUsuario);

        if(!$usuario){
            $this->mensaje = "Usuario no encontrado";
            return [];
        }

        // Validar formulario
        if(!isset($_POST['contraseña'], $_POST['contraseña1'], $_POST['codigo'])){
            return ['usuario' => $usuario];
        }

        $contraseña = $_POST['contraseña'];
        $contraseña1 = $_POST['contraseña1'];
        $codigo = $_POST['codigo'];

        if($contraseña !== $contraseña1){
            $this->mensaje = "Las contraseñas no coinciden";
            return ['usuario' => $usuario];
        }

        if(!$this->modeloUsuario->verificarCodigo($idUsuario, $codigo)){
            $this->mensaje = "Código incorrecto o caducado";
            return ['usuario' => $usuario];
        }

        $hash = password_hash($contraseña, PASSWORD_DEFAULT);
        $res = $this->modeloUsuario->actualizarContrasenia($idUsuario, $hash);

        if($res === true){
            $this->mensaje = "Contraseña actualizada correctamente";
        } else {
            $this->mensaje = $res;
        }

        return ['usuario' => $usuario];
    }
}