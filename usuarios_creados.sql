-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2017 a las 20:48:41
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `metrologic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_creados`
--

CREATE TABLE IF NOT EXISTS `usuarios_creados` (
  `Id` int(13) NOT NULL,
  `Usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Apellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo_Usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Cedula` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Contrasena` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Creacion` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios_creados`
--

INSERT INTO `usuarios_creados` (`Id`, `Usuario`, `Nombres`, `Apellidos`, `Tipo_Usuario`, `Cedula`, `Contrasena`, `Fecha_Creacion`) VALUES
(8, 'Juan84', 'Juan David', 'Garcia Mejia', 'Administrador', '94536163', '123', '2016-03-19'),
(9, 'General', 'General', 'Apellido', 'Funcional', '11223344', 'abc', '2016-03-19'),
(22, 'Lorena', 'Ju', 'Ga  ', 'Administrador', '111', 'aaa', '2016-10-19'),
(25, 'Motas ', 'JuAN', 'Garcia ', 'Administrador', '94536163', '111', '0000-00-00'),
(26, 'Leonardo', 'Leonardo', 'Betancour', 'Consulta', '23456', 'lll', '2016-03-19');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios_creados`
--
ALTER TABLE `usuarios_creados`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios_creados`
--
ALTER TABLE `usuarios_creados`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
