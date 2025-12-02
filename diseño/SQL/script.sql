CREATE DATABASE preguntadaw;
USE preguntadaw;

CREATE TABLE personajes(
    idPersonaje tinyint unsigned NOT NULL auto_increment,
    nombre varchar (50) NOT NULL,
    imagen binary NOT NULL,
    PRIMARY KEY (idPersonaje)
); 

CREATE TABLE usuarios(
    idUsuario SMALLINT UNSIGNED NOT NULL auto_increment,
    nombre varchar(50) NOT NULL,
    contrasenia CHAR (15) NOT NULL,
    email varchar(150) NOT NULL,
    PRIMARY KEY(idUsuario),
    CONSTRAINT email_Usuarios UNIQUE(email)
); 

CREATE TABLE juego(
    idJuego smallint unsigned NOT NULL auto_increment,
    descripcion varchar(250) NOT NULL,
    codigo char (7) NOT NULL,
    publico bit NOT NULL DEFAULT 0,
    idUsuario SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (idJuego),
    CONSTRAINT FK_Juego FOREIGN KEY(idUsuario) REFERENCES usuarios(idUsuario)
    ON DELETE CASCADE ON UPDATE CASCADE
); 

CREATE TABLE jugador(
    idJugador smallint unsigned NOT NULL auto_increment,
    nombre varchar (50) NOT NULL,
    idPersonaje tinyint unsigned NOT NULL,
    PRIMARY KEY(idJugador),
    CONSTRAINT fk_Personajes FOREIGN KEY (idPersonaje) REFERENCES personajes (idPersonaje)
); 

CREATE TABLE ranking(
    idJugador smallint unsigned NOT NULL,
    idJuego smallint unsigned NOT NULL,
    puntuacion smallint unsigned NOT NULL,
    CONSTRAINT PK_Juego PRIMARY KEY (idJugador, idJuego),
    CONSTRAINT FK_Juego_idJugador FOREIGN KEY(idJugador) REFERENCES jugador(idJugador),
    CONSTRAINT FK_Juego_idJuego FOREIGN KEY(idJuego) REFERENCES juego(idJuego),
    CONSTRAINT chk_puntuacion CHECK (puntuacion BETWEEN 250 AND 500)
);

CREATE TABLE tema(
    idTema smallint unsigned NOT NULL auto_increment,
    nombre varchar(50) NOT NULL,
    descripcion varchar(250) NOT NULL,
    publico bit NOT NULL DEFAULT 0,
    abreviatura char(10) NOT NULL,
    idUsuario smallint unsigned NULL DEFAULT NULL,
    CONSTRAINT PK_Temas PRIMARY KEY(idTema),
    CONSTRAINT FK_Temas FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);

CREATE TABLE temas_juegos(
    idTema smallint unsigned NOT NULL,
    idJuego smallint unsigned NOT NULL,
    CONSTRAINT PK_JuegosTemas PRIMARY KEY (idTema, idJuego),
    CONSTRAINT FKTemas_JuegosTemas FOREIGN KEY(idTema) REFERENCES tema(idTema),
    CONSTRAINT FKJuegos_JuegosTemas FOREIGN KEY(idJuego) REFERENCES juego(idJuego)
);

/* PREGUNTAS, RESPUESTAS - CORREGIDO */

CREATE TABLE preguntas(
    idTema smallint unsigned NOT NULL,  -- QUITADO auto_increment aquí
    nPregunta tinyint unsigned NOT NULL,
    titulo varchar(50) NOT NULL,  -- Cambiado "título" (con tilde) por "titulo" (sin tilde)
    imagen varchar(20) NOT NULL,
    explicacion varchar(250) NOT NULL,
    puntuacion smallint unsigned NULL DEFAULT 200,  -- CORREGIDO: un solo DEFAULT
    CONSTRAINT idPregunta PRIMARY KEY(idTema, nPregunta),
    CONSTRAINT fk_preguntas_tema FOREIGN KEY (idTema) REFERENCES tema(idTema)  -- AÑADIDO: falta esta referencia
);

