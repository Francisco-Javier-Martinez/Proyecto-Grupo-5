<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Administradores</title>
    <link rel="stylesheet" href="php/views/css/usuario.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body id="profesores">    
    <header>
        <img id="logo" src="/php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        <h1>Usuarios</h1>
    </header>
    <main>

    <nav>
        <ul>
            <li><a href="index.php?controller=Administrador&action=panelAdministrador">Panel</a></li>
            <li><a href="./php/views/creacion_Juegos.html">Crear juego</a></li>
            <li><a href="index.php?controller=Administrador&action=listarAdministradores">Gestionar Usuarios</a></li>
            <li><a href="gestiontemas.html">Temas</a></li>
            <li><a href="gestion_Avatares.html">Avatares</a></li>
            <li><a href="index.php?controller=Administrador&action=cerrarSesion">Cerrar sesion</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <?php if (isset($mensajeError) && !empty($mensajeError)): ?>
            <div id="alert" class="mostrar <?php echo (strpos($mensajeError, 'creado') !== false || strpos($mensajeError, 'correctamente') !== false) ? 'exito' : 'error'; ?>">
                <?php echo htmlspecialchars($mensajeError); ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php?action=añadirAdministrador&controller=Administrador" id="crearUsuario" method="POST">
            <h2>Crear Nuevo Administrador</h2>
            <p class="subtitle">
                Solo los super administradores pueden crear nuevos administradores
            </p>

            <div class="form-box">
                <label for="userName">Nombre de Usuario *</label>
                <input type="text" id="userName" name="nombre" placeholder="Ej: admin_juan" 
                    value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" />
                <span id="error-userName" class="error-text"></span> 
            </div>

            <div class="form-box">
                <label for="email">Correo Electrónico *</label>
                <input type="email" id="email" name="email" placeholder="admin@ejemplo.com"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                <span id="error-email" class="error-text"></span> 
            </div>

            <div class="form-box">
                <label for="password">Contraseña *</label>
                <input type="password" id="password" name="contrasenia" placeholder="Mínimo 8 caracteres" />
                <span id="error-password" class="error-text"></span> 
            </div>

            <div class="form-box">
                <label for="password-confirm">Confirmar Contraseña *</label>
                <input type="password" id="password-confirm" name="password-confirm" placeholder="Repite la contraseña" />
                <span id="error-password-confirm" class="error-text"></span> 
            </div>

            <button type="submit" class="save-btn">Crear Administrador</button>
        </form>
    </div>

    <!-- SOLO UN CONTAINER PARA LA LISTA -->
    <div class="container">
        <h2>Administradores Registrados (<?php echo count($datos ?? []); ?>)</h2>
        <p class="subtitle">
            Haz clic en un administrador para ver sus detalles, editarlo o eliminarlo
        </p>

        <div class="admin-list">
            <?php if (!empty($datos)): ?>
                <?php foreach ($datos as $admin): ?>
                    <div class="admin-box">
                        <div class="admin-info">
                            <h3><?php echo htmlspecialchars($admin['nombre'] ?? 'Sin nombre'); ?></h3>
                            <p class="admin-details">
                                <span class="material-icons">email</span>
                                <span><?php echo htmlspecialchars($admin['email'] ?? 'Sin email'); ?></span>
                            </p>
                            <?php if (isset($admin['fecha_registro'])): ?>
                                <p class="admin-details">
                                    <span class="material-icons">calendar_today</span>
                                    <span><?php echo date('d M Y', strtotime($admin['fecha_registro'])); ?></span>
                                </p>
                            <?php endif; ?>
                            <div class="admin-actions">
                                
                                    <a class="icono" href="index.php?controller=Administrador&action=editarAdministrador&id=<?php echo $admin['idUsuario']; ?>" 
                                    ><span class="material-symbols-outlined">edit</span></a>
                                
                                    <a class="icono" href="index.php?controller=Administrador&action=eliminarAdministrador&id=<?php echo $admin['idUsuario']; ?>" 
                                    onclick="return confirm('¿Seguro que quieres eliminar este administrador?')"><span class="material-symbols-outlined">delete</span></a>
                                
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay administradores registrados.</p>
            <?php endif; ?>
        </div>
    </div>
    </main>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
    <script type="module" src="javaScript/app.js"></script>
</body>
</html>