<?php
    require_once "config/configdb.php";

    if(!isset($_GET['controller'])){
        $controlador=DEFAULT_CONTROLLER;
    }else{
        $controlador=$_GET['controller'];
    }

    if(!isset($_GET['action'])){
        $action = DEFAULT_ACTION;
    }else{
        $action=$_GET['action'];
    }

    //ponemos la ruta del controlador en una variable para hacerlo más sencillo
    $rutaControlador = "controllers/".$controlador.".php";

    //incluimos el controlador
    include $rutaControlador;

    $controlador = new $controlador();
    //ejecutamos la accion
    $datos=$controlador->$action();
    
    include "views/".$controlador->vista;

?>