CREATE TABLE respuestas (
    idTema SMALLINT UNSIGNED NOT NULL,
    nPregunta TINYINT UNSIGNED NOT NULL,
    nLetra CHAR(1) NOT NULL CHECK (nLetra IN('a','b','c','d')),
    texto VARCHAR(500) NOT NULL,  -- AÑADIDO: falta el texto de la respuesta
    es_correcta BIT NOT NULL DEFAULT 0,  -- AÑADIDO: para identificar cuál es la correcta

    CONSTRAINT idRespuesta PRIMARY KEY (idTema, nPregunta, nLetra),
    CONSTRAINT fk_pregunta FOREIGN KEY (idTema, nPregunta) REFERENCES preguntas(idTema, nPregunta)
);


/*DATOS*/

USE preguntadaw;

-- 1. Insertar usuarios
INSERT INTO usuarios (nombre, contrasenia, email) VALUES
('admin', 'admin123', 'admin@quiz.com'),
('profesor1', 'prof123', 'profesor1@quiz.com'),
('profesor2', 'prof456', 'profesor2@quiz.com'),
('ana_garcia', 'ana12345', 'ana@email.com'),
('carlos_lopez', 'carlos123', 'carlos@email.com');

-- 2. Insertar personajes
INSERT INTO personajes (nombre, imagen) VALUES
('Explorador', UNHEX('89504E470D0A1A0A')), -- Imagen PNG dummy
('Científico', UNHEX('89504E470D0A1A0B')),
('Aventurero', UNHEX('89504E470D0A1A0C')),
('Historiador', UNHEX('89504E470D0A1A0D')),
('Deportista', UNHEX('89504E470D0A1A0E'));

-- 3. Insertar temas
INSERT INTO tema (nombre, descripcion, publico, abreviatura, idUsuario) VALUES
('Historia Universal', 'Preguntas sobre eventos históricos importantes del mundo', 1, 'HIST_UNIV', 2),
('Matemáticas Básicas', 'Conceptos fundamentales de aritmética y álgebra', 1, 'MAT_BASIC', 2),
('Ciencias Naturales', 'Biología, física y química para principiantes', 1, 'CIEN_NAT', 3),
('Literatura Española', 'Autores y obras importantes de la literatura española', 0, 'LIT_ESP', 2),
('Geografía Mundial', 'Países, capitales y características geográficas', 1, 'GEO_MUND', 3);

-- 4. Insertar juegos
INSERT INTO juego (descripcion, codigo, publico, idUsuario) VALUES
('Quiz de Historia para principiantes', 'HIST001', 1, 2),
('Matemáticas divertidas para niños', 'MATH001', 1, 2),
('Ciencias para estudiantes de secundaria', 'SCI001', 1, 3),
('Literatura española del siglo XIX', 'LIT001', 0, 2),
('Geografía de Europa', 'GEO001', 1, 3);

-- 5. Insertar jugadores
INSERT INTO jugador (nombre, idPersonaje) VALUES
('Juan Pérez', 1),
('María López', 2),
('Pedro García', 3),
('Laura Martínez', 4),
('Carlos Rodríguez', 5);

-- 6. Insertar relación temas_juegos
INSERT INTO temas_juegos (idTema, idJuego) VALUES
(1, 1), -- Historia en juego 1
(2, 2), -- Matemáticas en juego 2
(3, 3), -- Ciencias en juego 3
(4, 4), -- Literatura en juego 4
(5, 5), -- Geografía en juego 5
(1, 3), -- Historia también en juego 3
(5, 2); -- Geografía también en juego 2

-- 7. Insertar preguntas
INSERT INTO preguntas (idTema, nPregunta, titulo, imagen, explicacion, puntuacion) VALUES
-- Preguntas de Historia (Tema 1)
(1, 1, 'Revolución Francesa', 'rev_francesa.jpg', 'Evento clave en la historia moderna', 200),
(1, 2, 'Segunda Guerra Mundial', 'ww2.jpg', 'Conflicto bélico global', 300),
(1, 3, 'Descubrimiento de América', 'colón.jpg', 'Encuentro entre dos mundos', 250),

