<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correcto</title>
    <link rel="stylesheet" href="./views/css/stylesPanelP.css">
</head>
<body id="pagina-correcto">
    <h1>Pregunta añadida correctamente</h1>
    <a href="index.php?controller=PreguntasRespuestas&action=mostrarNuevaPregunta&idTema=<?php echo $_GET['idTema']; ?>">Añadir otra pregunta</a>
    <a href="index.php?controller=Temas&action=listarTemas">Volver a gestión de temas</a>
</body>
</html>