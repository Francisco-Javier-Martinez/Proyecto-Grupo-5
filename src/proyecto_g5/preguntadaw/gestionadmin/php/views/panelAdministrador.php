
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
    <?php
        session_start();
        $tipo = $_SESSION['tipo'];
        $datos = $datos ?? []; 
        $idUsuario = $_SESSION['idUsuario'];
        $nombre = $_SESSION['nombre'];
        $juegos = $datos['juegos'] ?? []; 
        $mensajeError = $mensajeError ?? '';
    ?>
    <header>
        <a href="index.php?controller=Juego&action=listarJuegos">
            <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        </a>
        <h1>Bienvenido <?php echo ($nombre); ?></h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php?controller=Usuario&action=verDatos">Tu Cuenta</a></li>
            <li><a href="index.php?controller=Juego&action=crearJuego">Crear juego</a></li>
            <?php
                if ($_SESSION['tipo'] == 1) {
                    echo '<li><a href="index.php?controller=Administrador&action=listarAdministradores">Gestionar Usuarios</a></li>';
                }
            ?>
            <li><a href="./index.php?action=listarTemas&controller=Temas">Temas</a></li>
            <li><a href="./index.php?action=mostrarAvatares&controller=Personajes">Avatares</a></li>
            <li><a href="./index.php?action=cerrarSesion&controller=Administrador">Cerrar sesion</a></li>
        </ul>
    </nav>
    <main>
        <h1>Juegos Creados</h1>
        
        <section>

            <?php 
                if (!empty($mensajeError)) {
					echo '<div class="error-message">' . $mensajeError . '</div>';
				}
			?>
            
        	<?php 
			if (!empty($juegos)) {
				echo '<section id="tarjetas">';

				foreach ($juegos as $juego) {
					// Variables 
					$titulo = $juego['descripcion'] ?? $juego['titulo'] ?? 'Sin título';
					$temas = $juego['temas'] ?? [];
					$idJ = $juego['idJuego'] ?? '';
					$codigo = $juego['codigo'] ?? '';
					
					$publico = $juego['publico'] ?? 0;
					$clasePublico = $publico ? 'publico' : 'privado';
					$txtPublico   = $publico ? 'Público' : 'Privado';

					$habilitado = $juego['habilitado'] ?? 0;
					$claseHabilitado = $habilitado ? 'habilitado' : 'deshabilitado';
					$txtHabilitado   = $habilitado ? 'Habilitado' : 'Deshabilitado';

					// Tarjeta
					echo "
					<div class='tarjeta'>
						<div class='tarjeta-header'>
							<h3>$titulo</h3>
							<div class='estados'>
								<span class='estado $clasePublico'>$txtPublico</span>
								<span class='estado $claseHabilitado'>$txtHabilitado</span>
							</div>
						</div>";

					// Condicional para el Código
					if (!empty($codigo)) {
						echo "<p class='codigo-juego'>Código: <strong>$codigo</strong></p>";
					}

					// Temas
					if (!empty($temas)) {
						echo "<div class='temas'>";
						foreach ($temas as $tema) {
							echo "<button class='tema-btn'>$tema</button>";
						}
						echo "</div>";
					}

					// Botones de Editar/Eliminar
					if ($idJ) {
						echo "
						<div class='acciones-tarjeta'>
							<a class='jugar editar' href='index.php?controller=Juego&action=mostrarRuleta&idJuego=$idJ' data-id-juego='$idJ'>
								<span class='material-symbols-outlined'>edit</span>Editar
							</a>
							<a class='jugar eliminar' href='index.php?controller=Juego&action=eliminarJuego&idJuego=$idJ' onclick=\"return confirm('¿Seguro que quieres eliminar este juego?')\">
								<span class='material-symbols-outlined'>delete</span>Eliminar
							</a>
						</div>";
					}

					echo "</div>"; 
			}
				echo '</section>'; 
			} else {
				echo '<div class="no-juegos">
					<h1>No tienes juegos creados aún.</h1>
					<h1><a href="index.php?controller=Juego&action=crearJuego" class="crear-juego-btn">¡Crea tu primer juego!</a></p>
				</div>';
			}
			?>

        </section>

        <div id="alert"></div>
    </main>

    <script type="module" src="javaScript/app.js"></script>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>