-- Preguntas de Matemáticas (Tema 2)
(2, 1, 'Teorema de Pitágoras', 'pitagoras.jpg', 'Fundamental en geometría', 200),
(2, 2, 'Operaciones básicas', 'operaciones.jpg', 'Suma, resta, multiplicación y división', 150),

-- Preguntas de Ciencias (Tema 3)
(3, 1, 'Leyes de Newton', 'newton.jpg', 'Fundamentos de la mecánica clásica', 300),
(3, 2, 'Fotosíntesis', 'fotosintesis.jpg', 'Proceso vital de las plantas', 250);

-- 8. Insertar respuestas
INSERT INTO respuestas (idTema, nPregunta, nLetra, texto, es_correcta) VALUES
-- Respuestas para Pregunta 1 de Historia
(1, 1, 'a', '1789', 1),
(1, 1, 'b', '1776', 0),
(1, 1, 'c', '1810', 0),
(1, 1, 'd', '1799', 0),

-- Respuestas para Pregunta 2 de Historia
(1, 2, 'a', '1939-1945', 1),
(1, 2, 'b', '1914-1918', 0),
(1, 2, 'c', '1941-1945', 0),
(1, 2, 'd', '1935-1940', 0),

-- Respuestas para Pregunta 1 de Matemáticas
(2, 1, 'a', 'a² + b² = c²', 1),
(2, 1, 'b', 'E = mc²', 0),
(2, 1, 'c', 'F = m·a', 0),
(2, 1, 'd', 'V = I·R', 0),

-- Respuestas para Pregunta 1 de Ciencias
(3, 1, 'a', 'Ley de la inercia', 0),
(3, 1, 'b', 'F = m·a', 0),
(3, 1, 'c', 'Acción y reacción', 0),
(3, 1, 'd', 'Todas las anteriores', 1);

-- 9. Insertar ranking
INSERT INTO ranking (idJugador, idJuego, puntuacion) VALUES
(1, 1, 450),
(2, 1, 380),
(3, 1, 420),
(1, 2, 300),
(2, 2, 280),
(4, 3, 350),
(5, 3, 400),
(3, 4, 275);

-- Más datos para enriquecer la base de datos:

-- Más preguntas
INSERT INTO preguntas (idTema, nPregunta, titulo, imagen, explicacion, puntuacion) VALUES
(4, 1, 'Don Quijote de la Mancha', 'quijote.jpg', 'Obra cumbre de Cervantes', 400),
(5, 1, 'Capitales europeas', 'europa.jpg', 'Capitales de países europeos', 250),
(5, 2, 'Ríos de América', 'rios.jpg', 'Principales ríos del continente americano', 300);

-- Más respuestas
INSERT INTO respuestas (idTema, nPregunta, nLetra, texto, es_correcta) VALUES
(4, 1, 'a', 'Miguel de Cervantes', 1),
(4, 1, 'b', 'Federico García Lorca', 0),
(4, 1, 'c', 'Lope de Vega', 0),
(4, 1, 'd', 'Calderón de la Barca', 0),

(5, 1, 'a', 'París (Francia)', 0),
(5, 1, 'b', 'Berlín (Alemania)', 0),
(5, 1, 'c', 'Madrid (España)', 0),
(5, 1, 'd', 'Todas son correctas', 1);

-- Más juegos
INSERT INTO juego (descripcion, codigo, publico, idUsuario) VALUES
('Historia del Arte', 'ART001', 1, 3),
('Música Clásica', 'MUS001', 0, 2),
('Tecnología e Informática', 'TEC001', 1, 3);

-- Más jugadores
INSERT INTO jugador (nombre, idPersonaje) VALUES
('Sofía Fernández', 2),
('David González', 1),
('Elena Ruiz', 3);