<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="php/views/css/jc.css">
    <title>Creación de preguntas</title>
</head>
<body id="modificarPreguntas">
    <header>
        <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        <h1>Preguntas/Respuestas</h1>
    </header>
    <main >
           <form action="index.php?controller=PreguntasRespuestas&action=modificarPregunta" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idTema" value="">
            <input type="hidden" name="nPregunta" value="">

            <label for="titulo">Nuevo Título de la pregunta</label>
            <input type="text" id="titulo" name="titulo" value="">
            <p id="titulo-error"></p>

            <label for="puntuacion">Puntos</label>
            <input type="number" id="puntuacion" name="puntuacion" value="">
            <p id="puntos-error"></p>

            <label for="imagen">Imagen actual</label>
            <div><img src="" alt="Imagen de la pregunta" id="imgenPregunta"></div>
            <h2>Imagen que estaba guardada</h2>
            <label for="imagen">Cambiar imagen de la pregunta, si no deseas se quedara guardada la que estaba</label>
            <input type="file" id="imagen" name="imagen">
            <p id="imagen-error"></p>

            <label for="explicacionPregunta">Explicación de la pregunta</label>
            <textarea name="explicacionPregunta" id="explicacionPregunta"></textarea>
            <p id="explicacion-error"></p>

            <h3>Respuestas</h3>
            <h4>Modificar Respuestas</h4>
            <label for="respuesta1">Respuesta 1</label>
            <input type="text" id="respuesta1" name="respuestas[]" value="">
            <p id="respuesta1-error"></p>

            <label for="respuesta2">Respuesta 2</label>
            <input type="text" id="respuesta2" name="respuestas[]" value="">
            <p id="respuesta2-error"></p>

            <label for="respuesta3">Respuesta 3</label>
            <input type="text" id="respuesta3" name="respuestas[]" value="">
            <p id="respuesta3-error"></p>

            <label for="respuesta4">Respuesta 4</label>
            <input type="text" id="respuesta4" name="respuestas[]" value="">
            <p id="respuesta4-error"></p>

            <div id="contenedorRespuestas">
                <div>
                    <input type="radio" id="opcion1" name="opcion" value="a">
                    <label id="label1" for="opcion1"></label>
                </div>
                <div>
                    <input type="radio" id="opcion2" name="opcion" value="b">
                    <label id="label2" for="opcion2"></label>
                </div>
                <div>
                    <input type="radio" id="opcion3" name="opcion" value="c">
                    <label id="label3" for="opcion3"></label>
                </div>
                <div>
                    <input type="radio" id="opcion4" name="opcion" value="d">
                    <label id="label4" for="opcion4"></label>
                </div>
            </div>

            <input type="submit" value="Confirmar modificacion">
        </form>
    </main>
    </main>
   <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
    <script type="module" src="javascript/models/mPreguntasRespuestas.js"></script>
    <script type="module" src="javascript/controllers/cPreguntasRespuestas.js"></script>
    <script type="module" src="javascript/views/modificarPreguntasRespuestas.js"></script>
    <script type="module" src="javaScript/app.js"></script>
    
</body>
</html>