<?php
//este trozo es para recoger los temas que vienen del controlador
    $temas = [];
    if (isset($datos) && is_array($datos) && isset($datos['temasRuleta']) && is_array($datos['temasRuleta'])) {
        $temas = $datos['temasRuleta'];
    } elseif (isset($controlador) && is_object($controlador) && isset($controlador->temasRuleta) && is_array($controlador->temasRuleta)) {
        // Compatibilidad legacy: el controlador antiguo podía exponer la propiedad.
        $temas = $controlador->temasRuleta;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    // Calcular la URL base para los assets de la ruleta.
    // Si la vista se sirve desde el front controller `index.php`, `dirname($_SERVER['SCRIPT_NAME'])`
    // apuntará a la carpeta del front (por ejemplo `/preguntadaw/juego`) y necesitaremos añadir
    // la carpeta `Ruleta-cusomizable-main`. Si la vista se abre directamente, el dirname
    // ya contendrá `Ruleta-cusomizable-main`.
    $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $ruletaBaseUrl = $scriptDir;
    if (basename($ruletaBaseUrl) !== 'Ruleta-cusomizable-main') {
        $ruletaBaseUrl = $ruletaBaseUrl . '/Ruleta-cusomizable-main';
    }
    ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($ruletaBaseUrl); ?>/style.css">
    <title>Ruleta</title>
    <script>
        // Inyectar temas desde servidor para que el JS los use directamente
        //json_encode con JSON_HEX_TAG para evitar inyección de HTML
        window.ruletaTemas = <?php echo json_encode($temas, JSON_HEX_TAG); ?>;
    </script>
    <script>
        // Escritura directa en el DOM para depuración (asegura que se vea sin abrir consola)
        // Debug DOM removed for production
    </script>
</head>
<body>
    <div id="container">
        <!-- Título -->
        <h1>¡A jugar!</h1>

        <!-- Marcador -->
        <div id="marcador">
            <div id="cartelGanador">
                <p id="ganadorTexto">¡Click en "Girar" para iniciar!</p>
            </div>
        </div>

        <!-- Ruleta -->
        <div id="pointer" aria-hidden="true"></div>
        <div id="ruleta">
            <div id="sortear" role="button" tabindex="0"><div class="btnInner">GIRAR</div></div>
        </div>
    </div>

    <!-- Panel de temas eliminado (depuración) -->

    <!-- Modal -->
    <dialog>
        <div id="tituloForm">
            <p>Nombre</p>
            <p>Probabilidad (%)</p>
        </div>
        <div id="formContainer"></div>
        <button id="agregar">+</button>
        <p>Total: <span id="porcentaje"></span>%</p>
        <button id="aceptar">Cambiar</button>
        <button id="cancelar">Cancelar</button>
    </dialog>

    <script src="<?php echo htmlspecialchars($ruletaBaseUrl); ?>/js/helpers.js"></script>
    <script src="<?php echo htmlspecialchars($ruletaBaseUrl); ?>/js/index.js" defer></script>
</body>
</html>
