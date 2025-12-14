-- Crear base de datos
CREATE DATABASE IF NOT EXISTS preguntadaw;
USE preguntadaw;

-- TABLA PERSONAJES
CREATE TABLE personajes (
    idPersonaje TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    imagen BLOB NOT NULL,
    PRIMARY KEY (idPersonaje)
);

-- TABLA USUARIOS
CREATE TABLE usuarios (
    idUsuario SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    contrasenia VARCHAR(60) NOT NULL,
    email VARCHAR(150) NOT NULL,
    tipo bit NOT NULL DEFAULT 0,
    PRIMARY KEY (idUsuario),
    CONSTRAINT uniq_email_usuarios UNIQUE(email)
);

-- TABLA JUEGO
CREATE TABLE juego (
    idJuego SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(250) NOT NULL,
    codigo CHAR(7) NOT NULL,
    publico BIT NOT NULL DEFAULT 0,
    idUsuario SMALLINT UNSIGNED NOT NULL,
    habilitado BIT NOT NULL DEFAULT 0,
    PRIMARY KEY (idJuego),
    CONSTRAINT fk_juego_usuario FOREIGN KEY(idUsuario) REFERENCES usuarios(idUsuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- TABLA JUGADOR
CREATE TABLE jugador (
    idJugador SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    idPersonaje TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (idJugador),
    CONSTRAINT fk_jugador_personaje FOREIGN KEY (idPersonaje) REFERENCES personajes(idPersonaje)
);

-- TABLA RANKING
CREATE TABLE ranking (
    idJugador SMALLINT UNSIGNED NOT NULL,
    idJuego SMALLINT UNSIGNED NOT NULL,
    puntuacion SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT pk_ranking PRIMARY KEY (idJugador, idJuego),
    CONSTRAINT fk_ranking_jugador FOREIGN KEY(idJugador) REFERENCES jugador(idJugador),
    CONSTRAINT fk_ranking_juego FOREIGN KEY(idJuego) REFERENCES juego(idJuego),
    CONSTRAINT chk_ranking_puntuacion CHECK (puntuacion BETWEEN 250 AND 500)
);

-- TABLA TEMA
CREATE TABLE tema (
    idTema SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(250) NOT NULL,
    publico BIT NOT NULL DEFAULT 0,
    abreviatura CHAR(10) NOT NULL,
    idUsuario SMALLINT UNSIGNED NULL DEFAULT NULL,
    PRIMARY KEY(idTema),
    CONSTRAINT fk_tema_usuario FOREIGN KEY(idUsuario) REFERENCES usuarios(idUsuario)
);

-- TABLA TEMAS_JUEGOS (relación N:M)
CREATE TABLE temas_juegos (
    idTema SMALLINT UNSIGNED NOT NULL,
    idJuego SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (idTema, idJuego),
    CONSTRAINT fk_tj_tema FOREIGN KEY(idTema) REFERENCES tema(idTema),
    CONSTRAINT fk_tj_juego FOREIGN KEY(idJuego) REFERENCES juego(idJuego)
);

-- TABLA PREGUNTAS
CREATE TABLE preguntas (
    idTema SMALLINT UNSIGNED NOT NULL,
    nPregunta TINYINT UNSIGNED NOT NULL,
    titulo VARCHAR(50) NOT NULL,
    imagen VARCHAR(60) NOT NULL,
    explicacion VARCHAR(250) NOT NULL,
    puntuacion SMALLINT UNSIGNED NOT NULL DEFAULT 200,
    PRIMARY KEY (idTema, nPregunta),
    CONSTRAINT fk_preguntas_tema FOREIGN KEY (idTema) REFERENCES tema(idTema)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- TABLA RESPUESTAS
CREATE TABLE respuestas (
    idTema SMALLINT UNSIGNED NOT NULL,
    nPregunta TINYINT UNSIGNED NOT NULL,
    nLetra CHAR(1) NOT NULL CHECK (nLetra IN('a','b','c','d')),
    texto VARCHAR(500) NOT NULL,
    es_correcta BIT NOT NULL DEFAULT 0,
    PRIMARY KEY (idTema, nPregunta, nLetra),
    CONSTRAINT fk_respuestas_preguntas FOREIGN KEY (idTema, nPregunta)
        REFERENCES preguntas(idTema, nPregunta)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
-- Inserción masiva de temas
INSERT INTO tema (nombre, descripcion, publico, abreviatura, idUsuario) VALUES
('Historia Mundial', 'Preguntas sobre historia general y eventos históricos importantes', 1, 'HIST', 1),
('Ciencia y Tecnología', 'Preguntas sobre avances científicos y tecnológicos', 1, 'CIENC', 2),
('Geografía', 'Preguntas sobre países, capitales y geografía mundial', 0, 'GEO', 3),
('Deportes', 'Preguntas sobre fútbol, baloncesto y otros deportes', 1, 'DEPT', 4),
('Cine y Series', 'Preguntas sobre películas, actores y series populares', 0, 'CINE', 1),
('Música', 'Preguntas sobre géneros musicales, artistas y álbumes', 1, 'MUS', 2),
('Arte y Literatura', 'Preguntas sobre pintores, escritores y obras literarias', 0, 'ARTLIT', 3),
('Matemáticas', 'Preguntas sobre matemáticas, álgebra y geometría', 1, 'MATH', 4),
('Videojuegos', 'Preguntas sobre juegos de consola y PC', 0, 'VGAME', 1),
('Cultura General', 'Preguntas variadas de cultura general', 1, 'CGEN', 2),
('Animales y Naturaleza', 'Preguntas sobre fauna, flora y ecosistemas', 0, 'NAT', 3),
('Política y Economía', 'Preguntas sobre gobiernos, economía y política internacional', 1, 'POL', 4),
('Astronomía', 'Preguntas sobre planetas, estrellas y el universo', 1, 'ASTRO', 1),
('Salud y Bienestar', 'Preguntas sobre salud, nutrición y estilo de vida', 0, 'SALUD', 2),
('Idiomas', 'Preguntas sobre gramática, vocabulario y traducción', 1, 'IDIOM', 3);
