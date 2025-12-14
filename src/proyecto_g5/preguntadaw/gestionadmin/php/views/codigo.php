<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="./php/views/css/stylesPanelP.css">
</head>
<body id="codigo">
    <header>
        <a href="index.php?controller=Juego&action=listarJuegos">
            <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        </a>
        <h1>Bienvenido <?php echo ($datos['usuario']['nombre'] ?? 'Usuario'); ?></h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php?controller=Juego&action=crearJuego">Crear juego</a></li>
            <?php
                if ($_SESSION['tipo'] == 1) {
                    echo '<li><a href="index.php?controller=Administrador&action=listarAdministradores">Gestionar Usuarios</a></li>';
                }
            ?>
            <li><a href="./index.php?action=listarTemas&controller=Temas">Temas</a></li>
            <li><a href="./index.php?action=vistaGestionAvatares&controller=Administrador">Avatares</a></li>
            <li><a href="./index.php?action=cerrarSesion&controller=Administrador">Cerrar sesion</a></li>
        </ul>
    </nav>

    <main>
        <h1>Recuperar contraseña</h1>
        <section>
            <p id="infoCodigo" style="margin-bottom: 20px; text-align:center;">
                Introduce el código que se muestra a continuación:
            </p>
            <p style="font-weight:bold; color:blue; text-align:center;">
                <?php echo ($datos['codigo'] ?? ''); ?>
            </p>

            <form action="index.php?controller=Usuario&action=modificarContraseña" method="post" id="formulario">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" name="codigo" placeholder="Introduce el código" required>
                <p id="error-password"></p>
                <label for="contraseña">Nueva contraseña</label>
                <input type="password" id="password" name="password" placeholder="Nueva contraseña" required>

                <label for="contraseña1">Repítela</label>
                <input type="password" id="contraseña1" name="contraseña1" placeholder="Repite la contraseña" required>
                <p class="error-msg" id="error-contraseña1"></p>

                <p class="error-msg" id="error-match"></p>

                <input type="submit" value="Enviar">
                <?php if(!empty($mensajeError)) : ?>
                    <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($mensajeError); ?></p>
                <?php endif; ?>
            </form>

        </section>
    </main>

    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>

    <!-- <script type="module" src="./JS/Controllers/controller.js"></script> -->
    
    <script type="module" src="javaScript/app.js"></script>

</body>
</html>
