<?php
// Asegurarse de que $datos venga del controlador
$tema = $datos['resultado']; // Datos del tema
$preguntas = $datos['pregunta']; // Lista de preguntas del tema
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Tema</title>
    <link rel="stylesheet" href="views/css/usuario.css">
</head>
<body>
    <header>
        <img id="logo" src="views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        <h1>Tema</h1>
    </header>
    <nav>
        <ul>
            <li><a href="verDatos.html">Tu cuenta</a></li>
            <li><a href="creacion_Juegos.html">Crear juego</a></li>
            <li><a href="gestion_Usuarios.html">Gestionar Usuarios</a></li>
            <li><a href="index.php?action=listarTemas&controller=Temas">Temas</a></li>
            <li><a href="gestion_Avatares.html">Avatares</a></li>
            <li><a href="index.php?action=cerrarSesion&controller=Administrador">Cerrar sesión</a></li>
        </ul>
    </nav>
    <main>
        <div class="container">
            <h2>Biblioteca de Temas</h2>
            <p class="subtitle">Crea y gestiona tus temas personalizados con sus preguntas</p>
        </div>

        <div class="container">
            <h3>Editar Tema</h3>
            <form action="index.php?controller=Temas&action=modificarTema&idTema=<?=$tema['idTema']?>" method="post">
                <div class="form-box">
                    <label>Nombre del Tema</label>
                    <input type="text" name="nombreTema" value="<?=$tema['nombre']?>">
                </div>
                <div class="form-box">
                    <label>Descripción del Tema</label>
                    <input type="text" name="descripcion" value="<?=$tema['descripcion']?>">
                </div>
                <div class="form-box">
                    <label>Abreviatura</label>
                    <input type="text" name="abreviatura" value="<?=$tema['abreviatura']?>">
                </div>
                <div class="form-box">
                    <label>Tema Público</label>
                    <span class="subtitle">Permite que otros usuarios usen tu tema</span>
                    <input type="checkbox" name="publico" <?php if($tema['publico']) echo 'checked'; ?>>
                </div>
                <div class="buttons-box">
                    <input type="submit" value="Modificar" class="save-btn">
                </div>
            </form>
            <a href="index.php?action=eliminarTema&controller=Temas&idTema=<?=$tema['idTema']?>">Eliminar Tema</a>
        </div>

        <div class="container">
            <h3>Preguntas</h3>
            <p class="subtitle">Lista de preguntas del tema. Haz clic en el nombre para modificar.</p>
            <div class="temas-box">
                <?php
                    if (!empty($preguntas)) {
                        foreach ($preguntas as $preg) {
                            echo '<div class="tema-item">';
                            echo '<a class="tema-link" href="index.php?controller=PreguntasRespuestas&action=editarPregunta&idTema=' . $tema['idTema'] . '&nPregunta=' . $preg['nPregunta'] . '">';
                            echo $preg['titulo'];
                            echo '</a>';
                            echo '<a href="index.php?controller=PreguntasRespuestas&action=borrarPregunta&idTema=' . $tema['idTema'] . '&nPregunta=' . $preg['nPregunta'] . '">';
                            echo '<button class="delete-btn" type="button">🗑️</button>';
                            echo '</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No hay preguntas disponibles para este tema.</p>';
                    }
                ?>
            </div>

            <!-- Botón para agregar nueva pregunta -->
            <div class="tema-item">
                <a class="tema-link" href="index.php?controller=PreguntasRespuestas&action=mostrarNuevaPregunta&idTema=<?=$tema['idTema']?>">
                    <p>+ Agregar Nueva Pregunta</p>
                </a>
            </div>
        </div>
    </main>
    <footer>
        <p>Derechos reservados - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>