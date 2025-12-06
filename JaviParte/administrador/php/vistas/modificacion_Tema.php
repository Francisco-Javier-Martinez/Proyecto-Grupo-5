<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Tema</title>
    <link rel="stylesheet" href="./vistas/css/usuario.css">
</head>
<body>
    <header>
        <img id="logo" src="img/preguntadawLogo.png" alt="Logo preguntadaw">
        <h1>Tema</h1>
    </header>
    <nav>
        <ul>
            <li><a href="panelAdministrador.html">Panel</a></li>
            <li><a href="creacion_Juegos.html">Crear juego</a></li>
            <li><a href="gestion_Usuarios.html">Gestionar Usuarios</a></li>
            <li><a href="gestiontemas.html">Temas</a></li>
            <li><a href="gestion_Avatares.html">Avatares</a></li>
            <li><a href="inicio_sesion_admin.html">Cerrar sesion</a></li>
        </ul>
    </nav>
    <main>
        <div class="container">
            <h2>Biblioteca de Temas</h2>
            <p class="subtitle">Crea y gestiona tus temas personalizados con sus preguntas</p>
        </div>
        <div class="container">
            <h3>Editar Tema</h3>
            <form action="Modificar_Preguntas.html" method="post">
                <div class="form-box">
                    <label>Nombre del Tema</label>
                    <input type="text" value="Nombre del tema seleccionado">
                </div>
                <div class="form-box">
                    <label>Descripcion del Tema</label>
                    <input type="text" value="Descripcion">
                </div>
                <div class="form-box">
                    <label>Tema Publico</label>
                    <span class="subtitle">Permite que otros usuarios usar tu tema</span>
                    <input type="checkbox" name="juegoPublico" id="checkbox-publico"/>
                </div>
                <div class="buttons-box">
                    <button type="submit" class="save-btn">✓ Modificar Pregutas/Respuestas</button>
                </div>
            </form>
        </div>
        <!-- Sección de preguntas: reutiliza estilos .container, .temas-box y .tema-item -->
        <div class="container">
            <h3>Preguntas</h3>
            <p class="subtitle">Lista de preguntas del tema clica en el nombre para modificar</p>
            <div class="temas-box">
                <?php
                    if(!empty($datos)){
                        foreach($datos as $pregunta){
                            echo '<div class="tema-item">';
                            // Enlace hacia el controlador que carga la vista de modificar pregunta
                            echo '<a class="tema-link" href="index.php?c=PreguntasRespuestas&m=editarPregunta&idTema=' .$pregunta['idTema'].'&nPregunta='.$pregunta['nPregunta']. '"> '. $pregunta['titulo']. '</a>';
                            echo '<a href="index.php?c=PreguntasRespuestas&m=borrarPregunta&idTema='.$pregunta['idTema'].'&nPregunta='.$pregunta['nPregunta']. '"><button class="delete-btn" type="button">🗑</button></a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No hay preguntas disponibles para este tema.</p>';
                    }
                ?>
        </div>
        <!-- Botón para agregar nueva pregunta -->
        <?php
            // Asegurarse de tener un idTema disponible
            $idTemaLink = isset($idTema) ? $idTema : (isset($datos[0]['idTema']) ? $datos[0]['idTema'] : '');
        ?>
        <div class="tema-item">
            <a class="tema-link" href="index.php?c=PreguntasRespuestas&m=mostrarNuevaPregunta&idTema=<?php echo $idTemaLink; ?>">
                <p>+ Agregar Nueva Pregunta</p>
            </a>
        </div>
    </main>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>
