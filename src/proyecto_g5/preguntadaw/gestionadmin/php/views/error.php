<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="php/views/css/jc.css">
</head>
<body>
    <div style="text-align: center;">
        <h1 style="color: red;">¡ERROR!</h1>
        <h2>Ha ocurrido un problema al procesar tu solicitud.</h2>
        
        <?php 
        // si existe el mensaje de error lo muestro
        if (isset($mensaje)) {
            echo '<div>';
            echo '<h3>Detalle del Error:</h3>';
            echo '<p>' . $mensaje. '</p>';
            echo '</div>';
        } else {
            echo '<p>No se pudo obtener el detalle del error.</p>';
        }
        ?>
        <a href="./index.php?controller=Temas&action=listarTemas">Volver a gestion de temas</a>
    </div>
</body>
</html>