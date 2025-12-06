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
    $vista = $objControlador->vista;
    $mensaje = $objControlador->mensaje;

    // ruta de la vista
    $rutaVista=__DIR__ . '/vistas/' . $vista;
    //verificar que la vista existe
    if (!file_exists($rutaVista)) {
        die("Error FATAL: La vista '$vista' no se pudo encontrar en la ruta: $rutaVista");
    }
    //incluir la vista
    require_once $rutaVista;
?>