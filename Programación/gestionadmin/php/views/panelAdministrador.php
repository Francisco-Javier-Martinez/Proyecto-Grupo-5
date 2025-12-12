<?php
    $datos = $datos ?? []; 
    $juegos = $datos['juegos'] ?? []; 
    $mensajeError = $mensajeError ?? '';
    $nombre = $_SESSION['nombre'] ?? 'Invitado';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>  
    <link rel="stylesheet" href="php/views/css/stylesPanelP.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body id="panelAdministrador">
    <header>
        <a href="index.php?controller=Juego&action=listarJuegos">
            <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        </a>
        <h1>Bienvenido <?php echo ($nombre); ?></h1>
    </header>
    <nav>
        <ul>
            <li><a href="verDatos.html">Tu cuenta</a></li>
            <li><a href="index.php?controller=Juego&action=crearJuego">Crear juego</a></li>
            <li><a href="index.php?controller=Administrador&action=listarAdministradores">Gestionar Usuarios</a></li>
            <li><a href="index.php?controller=Temas&action=listarTemas">Temas</a></li>
            <li><a href="gestion_Avatares.html">Avatares</a></li>
            <li><a href="index.php?controller=Administrador&action=cerrarSesion">Cerrar sesion</a></li>
        </ul>
    </nav>
    <main>
        <h1>Juegos Creados</h1>
        
        <section >
            <?php if (!empty($mensajeError)): ?>
                <div class="error-message">
                    <?php echo ($mensajeError); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($juegos)): ?>
                
                <section id="tarjetas">
                    <?php foreach($juegos as $juego): ?>
                        <?php 
                            // Asegurar que las claves existan
                            $titulo = $juego['descripcion'] ?? $juego['titulo'] ?? 'Sin título';
                            $temas = $juego['temas'] ?? [];
                            $idJ = $juego['idJuego'] ?? '';
                            $publico = $juego['publico'] ?? 0;
                            $habilitado = $juego['habilitado'] ?? 0;
                            $codigo = $juego['codigo'] ?? '';
                        ?>
                        <div class='tarjeta'>
                            <div class='tarjeta-header'>
                                <h3><?php echo ($titulo); ?></h3>
                                <div class="estados">
                                    <span class='estado <?php echo $publico ? "publico" : "privado"; ?>'>
                                        <?php echo $publico ? 'Público' : 'Privado'; ?>
                                    </span>
                                    <span class='estado <?php echo $habilitado ? "habilitado" : "deshabilitado"; ?>'>
                                        <?php echo $habilitado ? 'Habilitado' : 'Deshabilitado'; ?>
                                    </span>
                                </div>
                            </div>
                            
                            <?php if (!empty($codigo)): ?>
                                <p class="codigo-juego">Código: <strong><?php echo ($codigo); ?></strong></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($temas)): ?>
                                <div class='temas'>
                                    <?php foreach($temas as $tema): ?>
                                        <button class="tema-btn"><?php echo ($tema); ?></button>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($idJ): ?>
                                <div class="acciones-tarjeta">
                                    <a class='jugar editar' href='index.php?controller=Juego&action=mostrarRuleta&idJuego=<?php echo $idJ; ?>' data-id-juego="<?php echo $idJ; ?>">
                                        <span class="material-symbols-outlined">edit</span>Editar
                                    </a>
                                    <a class='jugar eliminar' href='index.php?controller=Juego&action=eliminarJuego&idJuego=<?php echo $idJ; ?>' onclick="return confirm('¿Seguro que quieres eliminar este juego?')">
                                        <span class="material-symbols-outlined">delete</span>Eliminar
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php else: ?>
                <div class="no-juegos">
                    <p>No tienes juegos creados aún.</p>
                    <p><a href="index.php?controller=Juego&action=crearJuego" class="crear-juego-btn">¡Crea tu primer juego!</a></p>
                </div>
            <?php endif; ?>
        </section>

        <div id="alert"></div>
    </main>

    <script type="module" src="javaScript/app.js"></script>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>