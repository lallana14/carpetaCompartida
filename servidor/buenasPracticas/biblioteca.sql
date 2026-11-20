-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-11-2026 a las 12:48:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Edad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`Id`, `Nombre`, `Apellidos`, `Edad`) VALUES
(1, 'Miguel', 'de Cervantes', 68),
(2, 'J.R.R.', 'Tolkien', 81),
(3, 'Isaac', 'Asimov', 72);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bibliotecarios`
--

CREATE TABLE `bibliotecarios` (
  `Id_Usuario` int(11) NOT NULL,
  `Num_Seguridad_Social` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bibliotecarios`
--

INSERT INTO `bibliotecarios` (`Id_Usuario`, `Num_Seguridad_Social`) VALUES
(2, 'ES0987654321'),
(1, 'ES1234567890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `Id_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`Id_Usuario`) VALUES
(3),
(4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `Id` int(11) NOT NULL,
  `Id_Prestamo` int(11) NOT NULL,
  `Fecha_Devolucion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `devoluciones`
--

INSERT INTO `devoluciones` (`Id`, `Id_Prestamo`, `Fecha_Devolucion`) VALUES
(1, 1, '2023-05-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Pais` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`Id`, `Nombre`, `Pais`) VALUES
(1, 'Editorial Planeta', 'España'),
(2, 'Minotauro', 'Argentina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplares`
--

CREATE TABLE `ejemplares` (
  `Id_Ejemplar` int(11) NOT NULL,
  `ISBN_Libro` varchar(20) NOT NULL,
  `Estado` enum('Disponible','Prestado','Dado de baja') DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejemplares`
--

INSERT INTO `ejemplares` (`Id_Ejemplar`, `ISBN_Libro`, `Estado`) VALUES
(1, '978-84-111-1111-1', 'Disponible'),
(2, '978-84-111-1111-1', 'Prestado'),
(3, '978-84-222-2222-2', 'Disponible'),
(4, '978-84-222-2222-2', 'Dado de baja'),
(5, '978-84-333-3333-3', 'Prestado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`Id`, `Nombre`) VALUES
(4, 'Aventura'),
(2, 'Ciencia Ficción'),
(3, 'Clásico'),
(1, 'Fantasía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_inventario`
--

CREATE TABLE `gestion_inventario` (
  `Id` int(11) NOT NULL,
  `Id_Bibliotecario` int(11) NOT NULL,
  `Id_Ejemplar` int(11) NOT NULL,
  `Accion` enum('Alta','Baja por desgaste','Baja por pérdida') NOT NULL,
  `Fecha_Accion` date NOT NULL,
  `Observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gestion_inventario`
--

INSERT INTO `gestion_inventario` (`Id`, `Id_Bibliotecario`, `Id_Ejemplar`, `Accion`, `Fecha_Accion`, `Observaciones`) VALUES
(1, 1, 1, 'Alta', '2023-01-10', 'Libro nuevo donado'),
(2, 1, 2, 'Alta', '2023-01-10', 'Libro nuevo comprado'),
(3, 2, 4, 'Baja por desgaste', '2023-10-15', 'Faltaban páginas del final');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `ISBN` varchar(20) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Sinopsis` text DEFAULT NULL,
  `Id_Autor` int(11) DEFAULT NULL,
  `Id_Editorial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`ISBN`, `Titulo`, `Sinopsis`, `Id_Autor`, `Id_Editorial`) VALUES
('978-84-111-1111-1', 'Don Quijote de la Mancha', 'Aventuras de un hidalgo caballero...', 1, 1),
('978-84-222-2222-2', 'El Señor de los Anillos', 'La comunidad del anillo emprende su viaje...', 2, 2),
('978-84-333-3333-3', 'Fundación', 'El declive del Imperio Galáctico...', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_generos`
--

CREATE TABLE `libros_generos` (
  `ISBN_Libro` varchar(20) NOT NULL,
  `Id_Genero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros_generos`
--

INSERT INTO `libros_generos` (`ISBN_Libro`, `Id_Genero`) VALUES
('978-84-111-1111-1', 3),
('978-84-111-1111-1', 4),
('978-84-222-2222-2', 1),
('978-84-222-2222-2', 4),
('978-84-333-3333-3', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `Id` int(11) NOT NULL,
  `Id_Cliente` int(11) NOT NULL,
  `Id_Ejemplar` int(11) NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date NOT NULL,
  `Dias_Retraso` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`Id`, `Id_Cliente`, `Id_Ejemplar`, `Fecha_Inicio`, `Fecha_Fin`, `Dias_Retraso`) VALUES
(1, 3, 1, '2023-05-01', '2023-05-15', 0),
(2, 4, 2, '2023-09-01', '2023-09-15', 30),
(3, 3, 5, '2023-10-18', '2023-11-02', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Nombre_Usuario` varchar(50) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Foto` text DEFAULT NULL,
  `Moroso` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `Nombre`, `Apellidos`, `Nombre_Usuario`, `Contrasena`, `Foto`, `Moroso`) VALUES
(1, 'Ana', 'López', 'admin_ana', 'pass123', NULL, 0),
(2, 'Carlos', 'Martínez', 'admin_car', 'pass456', NULL, 0),
(3, 'Laura', 'Gómez', 'laura_g', 'cliente1', NULL, 0),
(4, 'Pedro', 'Sánchez', 'pedro_s', 'cliente2', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `bibliotecarios`
--
ALTER TABLE `bibliotecarios`
  ADD PRIMARY KEY (`Id_Usuario`),
  ADD UNIQUE KEY `Num_Seguridad_Social` (`Num_Seguridad_Social`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`Id_Usuario`);

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id_Prestamo` (`Id_Prestamo`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  ADD PRIMARY KEY (`Id_Ejemplar`),
  ADD KEY `ISBN_Libro` (`ISBN_Libro`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `gestion_inventario`
--
ALTER TABLE `gestion_inventario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Bibliotecario` (`Id_Bibliotecario`),
  ADD KEY `Id_Ejemplar` (`Id_Ejemplar`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `Id_Autor` (`Id_Autor`),
  ADD KEY `Id_Editorial` (`Id_Editorial`);

--
-- Indices de la tabla `libros_generos`
--
ALTER TABLE `libros_generos`
  ADD PRIMARY KEY (`ISBN_Libro`,`Id_Genero`),
  ADD KEY `Id_Genero` (`Id_Genero`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Cliente` (`Id_Cliente`),
  ADD KEY `Id_Ejemplar` (`Id_Ejemplar`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  MODIFY `Id_Ejemplar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `gestion_inventario`
--
ALTER TABLE `gestion_inventario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bibliotecarios`
--
ALTER TABLE `bibliotecarios`
  ADD CONSTRAINT `bibliotecarios_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD CONSTRAINT `devoluciones_ibfk_1` FOREIGN KEY (`Id_Prestamo`) REFERENCES `prestamos` (`Id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  ADD CONSTRAINT `ejemplares_ibfk_1` FOREIGN KEY (`ISBN_Libro`) REFERENCES `libros` (`ISBN`) ON DELETE CASCADE;

--
-- Filtros para la tabla `gestion_inventario`
--
ALTER TABLE `gestion_inventario`
  ADD CONSTRAINT `gestion_inventario_ibfk_1` FOREIGN KEY (`Id_Bibliotecario`) REFERENCES `bibliotecarios` (`Id_Usuario`),
  ADD CONSTRAINT `gestion_inventario_ibfk_2` FOREIGN KEY (`Id_Ejemplar`) REFERENCES `ejemplares` (`Id_Ejemplar`) ON DELETE CASCADE;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`Id_Autor`) REFERENCES `autores` (`Id`) ON DELETE SET NULL,
  ADD CONSTRAINT `libros_ibfk_2` FOREIGN KEY (`Id_Editorial`) REFERENCES `editoriales` (`Id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `libros_generos`
--
ALTER TABLE `libros_generos`
  ADD CONSTRAINT `libros_generos_ibfk_1` FOREIGN KEY (`ISBN_Libro`) REFERENCES `libros` (`ISBN`) ON DELETE CASCADE,
  ADD CONSTRAINT `libros_generos_ibfk_2` FOREIGN KEY (`Id_Genero`) REFERENCES `generos` (`Id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`Id_Cliente`) REFERENCES `clientes` (`Id_Usuario`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`Id_Ejemplar`) REFERENCES `ejemplares` (`Id_Ejemplar`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
