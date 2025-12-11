<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Temas</title>
    <link rel="stylesheet" href="php/views/css/jugadorT.css">
</head>
<body>
    <header>
        <a href="./index.php?controller=Administrador&action=volverPanelInicial"><img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw"></a>
        <h1>PREGUNTADAW</h1>
    </header>
    <nav>
        <ul>
            <li><a href="verDatos.html">Tu cuenta</a></li>
            <li><a href="creacion_Juegos.html">Crear juego</a></li>
            <li><a href="gestion_Usuarios.html">Gestionar Usuarios</a></li>
            <li><a href="./index.php?action=listarTemas&controller=Temas">Temas</a></li>
            <li><a href="gestion_Avatares.html">Avatares</a></li>
            <li><a href="./index.php?action=cerrarSesion&controller=Administrador">Cerrar sesion</a></li>
        </ul>
    </nav>
<main>
    <div class="contenedor-principal">
        <div class="grupo-botones">
            <a href="./index.php?action=introducirTemas&controller=Temas"><button>Crear nuevo tema</button></a>
        </div>

        <div class="lista-tarjetas">
            <?php
                // Código PHP en el HTML
                foreach($datos as $tema){
                    echo '
                        <a href="./index.php?controller=Temas&action=obtenerTema&idTema=' . $tema['idTema'] . '" class="enlace-tarjeta" data-idtema="' . $tema['idTema'] . '">
                            <div class="tarjeta">
                                <p class="titulo-tarjeta">' . $tema['nombre'] . '</p>
                                <img src="php/views/img/editar.png" alt="Icono Editar" class="icono editar">
                                <img src="php/views/img/eliminar.png" alt="Icono Borrar" class="icono icono-borrar"> </div>
                        </a>
                    ';
                }
            ?>
        </div>
    </div>
</main>


    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
    <script type="module" src="javaScript/controllers/controller.js"></script>
</body>
</html>
