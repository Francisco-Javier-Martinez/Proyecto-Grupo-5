<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juegos Disponibles</title>
    
    <link rel="stylesheet" href="css/seleccionJuego.css">
</head>
<body id="elegirJuego">

<header>
    <h1 id="nombreJugador">BIENVENIDO, +nombreJugador</h1>
</header>

<main>
    
    <section class="codigo">
        <form action="index.php?controller=Juegos&action=validarYBuscarJuegoPorCodigo" id="seleccionJuegoForm" method="post">
            <h2>¿Tienes un código de juego?</h2>
            <input type="text" name="codigoJuego" placeholder="Introduce tu código" id="codigoJuego">
            <input type="submit" value="Enviar">
            <p id="mensajeCodigo" class="mensaje-error-inline" style="display:none; text-align:center; margin-top:8px;"></p>
        </form>
    </section>
    <?php
        // Si hay mensaje de error (por ejemplo: código no encontrado), NO mostramos los juegos
        if(!isset($mensajeError) || $mensajeError === ''){
            if(!empty($controlador->juegos)){
                echo "<h2>JUEGOS DISPONIBLES</h2>";
                echo "<section class='grid-juegos'>";
                foreach($controlador->juegos as $juego){
                    $temas = explode('|', $juego['temas_nombres']);
                    $idJ = isset($juego['idJuego']) ? $juego['idJuego'] : '';
                    echo "<div class='tarjeta'>";
                    echo "  <div class='tarjeta-header'>";
                    echo "    <h3>" . $juego['titulo'] . "</h3>";
                    echo "    <span class='estado'>Público</span>";
                    echo "  </div>";
                    echo "  <div class='temas'>";
                    foreach($temas as $tema){
                        echo "<button>" . $tema . "</button>";
                    }
                    echo "  </div>";
                    // Usar enlace MVC hacia el index para que el controlador cargue la ruleta
                    echo "  <a class='jugar' href='index.php?controller=Juegos&action=mostrarRuleta&idJuego=" . $idJ . "'>Jugar</a>";
                    echo "</div>";
                }
                echo "</section>";
            }
        }
    ?>


</main>
<script type="module" src="./js/app.js"></script>
</body>
</html>
