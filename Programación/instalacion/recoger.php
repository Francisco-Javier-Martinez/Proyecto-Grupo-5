<?php
    require_once __DIR__ . "/instalacionsuperAdministrador.php";

	/*function eliminarInstalacion($ruta){
          //Crear array con todo lo que hay dentro de la carpeta $ruta
       // Todos los archivos y carpetas dentro
        $items = glob($ruta . '/*');

        foreach ($items as $item) {
            if (is_file($item)) {
                // Si es archivo, borrarlo(conexion.php, index.php,. instalacionSuperAdmin,php, jc.css, recoger.php)
                unlink($item);
            } else if(is_dir($item)) {
                // Si es carpeta, primero borrar todos los archivos dentro (config -> configdb.php, img->preguntadawLogo.png)
                foreach (glob($item . '/*') as $archivo){ //recorre la subcarpeta, eliminando todos sus archivos
                    unlink($archivo);
                }
                // Luego borrar la carpeta vacía
                rmdir($item); //config e img
            }
        }

        // Salir de la carpeta instalacion y borrar la carpeta vacía
        chdir('..'); //Nos posicionamos un nivel más atrás, en raiz
        rmdir('instalacion'); //eliminamos la carpeta instalación
    }*/
	
    $objAdmin = new IntroducirSuperAdministrador;
    if(!empty($_POST['email']) && !empty($_POST['nombre']) && !empty($_POST['password'])){
        $email=$_POST['email'];
        $nombre=$_POST['nombre'];
        $password=$_POST['password'];
        $tipo=$_GET['tipo'];
        
        $passwordEncript=password_hash($password, PASSWORD_DEFAULT);
        $resultado=$objAdmin->introducirSuperAdmin($nombre, $passwordEncript, $email,  $tipo);
        if($resultado){
			//eliminarInstalacion(__DIR__); //PASA LA RUTA ACTUAL
            $mensaje= "ADMINISTRADOR INTRODUCIDO CORRECTAMENTE";
			header("Location: ../gestionadmin/index.php?mensaje=" . $mensaje);
            exit();
        }else{
            $mensaje= "ERROR AL INTRODUCIR EL SUPERADMINISTRADOR";
        }
    }else{
        $mensaje= "ERROR, FALTAN DATOS OBLIGATORIOS";
    }
    header("Location: index.php?mensaje=" . $mensaje);
    exit();

?>