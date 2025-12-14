<?php
    require_once __DIR__ . "/php/config/configrt.php";

    if (isset($_GET['controller'])) {
        $controlador = $_GET['controller'];
    } else {
        $controlador = DEFAULT_CONTROLLER;
    }

    // Normalizar la primera letra a mayúscula para coincidir con archivos `cNombre.php`
    $controlador = ucfirst($controlador);

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else { /*Le he llamado action porque me resulta más sencillo. Action es el método*/
        $action = DEFAULT_ACTION;
    }

    //ponemos la ruta del controlador en una variable para que sea más facil
    //concatenamos el archivo del controlador

    $rutaControlador = __DIR__ . "/php/controllers/c".$controlador.".php";

    //incluimos el controlador
    if(file_exists($rutaControlador)){
        include $rutaControlador;
    }else{
        die("Error: Controlador no encontrado: " . $controlador);
    }

    //ponemos la clase del controlador concatenada
    $nombreClase= "C".$controlador;
    
    if(!class_exists($nombreClase)){
        die("Error: Clase no encontrada: " . $nombreClase);
    }
    
    $controlador = new $nombreClase();
    
    //ejecutamos la accion / metodo
    if(!method_exists($controlador, $action)){
        die("Error: Acción '$action' no encontrada en controlador '$nombreClase'");
    }
    
    // Ejecutar la acción del controlador
    $datos = $controlador->$action();
    
    if(isset($controlador->mensaje) && $controlador->mensaje!=''){
        $mensajeError = $controlador->mensaje;
    }else if(isset($_GET["mensaje"])){
        $mensajeError = $_GET["mensaje"];
    }

    if(!isset($datos)){
        $datos = [];
    }
    
    $vistaPath = __DIR__ . "/" . $controlador->vista;
    if(!file_exists($vistaPath)){
        die("Error: Vista no encontrada: " . $controlador->vista);
    }
    require_once $vistaPath;
?>