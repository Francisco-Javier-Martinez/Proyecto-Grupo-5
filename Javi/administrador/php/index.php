<?php
    require_once __DIR__ . '/../../config/configBD.php';    
    //recoger controlador y metodo
    $controlador=$_GET['c'] ?? CONDEF;
    $metodo=$_GET['m'] ?? METDEF;

    // ruta del controlador
    $rutaControlador=__DIR__ . '/controlador/c' . $controlador . '.php';

    if (!file_exists($rutaControlador)) {
        die("Error: Controlador no encontrado en $rutaControlador");
    }
    require_once $rutaControlador;

    // crear el objeto controlador y instanciarlo
    $nombreClase='c' . $controlador; 
    $objControlador=new $nombreClase();
    
    $datos=$objControlador->$metodo();
    
    // llamar a la vista
    $vista = $objControlador->vistaCargar;
    if(!empty($objControlador->mensajeError)){
        // Loguear tipo y contenido antes de mostrar la vista de error (depuración)
        $mensaje_error_a_mostrar = $objControlador->mensajeError;
        $vista = 'error';
    }
    if ($vista) {
        if($vista=='error'){
            $rutaVista = __DIR__ . '/vistas/error.php';
            require_once $rutaVista;
            exit();
        }
        $rutaVista = __DIR__ . '/vistas/' . $vista;
        require_once $rutaVista;
    }
?>