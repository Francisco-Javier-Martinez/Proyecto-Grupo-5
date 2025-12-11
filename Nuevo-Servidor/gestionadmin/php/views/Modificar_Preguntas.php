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
        <form action="./index.php?controller=PreguntasRespuestas&action=modificarPregunta" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idTema" value="<?php echo $datos['idTema']; ?>">
            <input type="hidden" name="nPregunta" value="<?php echo $datos['nPregunta']; ?>">
            <label for="titulo">Nuevo Título de la pregunta</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo $datos['pregunta']['titulo']; ?>">

            <label for="puntuacion">Puntos</label>
            <input type="number" id="puntuacion" name="puntuacion" value="<?php echo $datos['pregunta']['puntuacion']; ?>">

            <label for="imagen">Imagen actual</label>
            <div><img src="<?php echo $datos['imagenPregunta']; ?>" alt="Imagen de la pregunta" id="imgenPregunta"></div>
            <h2>Imagen que estaba guardada</h2>
            <label for="imagen">Cambiar imagen de la pregunta, si no deseas se quedara guardada la que estaba</label>
            <input type="file" id="imagen" name="imagen">

            <label for="explicacionPregunta">Explicación de la pregunta</label>
            <textarea name="explicacionPregunta" id="explicacionPregunta"><?php echo $datos['pregunta']['explicacion']; ?></textarea>

            <h3>Respuestas</h3>
            <h4>Modificar Respuestas</h4>
            <?php
                $letras = ['a', 'b', 'c', 'd'];
                $textoRespuestas = [];
                $esCorrecta = [];
                // Mapear respuestas por letra
                foreach($datos['respuestas'] as $respuesta){
                    $textoRespuestas[$respuesta['nLetra']] = $respuesta['texto'];
                    $esCorrecta[$respuesta['nLetra']] = $respuesta['es_correcta'];
                }
            ?>
            <label for="respuesta1">Respuesta 1</label>
            <input type="text" id="respuesta1" name="respuestas[]" value="<?php echo $textoRespuestas['a']; ?>">
            <label for="respuesta2">Respuesta 2</label>
            <input type="text" id="respuesta2" name="respuestas[]" value="<?php echo $textoRespuestas['b']; ?>">
            <label for="respuesta3">Respuesta 3</label>
            <input type="text" id="respuesta3" name="respuestas[]" value="<?php echo $textoRespuestas['c']; ?>">
            <label for="respuesta4">Respuesta 4</label>
            <input type="text" id="respuesta4" name="respuestas[]" value="<?php echo $textoRespuestas['d']; ?>">
            <div id="contenedorRespuestas">
                <div>
                    <input type="radio" id="opcion1" name="opcion" value="a" <?php 
                        //si la respuesta a es correcta la marco como checked
                        if($esCorrecta['a']) { 
                            echo 'checked'; 
                        }
                    ?>>
                    <label for="opcion1"><?php echo $textoRespuestas['a']; ?></label>
                </div>
                <div>
                    <input type="radio" id="opcion2" name="opcion" value="b" <?php 
                        if($esCorrecta['b']) 
                            { 
                                echo 'checked'; 
                            } 
                    ?>>
                    <label for="opcion2"><?php echo $textoRespuestas['b'];?>
                    </label>
                </div>
                <div>
                    <input type="radio" id="opcion3" name="opcion" value="c" <?php 
                        if($esCorrecta['c']) { 
                            echo 'checked'; 
                        } 
                    ?>>
                    <label for="opcion3"><?php echo $textoRespuestas['c'];  ?></label>
                </div>
                <div>
                    <input type="radio" id="opcion4" name="opcion" value="d" <?php 
                        if($esCorrecta['d']) { 
                            echo 'checked'; 
                            } 
                    ?>>
                    <label for="opcion4"><?php echo $textoRespuestas['d']; ?></label>
                </div>
            </div>

            <input type="submit" value="Confirmar modificacion">
        </form>
    </main>
   <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>