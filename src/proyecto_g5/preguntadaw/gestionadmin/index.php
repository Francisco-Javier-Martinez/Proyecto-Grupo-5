<?php
    require_once __DIR__ . "/php/config/configrt.php";

    if(!isset($_GET['controller'])){
        $controlador=DEFAULT_CONTROLLER;
    }else{
        $controlador=$_GET['controller'];
    }

    if(!isset($_GET['action'])){ /*Le he llamado action porque me resulta más sencillo. Action es el método*/
        $action = DEFAULT_ACTION;
    }else{
        $action=$_GET['action']; 
    }

    //ponemos la ruta del controlador en una variable para que sea más facil
    //concatenamos el archivo del controlador

    $rutaControlador = "php/controllers/c".$controlador.".php";

    //incluimos el controlador
    include $rutaControlador;

    //ponemos la clase del controlador concatenada
    $nombreClase= "C".$controlador;
    $controlador = new $nombreClase();
    //ejecutamos la accion / metodo
    $datos=$controlador->$action();
    
    if($controlador->mensaje!=null){ //Si hay mensaje de error / ejecución se visualiza SOLO si se ha cargado el mensaje. Si no ha cargado mensaje no se visualiza, ya que daría error en la vista
        $mensajeError = $controlador->mensaje;
    }else if(isset($_GET["mensaje"])){
        $mensajeError=$_GET["mensaje"];
    }

    if($controlador->vista != ''){
        require_once __DIR__ . "/php/views/".$controlador->vista;
    }
?>