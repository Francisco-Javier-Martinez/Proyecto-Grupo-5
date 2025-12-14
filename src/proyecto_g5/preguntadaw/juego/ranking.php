<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clasificación</title>
        <link rel="stylesheet" href="css/jugadorT.css">
    </head>
    <body>
        <nav>
            <a href="index.php"><img src="imagenes/flecha.png"/></a>
        </nav>
        <header>
            <img src="imagenes/trofeo.png">
            <h1>Clasificación</h1>
        </header>   
        <main class="clasificacion">
            <?php
                if($datos){
                    foreach($datos as $dato){
                    echo '<div class="tarjetas">
                            <span class="puesto">'.$dato['puesto'].'</span>
                            <span class="nombre">'.$dato['nombre'].'</span>
                            <span class="puntos">'.$dato['puntos'].' pts</span>
                        </div>';
                    }
                }else{
                    echo '<p>No hay datos disponibles.</p>';
                }
            ?>
            <!-- <p class="top">Top 10 jugadores</p>
            <div class="tarjetas">
                <span class="puesto">10</span>
                <span class="nombre">Gamer300</span>
                <span class="puntos">800 pts</span>
            </div>  -->
        </main>
        <footer>
            Derechos reservados a la Escuela Virgen de Guadalupe
        </footer>
    </body>
</html>