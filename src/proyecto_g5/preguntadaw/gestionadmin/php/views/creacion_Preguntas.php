<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="php/views/css/jc.css">
    <title>Creación de preguntas</title>
</head>
<body id="gestionPreguntas">
    <header>
        <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        <h1>Preguntas/Respuestas</h1>
    </header>
    <main >
        <form action="./index.php?controller=PreguntasRespuestas&action=meterPreguntas&idTema=<?php echo $_GET['idTema']; ?>" method="post" id="formCrearPregunta" enctype="multipart/form-data">            
            <label for="titulo">Título de la pregunta</label>
            <input type="text" id="titulo" name="titulo">
            <p id="titulo-error"></p>

            <label for="puntos">Puntos</label>
            <input type="number" id="puntuacion" name="puntuacion">
            <p id="puntos-error"></p>

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" name="imagenPregunta">
            <p id="imagen-error"></p>

            <label for="explicacionPregunta">Explicación de la pregunta</label>
            <textarea name="explicacionPregunta" id="explicacionPregunta"></textarea>
            <p id="explicacion-error"></p>
            
            <h3>Respuestas</h3>
            <h3>Añadir respuestas</h3>
            <label for="respuesta1">Respuesta 1</label>
            <input type="text" id="respuesta1" name="respuestas[]">
            <p id="respuesta1-error"></p>

            <label for="respuesta2">Respuesta 2</label>
            <input type="text" id="respuesta2" name="respuestas[]">
            <p id="respuesta2-error"></p>

            <label for="respuesta3">Respuesta 3</label>
            <input type="text" id="respuesta3" name="respuestas[]">
            <p id="respuesta3-error"></p>

            <label for="respuesta4">Respuesta 4</label>
            <input type="text" id="respuesta4" name="respuestas[]">
            <p id="respuesta4-error"></p>
            <div id="contenedorRespuestas">
                <div>
                    <input type="radio" id="opcion1" name="opcion" value="a">
                    <label for="opcion1" id="label1">Respuesta1</label>
                </div>
                <div>

                    <input type="radio" id="opcion2" name="opcion" value="b">
                    <label for="opcion2" id="label2">Respuesta2</label>
                </div>
                <div>
                    <input type="radio" id="opcion3" name="opcion" value="c">
                    <label for="opcion3" id="label3">Respuesta3</label>
                </div>
                <div>
                    <input type="radio" id="opcion4" name="opcion" value="d">
                    <label for="opcion4" id="label4">Respuesta4</label>
                </div>
            </div>
            <input type="submit" value="Añadir">
        </form>
    </main>
   <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
    <script type="module" src="javaScript/app.js"></script>
</body>
</html>