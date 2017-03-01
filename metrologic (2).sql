-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2017 a las 21:02:04
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
-- Estructura de tabla para la tabla `documentos_intervencion`
--

CREATE TABLE IF NOT EXISTS `documentos_intervencion` (
  `Id` int(13) NOT NULL,
  `No_HV` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo_Intervencion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Archivo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestasatisfaccionfallareportada`
--

CREATE TABLE IF NOT EXISTS `encuestasatisfaccionfallareportada` (
  `Id` int(13) NOT NULL,
  `Cod_Reporte` int(15) NOT NULL,
  `Tipo_Reporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Proveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Tecnico` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Pregunta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Calificacion` int(14) NOT NULL,
  `Evaluado_Por` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Evaluacion` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factor_correccion`
--

CREATE TABLE IF NOT EXISTS `factor_correccion` (
  `Id` int(15) NOT NULL,
  `Cod_Equipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Reporte_Calibracion` varchar(50) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `Factor_Correccion` double NOT NULL,
  `Nombre_Registra` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Sistema` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `factor_correccion`
--

INSERT INTO `factor_correccion` (`Id`, `Cod_Equipo`, `Cod_Reporte_Calibracion`, `Factor_Correccion`, `Nombre_Registra`, `Fecha_Sistema`) VALUES
(42, 'DM-1', '1', 0.22, 'Juan84', '2017-03-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoja_vida`
--

CREATE TABLE IF NOT EXISTS `hoja_vida` (
  `Id` int(50) NOT NULL,
  `No_HV` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Version` int(100) NOT NULL,
  `Tipo_Equipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Equipo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Proveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Modelo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `No_Serie` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Marca` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Voltaje` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Amperaje` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Potencia` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Caracteristicas` varchar(700) COLLATE utf8_spanish_ci NOT NULL,
  `Razon_SocialProveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nit_Proveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad_Proveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion_Proveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono_Proveedor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Celular_Proveedor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Registro_Invima` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Inversion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Edad_Equipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Vida_Contable` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Disp_Soporte_Repuestos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Disp_Soporte_Consumibles` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte_Tecnico_Respuestos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_CreacionHV` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1514 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `hoja_vida`
--

INSERT INTO `hoja_vida` (`Id`, `No_HV`, `Version`, `Tipo_Equipo`, `Nombre_Equipo`, `Nombre_Proveedor`, `Modelo`, `No_Serie`, `Marca`, `Voltaje`, `Amperaje`, `Potencia`, `Caracteristicas`, `Razon_SocialProveedor`, `Nit_Proveedor`, `Ciudad_Proveedor`, `Direccion_Proveedor`, `Telefono_Proveedor`, `Celular_Proveedor`, `Registro_Invima`, `Inversion`, `Edad_Equipo`, `Vida_Contable`, `Disp_Soporte_Repuestos`, `Disp_Soporte_Consumibles`, `Soporte_Tecnico_Respuestos`, `Fecha_CreacionHV`) VALUES
(1513, 'BAR-1', 1, 'Barcos', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2017-03-01'),
(1497, 'DM-1', 1, 'Equipos Cientificos', 'Reloj', 'Proveedor', 'Modelo', 'Serie', 'Marca', 'Voltaje', 'Amperaje', 'Potencia', 'Caracteristicas', 'Razon social', 'Nit proveedor', 'Ciuad', 'Direccion', 'Telefono', 'Celular', 'Invima', '20000', '4', '10', '65', '30', '50', '2017-02-21'),
(1506, 'DM-10', 1, 'Equipos Cientificos', 'Maletin', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2000', '4', '12', '65', '30', '50', '2017-02-22'),
(1507, 'DM-11', 1, 'Equipos Cientificos', 'Bandera', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '20000', '4', '8', '30', '30', '50', '2017-02-22'),
(1508, 'DM-12', 1, 'Equipos Cientificos', 'Faro', '', '', '', '', '', '', '', '', 'Razon Faro', '', '', '', '', '', '', '1200', '3', '12', '30', '65', '1', '2017-02-22'),
(1509, 'DM-13', 1, 'Equipos Cientificos', 'Tren', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '64400', '6', '12', '65', '', '1', '2017-02-22'),
(1510, 'DM-14', 1, 'Equipos Cientificos', 'Block', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2000', '5', '10', '30', '65', '', '2017-03-01'),
(1511, 'DM-15', 1, 'Equipos Cientificos', 'Avion', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2017-03-01'),
(1498, 'DM-2', 1, 'Equipos Cientificos', 'Bus', 'Mercedez', '2017', 'S123', 'MErcedez', '110', '12', '13', 'Tiene 30 puestos', 'Mercedez S.A', 'Nit mercedez', 'Cali', 'Calle 23546', '34243647453', '345675432', 'Invima Mercedez', '43000', '7', '10', '30', '30', '50', '2017-02-22'),
(1499, 'DM-3', 1, 'Equipos Cientificos', 'Avion', 'Boing', '2017', 'S123', 'Boing', '110', '12', '13', 'Ultravelocidad', 'Boing s.a.', 'Nit Proveedor', 'Miami', 'Calle 54', '654323456', '76543245', 'Invima', '32000', '4', '10', '30', '100', '50', '2017-02-22'),
(1500, 'DM-4', 1, 'Equipos Cientificos', 'AutomovProveedoril', '', 'Modelo', 'Serie', 'MArcavI', 'vOLTAKEa', 'Amperaje', 'Potencia', '', 'Razo social', 'Not', 'Ciudad', 'Direccion', 'Telefono', 'Celular', 'Invima', '3200', '4', '12', '30', '30', '50', '2017-02-22'),
(1501, 'DM-5', 1, 'Equipos Cientificos', 'Camara', 'Proveedor', '2015', 'sCamra', 'mARCA Camara', '123', '12', '10', 'Visualizacion nocturna', 'Rzon camara', 'Nit camara', 'Ciduad cali', 'Direccion camara', '2345643', '3465432', 'Invima camara', '4300', '4', '5', '30', '65', '50', '2017-02-22'),
(1502, 'DM-6', 1, 'Equipos Cientificos', 'Ancla', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '3000', '34', '3', '65', '', '1', '2017-02-22'),
(1503, 'DM-7', 1, 'Equipos Cientificos', 'Lacer', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '3000', '4', '7', '65', '65', '50', '2017-02-22'),
(1504, 'DM-8', 1, 'Equipos Cientificos', 'Montacarga', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '4000', '4', '10', '65', '100', '50', '2017-02-22'),
(1505, 'DM-9', 1, 'Equipos Cientificos', 'Buque', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10000', '6', '15', '65', '100', '100', '2017-02-22'),
(1512, 'HV-1', 1, 'Equipos de soporte', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2017-03-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_equipos`
--

CREATE TABLE IF NOT EXISTS `imagenes_equipos` (
  `Id` int(13) NOT NULL,
  `No_HV` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Ruta` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=566 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `imagenes_equipos`
--

INSERT INTO `imagenes_equipos` (`Id`, `No_HV`, `Ruta`) VALUES
(549, 'DM-1', './ImagenEquipos/clock.png'),
(550, 'DM-2', './ImagenEquipos/bus.png'),
(551, 'DM-3', './ImagenEquipos/aeroplane.png'),
(552, 'DM-4', './ImagenEquipos/car.png'),
(553, 'DM-5', './ImagenEquipos/cctv.png'),
(554, 'DM-6', './ImagenEquipos/anchor.png'),
(555, 'DM-7', './ImagenEquipos/barcode-scanner.png'),
(556, 'DM-8', './ImagenEquipos/crane.png'),
(557, 'DM-9', './ImagenEquipos/cargo-ship.png'),
(558, 'DM-10', './ImagenEquipos/briefcase.png'),
(559, 'DM-11', './ImagenEquipos/flag.png'),
(560, 'DM-12', './ImagenEquipos/lighthouse.png'),
(561, 'DM-13', './ImagenEquipos/train.png'),
(562, 'DM-14', './ImagenEquipos/aeroplane.png'),
(563, 'DM-15', ''),
(564, 'HV-1', './tmp/24-hours.png'),
(565, 'BAR-1', './tmp/aeroplane.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_proveedor`
--

CREATE TABLE IF NOT EXISTS `informacion_proveedor` (
  `Id` int(15) NOT NULL,
  `Nombre_Proveedor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Celular` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `informacion_proveedor`
--

INSERT INTO `informacion_proveedor` (`Id`, `Nombre_Proveedor`, `Ciudad`, `Direccion`, `Telefono`, `Celular`, `Contacto`) VALUES
(4, 'Mesura', 'Cali', 'Calle 20', '316-21-23', '316-34243-53', 'Ferney'),
(5, 'Metrologic', 'Cali', 'Calle 20 1234', '432 543 65', '2343 345 234', 'Diana Mejia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervenciones`
--

CREATE TABLE IF NOT EXISTS `intervenciones` (
  `Id` int(100) NOT NULL,
  `HV_Equipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Version_Ubicacion` int(100) NOT NULL,
  `Version_Intervencion` int(100) NOT NULL,
  `Tipo_Intervencion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Frecuencia` int(100) NOT NULL,
  `Aplica_Desde` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1110 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `intervenciones`
--

INSERT INTO `intervenciones` (`Id`, `HV_Equipo`, `Version_Ubicacion`, `Version_Intervencion`, `Tipo_Intervencion`, `Frecuencia`, `Aplica_Desde`) VALUES
(1056, 'DM-1', 1, 1, 'Mantenimiento preventivo', 40, 'Puesta en marcha'),
(1057, 'DM-1', 1, 1, 'Verificacion', 50, 'Puesta en marcha'),
(1058, 'DM-1', 1, 1, 'Calibracion', 60, 'Puesta en marcha'),
(1059, 'DM-2', 1, 1, 'Mantenimiento preventivo', 30, 'Puesta en marcha'),
(1060, 'DM-2', 1, 1, 'Verificacion', 40, 'Puesta en marcha'),
(1061, 'DM-2', 1, 1, 'Calibracion', 50, 'Puesta en marcha'),
(1062, 'DM-2', 1, 1, 'Calificacion', 60, 'Puesta en marcha'),
(1063, 'DM-2', 1, 1, 'LIMPIEZA', 70, 'Puesta en marcha'),
(1064, 'DM-3', 1, 1, 'Mantenimiento preventivo', 40, 'Puesta en marcha'),
(1065, 'DM-3', 1, 1, 'Verificacion', 40, 'Puesta en marcha'),
(1066, 'DM-3', 1, 1, 'Calibracion', 50, 'Puesta en marcha'),
(1067, 'DM-4', 1, 1, 'Mantenimiento preventivo', 50, 'Puesta en marcha'),
(1068, 'DM-4', 1, 1, 'Verificacion', 60, 'Puesta en marcha'),
(1069, 'DM-4', 1, 1, 'Calibracion', 100, 'Puesta en marcha'),
(1070, 'DM-4', 1, 1, 'Calificacion', 120, 'Puesta en marcha'),
(1071, 'DM-5', 1, 1, 'Mantenimiento preventivo', 100, 'Puesta en marcha'),
(1072, 'DM-5', 1, 1, 'Verificacion', 130, 'Puesta en marcha'),
(1073, 'DM-5', 1, 1, 'Calibracion', 150, 'Puesta en marcha'),
(1074, 'DM-5', 1, 1, 'DESINFECCION', 100, 'Puesta en marcha'),
(1075, 'DM-6', 1, 1, 'Mantenimiento preventivo', 30, 'Puesta en marcha'),
(1076, 'DM-6', 1, 1, 'Verificacion', 40, 'Puesta en marcha'),
(1077, 'DM-6', 1, 1, 'Calibracion', 50, 'Puesta en marcha'),
(1078, 'DM-7', 1, 1, 'Mantenimiento preventivo', 40, 'Puesta en marcha'),
(1079, 'DM-7', 1, 1, 'Verificacion', 50, 'Puesta en marcha'),
(1080, 'DM-7', 1, 1, 'Calibracion', 60, 'Puesta en marcha'),
(1081, 'DM-7', 1, 1, 'Calificacion', 70, 'Puesta en marcha'),
(1082, 'DM-7', 1, 1, 'LIMPIEZA', 100, 'Puesta en marcha'),
(1083, 'DM-8', 1, 1, 'Mantenimiento preventivo', 40, 'Puesta en marcha'),
(1084, 'DM-8', 1, 1, 'Verificacion', 50, 'Puesta en marcha'),
(1085, 'DM-8', 1, 1, 'Calibracion', 60, 'Puesta en marcha'),
(1086, 'DM-8', 1, 1, 'Calificacion', 70, 'Puesta en marcha'),
(1087, 'DM-9', 1, 1, 'Mantenimiento preventivo', 50, 'Puesta en marcha'),
(1088, 'DM-9', 1, 1, 'Verificacion', 80, 'Puesta en marcha'),
(1089, 'DM-9', 1, 1, 'Calibracion', 90, 'Puesta en marcha'),
(1090, 'DM-9', 1, 1, 'DESINFECCION', 100, 'Puesta en marcha'),
(1091, 'DM-10', 1, 1, 'Mantenimiento preventivo', 50, 'Puesta en marcha'),
(1092, 'DM-10', 1, 1, 'Verificacion', 60, 'Puesta en marcha'),
(1093, 'DM-10', 1, 1, 'Calibracion', 70, 'Puesta en marcha'),
(1094, 'DM-11', 1, 1, 'Mantenimiento preventivo', 40, 'Puesta en marcha'),
(1095, 'DM-11', 1, 1, 'Verificacion', 50, 'Puesta en marcha'),
(1096, 'DM-11', 1, 1, 'Calibracion', 60, 'Puesta en marcha'),
(1097, 'DM-11', 1, 1, 'Calificacion', 70, 'Puesta en marcha'),
(1098, 'DM-12', 1, 1, 'Mantenimiento preventivo', 40, 'Puesta en marcha'),
(1099, 'DM-12', 1, 1, 'Verificacion', 50, 'Puesta en marcha'),
(1100, 'DM-12', 1, 1, 'Calibracion', 60, 'Puesta en marcha'),
(1101, 'DM-12', 1, 1, 'Calificacion', 60, 'Puesta en marcha'),
(1102, 'DM-13', 1, 1, 'Mantenimiento preventivo', 40, 'Puesta en marcha'),
(1103, 'DM-13', 1, 1, 'Verificacion', 50, 'Puesta en marcha'),
(1104, 'DM-13', 1, 1, 'Calibracion', 60, 'Puesta en marcha'),
(1105, 'DM-13', 1, 1, 'Calificacion', 70, 'Puesta en marcha'),
(1106, 'DM-14', 1, 1, 'Mantenimiento preventivo', 30, 'Puesta en marcha'),
(1107, 'DM-14', 1, 1, 'Verificacion', 20, 'Puesta en marcha'),
(1108, 'DM-14', 1, 1, 'Calibracion', 50, 'Puesta en marcha'),
(1109, 'DM-14', 1, 1, 'Calificacion', 60, 'Puesta en marcha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervencionmetrologica`
--

CREATE TABLE IF NOT EXISTS `intervencionmetrologica` (
  `Id` int(100) NOT NULL,
  `HV_Equipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Version` int(100) NOT NULL,
  `Tipo_Intervencion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Frecuencia` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obsolescencia`
--

CREATE TABLE IF NOT EXISTS `obsolescencia` (
  `Id` int(15) NOT NULL,
  `Cod_Equipo` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Ciclo_Obsolescencia` int(15) NOT NULL,
  `Fecha_Ciclo` date NOT NULL,
  `Disp_Soportes_Consumibles` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Eventos_Adversos` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Vida_Util_Contable` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Edad_Equipo` int(20) NOT NULL,
  `Cant_Manto_Correctivo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Proveed_SoporT_SinRepuestos` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Disp_Soporte_Repuestos` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Operabilidad_Equipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Satisfaccion_Equipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Cobertura_Necesidades` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Inversion_Adquisicion` int(50) NOT NULL,
  `Gastos_Manto` int(50) NOT NULL,
  `Indice_Obsolescencia` int(50) NOT NULL,
  `Indice_Cualitativo` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `Indice_Significado` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Estimacion` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `obsolescencia`
--

INSERT INTO `obsolescencia` (`Id`, `Cod_Equipo`, `Ciclo_Obsolescencia`, `Fecha_Ciclo`, `Disp_Soportes_Consumibles`, `Eventos_Adversos`, `Vida_Util_Contable`, `Edad_Equipo`, `Cant_Manto_Correctivo`, `Proveed_SoporT_SinRepuestos`, `Disp_Soporte_Repuestos`, `Operabilidad_Equipo`, `Satisfaccion_Equipo`, `Cobertura_Necesidades`, `Inversion_Adquisicion`, `Gastos_Manto`, `Indice_Obsolescencia`, `Indice_Cualitativo`, `Indice_Significado`, `Fecha_Estimacion`) VALUES
(111, 'DM-1', 1, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 58, 'RenovaciÃ³n de tecnologÃ­a a la brevedad (Plazo inferior a un aÃ±o)', 'El equipo puede mantenerse en el servicio y se recomienda su reposiciÃ³n en un plazo inferior a un aÃ±o.', '2017-02-22'),
(112, 'DM-2', 1, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 32, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(113, 'DM-3', 1, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 36, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(114, 'DM-1', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 61, 'RenovaciÃ³n de tecnologÃ­a a la brevedad (Plazo inferior a un aÃ±o)', 'El equipo puede mantenerse en el servicio y se recomienda su reposiciÃ³n en un plazo inferior a un aÃ±o.', '2017-02-22'),
(115, 'DM-10', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 33, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(116, 'DM-11', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 31, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(117, 'DM-12', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 28, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(118, 'DM-2', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 32, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(119, 'DM-3', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 36, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(120, 'DM-4', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 30, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(121, 'DM-5', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 36, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(122, 'DM-7', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 37, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(123, 'DM-8', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 39, 'Evaluar tecnologÃ­a en un aÃ±o', 'El equipo se encuentra en condiciones aceptables de funcionamiento pero requiere constante seguimiento y evaluaciÃ³n.', '2017-02-22'),
(124, 'DM-9', 2, '2017-02-22', 'Disp_Soportes_Consum', 'Eventos_Adversos', 'Vida_Util_Contable', 0, 'Cant_Manto_Correctivo', 'Proveed_SoporT_SinRe', 'Disp_Soporte_Repuest', 'Operabilidad_Equipo', 'Satisfaccion_Equipo', 'Cobertura_Necesidade', 0, 0, 44, 'RenovaciÃ³n de tecnologÃ­a a la brevedad (Plazo inferior a un aÃ±o)', 'El equipo puede mantenerse en el servicio y se recomienda su reposiciÃ³n en un plazo inferior a un aÃ±o.', '2017-02-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programacion_especifica`
--

CREATE TABLE IF NOT EXISTS `programacion_especifica` (
  `Id` int(15) NOT NULL,
  `No_HV` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo_Intervenciones` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Programada` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programacion_intervencion`
--

CREATE TABLE IF NOT EXISTS `programacion_intervencion` (
  `Id` int(100) NOT NULL,
  `Cod_Servicio` int(13) NOT NULL,
  `HV_Equipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Version_Programacion` int(10) NOT NULL,
  `Version_Intervencion` int(13) NOT NULL,
  `Tipo_Intervencion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Solicitud` date NOT NULL,
  `Fecha_Programada` date NOT NULL,
  `Nombre_Proveedor` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `Observacion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Sistema` date NOT NULL,
  `Fecha_Realizacion` date NOT NULL,
  `Estado` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `programacion_intervencion`
--

INSERT INTO `programacion_intervencion` (`Id`, `Cod_Servicio`, `HV_Equipo`, `Version_Programacion`, `Version_Intervencion`, `Tipo_Intervencion`, `Fecha_Solicitud`, `Fecha_Programada`, `Nombre_Proveedor`, `Observacion`, `Fecha_Sistema`, `Fecha_Realizacion`, `Estado`) VALUES
(113, 1, 'DM-1', 1, 1, 'Calibracion', '2017-02-22', '2017-02-22', 'Mesura', 'Por favor revisa esta solicitud', '2017-02-22', '2017-02-22', 'Finalizado'),
(114, 1, 'DM-1', 1, 1, 'Mantenimiento preventivo', '2017-02-22', '2017-02-22', 'Mesura', 'Por favor revisa esta solicitud', '2017-02-22', '2017-02-22', 'Finalizado'),
(115, 1, 'DM-1', 1, 1, 'Verificacion', '2017-02-22', '2017-02-22', 'Mesura', 'Por favor revisa esta solicitud', '2017-02-22', '2017-02-22', 'Finalizado'),
(116, 2, 'DM-4', 1, 1, 'Mantenimiento preventivo', '2017-02-22', '2017-02-22', 'Metrologic', 'Por favor atienede con prioridad estos equipos', '2017-02-22', '0000-00-00', 'Pendiente'),
(117, 3, 'DM-11', 1, 1, 'Calibracion', '2017-03-01', '2017-03-01', 'Mesura', 'Por favor con prioridad', '2017-03-01', '0000-00-00', 'Pendiente'),
(118, 3, 'DM-11', 1, 1, 'Calificacion', '2017-03-01', '2017-03-01', 'Mesura', 'Por favor con prioridad', '2017-03-01', '0000-00-00', 'Pendiente'),
(119, 3, 'DM-11', 1, 1, 'Mantenimiento preventivo', '2017-03-01', '2017-03-01', 'Mesura', 'Por favor con prioridad', '2017-03-01', '0000-00-00', 'Pendiente'),
(120, 3, 'DM-11', 1, 1, 'Verificacion', '2017-03-01', '2017-03-01', 'Mesura', 'Por favor con prioridad', '2017-03-01', '0000-00-00', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE IF NOT EXISTS `prueba` (
  `id` int(14) NOT NULL,
  `Cod_Mes` int(50) NOT NULL,
  `Nombre_Mes` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id`, `Cod_Mes`, `Nombre_Mes`) VALUES
(1, 1, 'Ene'),
(2, 2, 'Feb'),
(3, 3, 'Mar'),
(4, 4, 'Abr'),
(5, 5, 'May'),
(6, 6, 'Jun'),
(7, 7, 'Jul'),
(8, 8, 'Ago'),
(9, 9, 'Sep'),
(10, 10, 'Oct'),
(11, 11, 'Nov'),
(12, 12, 'Dic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesta_marcha`
--

CREATE TABLE IF NOT EXISTS `puesta_marcha` (
  `Id` int(100) NOT NULL,
  `No_HV` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Version` int(50) NOT NULL,
  `Sede` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Area` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `SubArea` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Marcha` date NOT NULL,
  `Fecha_Descarte` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=566 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `puesta_marcha`
--

INSERT INTO `puesta_marcha` (`Id`, `No_HV`, `Version`, `Sede`, `Area`, `SubArea`, `Fecha_Marcha`, `Fecha_Descarte`) VALUES
(543, 'DM-1', 1, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-21', '0000-00-00'),
(544, 'DM-1', 2, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-21', '0000-00-00'),
(545, 'DM-1', 3, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-21', '0000-00-00'),
(546, 'DM-1', 4, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-21', '0000-00-00'),
(547, 'DM-1', 5, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-21', '0000-00-00'),
(548, 'DM-1', 6, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-21', '0000-00-00'),
(549, 'DM-2', 1, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-22', '0000-00-00'),
(550, 'DM-2', 2, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-22', '0000-00-00'),
(551, 'DM-3', 1, 'Cali', 'Bioindustrial', 'MicrobiologÃ­a', '2017-02-22', '0000-00-00'),
(552, 'DM-4', 1, 'Cali', 'Bioindustrial', 'MicrobiologÃ­a', '2017-02-22', '0000-00-00'),
(553, 'DM-5', 1, 'Cali', 'Central de procesos', 'Fisicoquimico', '2017-02-22', '0000-00-00'),
(554, 'DM-6', 1, 'Cali', 'Bioindustrial', 'MicrobiologÃ­a', '2017-02-22', '0000-00-00'),
(555, 'DM-7', 1, 'Cali', 'Bioindustrial', 'MicrobiologÃ­a', '2017-02-08', '0000-00-00'),
(556, 'DM-8', 1, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-15', '0000-00-00'),
(557, 'DM-9', 1, 'Cali', 'Bioindustrial', 'Fisicoquimico', '2017-02-22', '0000-00-00'),
(558, 'DM-10', 1, 'Cali', 'Central de procesos', 'Fisicoquimico', '2017-02-16', '0000-00-00'),
(559, 'DM-11', 1, 'Cali', 'Bioindustrial', 'Quimica', '2017-02-22', '0000-00-00'),
(560, 'DM-12', 1, 'Cali', 'Bioindustrial', 'MicrobiologÃ­a', '2017-02-15', '0000-00-00'),
(561, 'DM-13', 1, 'Cali', 'Central de procesos', 'Fisicoquimico', '2017-02-22', '0000-00-00'),
(562, 'DM-14', 1, 'Cali', 'Bioindustrial', 'MicrobiologÃ­a', '2017-03-01', '0000-00-00'),
(563, 'DM-15', 1, '', 'Todos', '', '0000-00-00', '0000-00-00'),
(564, 'HV-1', 1, '', 'Todos', '', '0000-00-00', '0000-00-00'),
(565, 'BAR-1', 1, '', 'Todos', '', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes_intervencion`
--

CREATE TABLE IF NOT EXISTS `reportes_intervencion` (
  `Id` int(100) NOT NULL,
  `No_Intervencion` int(50) NOT NULL,
  `Cod_Reporte_Falla` int(14) NOT NULL,
  `HV_Equipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Version_Intervencion` int(100) NOT NULL,
  `Tipo_Intervencion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Esperada` date NOT NULL,
  `Fecha_Intervencion` date NOT NULL,
  `Descripcion` varchar(700) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Proveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Tecnico` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Recibe_Trabajo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Estado_Equipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Registro` date NOT NULL,
  `Estado_Intervencion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Tiempo_Intervencion` int(50) NOT NULL,
  `Costo_Intervencion` int(50) NOT NULL,
  `Cod_Mes_Esperado` varchar(13) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=521 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reportes_intervencion`
--

INSERT INTO `reportes_intervencion` (`Id`, `No_Intervencion`, `Cod_Reporte_Falla`, `HV_Equipo`, `Version_Intervencion`, `Tipo_Intervencion`, `Fecha_Esperada`, `Fecha_Intervencion`, `Descripcion`, `Nombre_Proveedor`, `Nombre_Tecnico`, `Nombre_Recibe_Trabajo`, `Estado_Equipo`, `Fecha_Registro`, `Estado_Intervencion`, `Tiempo_Intervencion`, `Costo_Intervencion`, `Cod_Mes_Esperado`) VALUES
(515, 1, 0, 'DM-1', 1, 'Calibracion', '2017-02-21', '2017-02-22', 'Se realiza la calibracion', 'Mesura', 'Juan David GarcÃ­a', 'Juan84', 'Intervencion efectiva', '2017-02-22', 'Aprobado', 22, 32000, '02'),
(516, 2, 0, 'DM-1', 1, 'Mantenimiento preventivo', '2017-02-21', '2017-02-22', 'Se realiza el mantenimiento preventivo', 'Mesura', 'Juan David GarcÃ­a', 'Juan84', 'Intervencion efectiva', '2017-02-22', 'Aprobado', 32, 32345, '02'),
(517, 3, 0, 'DM-1', 1, 'Verificacion', '2017-02-21', '2017-02-22', 'Se realliza la verificacion', 'Mesura', 'Juan David GarcÃ­a', 'Juan84', 'Intervencion efectiva', '2017-02-22', '', 22, 0, '02'),
(518, 4, 1, 'DM-1', 1, 'Mantenimiento correctivo', '2017-02-21', '2017-02-22', 'Se realiza el mantenimiento correctivo', 'Mesura', 'Juan David GarcÃ­a', 'Juan84', 'Intervencion efectiva', '2017-02-22', '', 32, 3200, '02'),
(519, 4, 1, 'DM-1', 1, 'Mantenimiento correctivo', '1970-01-01', '2017-02-22', 'Se realiza el mantenimiento correctivo', 'Mesura', 'Juan David GarcÃ­a', 'Juan84', 'Intervencion efectiva', '2017-02-22', '', 32, 3200, '01'),
(520, 5, 0, 'DM-14', 1, 'Calibracion', '2017-03-01', '2017-03-01', 'se realiza revision de  el dispositivo DM-14', 'Mesura', 'Leonardo', 'Juan84', 'Intervencion efectiva', '2017-03-01', '', 0, 50000, '03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_fallas_equipos`
--

CREATE TABLE IF NOT EXISTS `reporte_fallas_equipos` (
  `Id` int(13) NOT NULL,
  `HV_Equipo` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `Estado_Equipo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Reporte` date NOT NULL,
  `Fecha_Fallo_Equipo` date NOT NULL,
  `Nombre_Reporta` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Prioridad` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Reporte` int(20) NOT NULL,
  `Fecha_Ejecutado` date NOT NULL,
  `Anio_Reporte` int(40) NOT NULL,
  `Mes_Reporte` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reporte_fallas_equipos`
--

INSERT INTO `reporte_fallas_equipos` (`Id`, `HV_Equipo`, `Estado_Equipo`, `Descripcion`, `Fecha_Reporte`, `Fecha_Fallo_Equipo`, `Nombre_Reporta`, `Prioridad`, `Cod_Reporte`, `Fecha_Ejecutado`, `Anio_Reporte`, `Mes_Reporte`) VALUES
(74, 'DM-1', 'Fuera de uso', 'El equipo dejo de funcionar', '2017-02-22', '2017-02-22', 'Juan84', 'Media', 1, '2017-02-22', 2017, 'Feb'),
(75, 'DM-1', 'Fuera de uso', 'El equipo dejop de funcionar', '2017-03-01', '2017-03-01', 'Juan84', 'Alta', 2, '0000-00-00', 2017, 'Mar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riesgos_equipos`
--

CREATE TABLE IF NOT EXISTS `riesgos_equipos` (
  `Id` int(15) NOT NULL,
  `No_HV` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Invasividad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `TipoRiesgo_Equipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Riesgo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `Icono` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=888 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `riesgos_equipos`
--

INSERT INTO `riesgos_equipos` (`Id`, `No_HV`, `Invasividad`, `TipoRiesgo_Equipo`, `Riesgo`, `Icono`) VALUES
(869, 'DM-1', '', '', 'Riesgo de atrapamiento', './images/Senalizacion_Riesgos/Riesgo_Atrapamiento.png'),
(870, 'DM-1', '', '', 'Riesgo electrico', './images/Senalizacion_Riesgos/Riesgo_Electrico.png'),
(871, 'DM-1', '', '', 'Precaucion riesgo especifico', './images/Senalizacion_Riesgos/Riesgo_Especifico.png'),
(872, 'DM-1', 'No Invasivo', 'Clase I', 'Riesgo electrico', './images/Senalizacion_Riesgos/Riesgo_Electrico.png'),
(873, 'DM-1', 'No Invasivo', 'Clase I', 'Precaucion riesgo especifico', './images/Senalizacion_Riesgos/Riesgo_Especifico.png'),
(874, 'DM-1', 'No Invasivo', 'Clase I', 'Riesgo electrico', './images/Senalizacion_Riesgos/Riesgo_Electrico.png'),
(875, 'DM-1', 'No Invasivo', 'Clase I', 'Riesgo de radiaciones laser', './images/Senalizacion_Riesgos/Radiaciones_Laser.png'),
(876, 'DM-1', 'No Invasivo', 'Clase I', 'Riesgo bajas temperaturas', './images/Senalizacion_Riesgos/Bajas_Temperaturas.png'),
(877, 'DM-2', 'No Invasivo', 'Clase IIa', 'Precaucion riesgo especifico', './images/Senalizacion_Riesgos/Riesgo_Especifico.png'),
(878, 'DM-2', 'No Invasivo', 'Clase IIa', 'Riesgo de radiaciones laser', './images/Senalizacion_Riesgos/Radiaciones_Laser.png'),
(879, 'DM-2', 'No Invasivo', 'Clase IIa', 'Riesgo de atrapamiento', './images/Senalizacion_Riesgos/Riesgo_Atrapamiento.png'),
(880, 'DM-2', 'No Invasivo', 'Clase IIa', 'Riesgo electrico', './images/Senalizacion_Riesgos/Riesgo_Electrico.png'),
(881, 'DM-2', 'No Invasivo', 'Clase IIa', 'Riesgo puncion', './images/Senalizacion_Riesgos/Riesgo_Puncion.png'),
(882, 'DM-3', '', '', 'Riesgo de atrapamiento', './images/Senalizacion_Riesgos/Riesgo_Atrapamiento.png'),
(883, 'DM-3', '', '', 'Riesgo electrico', './images/Senalizacion_Riesgos/Riesgo_Electrico.png'),
(884, 'DM-3', '', '', 'Riesgo de radiaciones laser', './images/Senalizacion_Riesgos/Radiaciones_Laser.png'),
(885, 'DM-1', 'No Invasivo', 'Clase I', 'Riesgo puncion', './images/Senalizacion_Riesgos/Riesgo_Puncion.png'),
(886, 'DM-1', 'No Invasivo', 'Clase I', 'Riesgo de atrapamiento', './images/Senalizacion_Riesgos/Riesgo_Atrapamiento.png'),
(887, 'DM-1', 'No Invasivo', 'Clase I', 'Precaucion riesgo especifico', './images/Senalizacion_Riesgos/Riesgo_Especifico.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `satisfaccion_usuarion`
--

CREATE TABLE IF NOT EXISTS `satisfaccion_usuarion` (
  `Id` int(13) NOT NULL,
  `Cod_Reporte` int(15) NOT NULL,
  `Tipo_Reporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Proveedor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Tecnico` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Pregunta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Calificacion` int(14) NOT NULL,
  `Evaluado_Por` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Evaluacion` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=513 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `satisfaccion_usuarion`
--

INSERT INTO `satisfaccion_usuarion` (`Id`, `Cod_Reporte`, `Tipo_Reporte`, `Nombre_Proveedor`, `Nombre_Tecnico`, `Pregunta`, `Calificacion`, `Evaluado_Por`, `Fecha_Evaluacion`) VALUES
(509, 1, 'Calibracion', 'Mesura', 'Juan David GarcÃ­a', 'Oportunidad en la reparacion', 5, 'Juan84', '2017-03-01'),
(510, 1, 'Calibracion', 'Mesura', 'Juan David GarcÃ­a', 'Reparacion resuelta eficaz', 5, 'Juan84', '2017-03-01'),
(511, 1, 'Calibracion', 'Mesura', 'Juan David GarcÃ­a', 'Actitud del tecnico', 3, 'Juan84', '2017-03-01'),
(512, 1, 'Calibracion', 'Mesura', 'Juan David GarcÃ­a', 'Competencia del tecnico', 5, 'Juan84', '2017-03-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_equipo`
--

CREATE TABLE IF NOT EXISTS `tipo_equipo` (
  `Id` int(100) NOT NULL,
  `Tipo_Equipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Codigo_Equipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_equipo`
--

INSERT INTO `tipo_equipo` (`Id`, `Tipo_Equipo`, `Codigo_Equipo`) VALUES
(8, 'Equipos de soporte', 'HV-'),
(9, 'Equipos Cientificos', 'DM-'),
(10, 'Equipos informaticos', 'SIS-'),
(11, 'Dispositivo Medico', 'Dis-'),
(12, 'Barcos', 'BAR-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE IF NOT EXISTS `ubicaciones` (
  `Id` int(13) NOT NULL,
  `Sede` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Area` varchar(50) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `Sub_Area` varchar(50) CHARACTER SET utf16 COLLATE utf16_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`Id`, `Sede`, `Area`, `Sub_Area`) VALUES
(8, 'Cali', 'Central de procesos', 'MicrobiologÃ­a'),
(9, 'Cali', 'Central de procesos', 'Quimica'),
(10, 'Cali', 'Bioindustrial', 'Fisicoquimico'),
(14, 'Cali', 'Bioindustrial', 'MicrobiologÃ­a');

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
-- Indices de la tabla `documentos_intervencion`
--
ALTER TABLE `documentos_intervencion`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `encuestasatisfaccionfallareportada`
--
ALTER TABLE `encuestasatisfaccionfallareportada`
  ADD KEY `Id` (`Id`);

--
-- Indices de la tabla `factor_correccion`
--
ALTER TABLE `factor_correccion`
  ADD KEY `Id` (`Id`);

--
-- Indices de la tabla `hoja_vida`
--
ALTER TABLE `hoja_vida`
  ADD PRIMARY KEY (`No_HV`),
  ADD KEY `Id` (`Id`),
  ADD KEY `Tipo_Equipo` (`Tipo_Equipo`);

--
-- Indices de la tabla `imagenes_equipos`
--
ALTER TABLE `imagenes_equipos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `informacion_proveedor`
--
ALTER TABLE `informacion_proveedor`
  ADD KEY `Id` (`Id`);

--
-- Indices de la tabla `intervenciones`
--
ALTER TABLE `intervenciones`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `HV_Equipo` (`HV_Equipo`),
  ADD KEY `Id` (`Id`);

--
-- Indices de la tabla `intervencionmetrologica`
--
ALTER TABLE `intervencionmetrologica`
  ADD KEY `Id` (`Id`);

--
-- Indices de la tabla `obsolescencia`
--
ALTER TABLE `obsolescencia`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `programacion_especifica`
--
ALTER TABLE `programacion_especifica`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `programacion_intervencion`
--
ALTER TABLE `programacion_intervencion`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puesta_marcha`
--
ALTER TABLE `puesta_marcha`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `No_HV` (`No_HV`),
  ADD KEY `Id` (`Id`);

--
-- Indices de la tabla `reportes_intervencion`
--
ALTER TABLE `reportes_intervencion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id` (`Id`);

--
-- Indices de la tabla `reporte_fallas_equipos`
--
ALTER TABLE `reporte_fallas_equipos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `riesgos_equipos`
--
ALTER TABLE `riesgos_equipos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `satisfaccion_usuarion`
--
ALTER TABLE `satisfaccion_usuarion`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `tipo_equipo`
--
ALTER TABLE `tipo_equipo`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Tipo_Equipo` (`Tipo_Equipo`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `usuarios_creados`
--
ALTER TABLE `usuarios_creados`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `documentos_intervencion`
--
ALTER TABLE `documentos_intervencion`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `encuestasatisfaccionfallareportada`
--
ALTER TABLE `encuestasatisfaccionfallareportada`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT de la tabla `factor_correccion`
--
ALTER TABLE `factor_correccion`
  MODIFY `Id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `hoja_vida`
--
ALTER TABLE `hoja_vida`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1514;
--
-- AUTO_INCREMENT de la tabla `imagenes_equipos`
--
ALTER TABLE `imagenes_equipos`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=566;
--
-- AUTO_INCREMENT de la tabla `informacion_proveedor`
--
ALTER TABLE `informacion_proveedor`
  MODIFY `Id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `intervenciones`
--
ALTER TABLE `intervenciones`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1110;
--
-- AUTO_INCREMENT de la tabla `intervencionmetrologica`
--
ALTER TABLE `intervencionmetrologica`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `obsolescencia`
--
ALTER TABLE `obsolescencia`
  MODIFY `Id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT de la tabla `programacion_especifica`
--
ALTER TABLE `programacion_especifica`
  MODIFY `Id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `programacion_intervencion`
--
ALTER TABLE `programacion_intervencion`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `puesta_marcha`
--
ALTER TABLE `puesta_marcha`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=566;
--
-- AUTO_INCREMENT de la tabla `reportes_intervencion`
--
ALTER TABLE `reportes_intervencion`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=521;
--
-- AUTO_INCREMENT de la tabla `reporte_fallas_equipos`
--
ALTER TABLE `reporte_fallas_equipos`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT de la tabla `riesgos_equipos`
--
ALTER TABLE `riesgos_equipos`
  MODIFY `Id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=888;
--
-- AUTO_INCREMENT de la tabla `satisfaccion_usuarion`
--
ALTER TABLE `satisfaccion_usuarion`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=513;
--
-- AUTO_INCREMENT de la tabla `tipo_equipo`
--
ALTER TABLE `tipo_equipo`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `usuarios_creados`
--
ALTER TABLE `usuarios_creados`
  MODIFY `Id` int(13) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
