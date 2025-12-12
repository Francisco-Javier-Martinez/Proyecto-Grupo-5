<?php
// AL INICIO del archivo - TEMPORAL
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Administradores</title>
    <link rel="stylesheet" href="php/views/css/usuario.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
</head>
<body id="modificarProfesor">
    <header>
        <img id="logo" src="./php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        <h1>Usuarios</h1>
    </header>
    
    <nav>
        <ul>
            <li><a href="panelAdministrador.html">Panel</a></li>
            <li><a href="index.php?controller=Juego&action=crearJuego">Crear juego</a></li>
            <li><a href="gestion_Usuarios.html">Gestionar Usuarios</a></li>
            <li><a href="gestiontemas.html">Temas</a></li>
            <li><a href="gestion_Avatares.html">Avatares</a></li>
            <li><a href="inicio_sesion_admin.html">Cerrar sesion</a></li>
        </ul>
    </nav>
    <main>
        <div class="container">
            <!-- MOSTRAR MENSAJE SI EXISTE -->
              <?php if (isset($mensaje) && $mensaje): ?>
        <div style="background: #ffcccc; border: 2px solid red; padding: 15px; margin-bottom: 20px;">
            <h3 style="color: red; margin: 0;">ERROR:</h3>
            <p style="margin: 5px 0;"><?php echo htmlspecialchars($mensaje); ?></p>
            
            <?php 
            // DEBUG EXTRA: Mostrar datos del administrador
            if (isset($administrador) && is_array($administrador)) {
                echo "<hr>";
                echo "<p><strong>Datos recibidos:</strong></p>";
                echo "<p>ID: " . ($administrador['idUsuario'] ?? 'NO') . "</p>";
                echo "<p>Nombre: " . ($administrador['nombre'] ?? 'NO') . "</p>";
                echo "<p>Email: " . ($administrador['email'] ?? 'NO') . "</p>";
                echo "<p>Tipo: " . ($administrador['tipo'] ?? 'NO') . "</p>";
            }
            ?>
        </div>
    <?php endif; ?>
            <?php if (isset($mensaje) && !empty($mensaje)): ?>
                <div id="alert" class="mostrar <?php echo (strpos($mensaje, 'actualizado') !== false || strpos($mensaje, 'correctamente') !== false) ? 'exito' : 'error'; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?controller=Administrador&action=editarAdministrador&id=<?php echo $administrador['idUsuario'] ?? ''; ?>" 
                  id="modificarUsuario" method="POST">
                <!-- Campo oculto para el ID -->
                <input type="hidden" name="id" value="<?php echo $administrador['idUsuario']; ?>">
                
                <h2>Modificar Administrador</h2>
                <p class="subtitle">
                    Solo los super administradores pueden crear nuevos administradores
                </p>

                <div class="form-box">
                    <label for="userName">Nombre de Usuario *</label>
                    <input type="text" id="userName" name="userName" 
                        value="<?php echo htmlspecialchars($administrador['nombre'] ?? ''); ?>" 
                        placeholder="Ej: admin_juan" />
                    <span id="error-userName" class="error-text"></span> 
                </div>

                <div class="form-box">
                    <label for="email">Correo Electrónico *</label>
                    <input type="email" id="email" name="email" 
                        value="<?php echo htmlspecialchars($administrador['email'] ?? ''); ?>" 
                        placeholder="admin@ejemplo.com" />
                    <span id="error-email" class="error-text"></span> 
                </div>

                <input type="submit" class="save-btn" value="Enviar">
            </form>
        </div>
    </main>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>

    <script type="module" src="javaScript/app.js"></script>
</body>
</html>