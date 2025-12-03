<?php
    // Asegúrate de que configdb.php existe en la carpeta config/
    require_once __DIR__ . '/config/configdb.php'; 

    // Recoger controlador y metodo
    $controlador=$_GET['controller'] ?? DEFAULT_CONTROLLER;
    $metodo=$_GET['action'] ?? DEFAULT_ACTION;

    // Ruta del controlador (CORRECTA, busca controllers/controladorIndex.php)
    $rutaControlador = __DIR__ . '/controllers/' . $controlador . '.php';

    if (!file_exists($rutaControlador)) {
        // En un entorno de producción, es mejor redirigir a una página de error que usar die()
        die("Error: Controlador no encontrado en $rutaControlador"); 
    }
    require_once $rutaControlador;
    // $controlador ya contiene el nombre de la clase (e.g., 'controladorIndex').
    $nombreClase = $controlador; 
    $objControlador = new $nombreClase();
        
    $datos = $objControlador->$metodo();
    
    // Llamar a la vista
    // Se mantiene la variable de la vista que usaste: vistaCargar
    $vista = $objControlador->vista; 
    
    // Si hay errores, forzar la vista de error
    if(!empty($objControlador->mensajeError)){
        // Loguear tipo y contenido antes de mostrar la vista de error (depuración)
        $mensaje_error_a_mostrar = $objControlador->mensajeError;
        $vista = 'error';
    }
    
    if ($vista) {
        if($vista == 'error'){
            // Se usa 'views/' en lugar de 'vistas/' (la ruta views/ es más consistente con tu proyecto)
            $rutaVista = __DIR__ . '/views/error.php'; 
            require_once $rutaVista;
            exit();
        }
        // Se usa 'views/' en lugar de 'vistas/'
        $rutaVista = __DIR__ . '/views/' . $vista; 
        require_once $rutaVista;
    }
?>