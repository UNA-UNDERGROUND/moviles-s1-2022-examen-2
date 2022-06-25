-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2022 a las 06:09:47
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbfitgymapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbactivity`
--

CREATE TABLE `tbactivity` (
  `idday` int(11) NOT NULL,
  `idtrainingplan` int(11) NOT NULL,
  `nameactivity` varchar(50) NOT NULL,
  `repetitionsactivity` int(11) NOT NULL,
  `breaksactivity` int(11) NOT NULL,
  `seriesactivity` int(11) NOT NULL,
  `cadenceactivity` int(11) NOT NULL,
  `weightactivity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbactivity`
--

INSERT INTO `tbactivity` (`idday`, `idtrainingplan`, `nameactivity`, `repetitionsactivity`, `breaksactivity`, `seriesactivity`, `cadenceactivity`, `weightactivity`) VALUES
(1, 1, 'Cardio', 3, 2, 5, 0, 5),
(2, 2, 'Ritmos', 3, 0, 0, 0, 0),
(6, 3, 'Pecho', 5, 0, 0, 0, 0),
(6, 3, 'Brazo', 0, 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbday`
--

CREATE TABLE `tbday` (
  `idday` int(11) NOT NULL,
  `nameday` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbday`
--

INSERT INTO `tbday` (`idday`, `nameday`) VALUES
(1, 'LUNES'),
(2, 'MARTES'),
(3, 'MIÉRCOLES'),
(4, 'JUEVES'),
(5, 'VIERNES'),
(6, 'SÁBADO'),
(7, 'DOMINGO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfavoriteplan`
--

CREATE TABLE `tbfavoriteplan` (
  `idfavoriteplan` int(11) NOT NULL,
  `idplan` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `typeplan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbfavoriteplan`
--

INSERT INTO `tbfavoriteplan` (`idfavoriteplan`, `idplan`, `iduser`, `typeplan`) VALUES
(1, 4, 1, 2),
(3, 2, 1, 2),
(5, 2, 1, 1),
(6, 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbnutritionplan`
--

CREATE TABLE `tbnutritionplan` (
  `idnutritionplan` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `imagecodeqr` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbnutritionplan`
--

INSERT INTO `tbnutritionplan` (`idnutritionplan`, `name`, `imagecodeqr`) VALUES
(2, 'Plan de nutricion #2', '../resources/files/nutritionQR/PlanNutricional2.png'),
(4, 'Plan de nutricion #4', '../resources/files/nutritionQR/PlanNutricional4.png'),
(5, 'Plan de nutricion #5', '../resources/files/nutritionQR/PlanNutricional5.png'),
(7, 'Plan de nutricion #7', '../resources/files/nutritionQR/PlanNutricional7.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbnutritionplandetails`
--

CREATE TABLE `tbnutritionplandetails` (
  `idnutritionplandetails` int(11) NOT NULL,
  `idnutritionplan` int(11) NOT NULL,
  `foodday` varchar(15) NOT NULL,
  `foodtime` varchar(15) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbnutritionplandetails`
--

INSERT INTO `tbnutritionplandetails` (`idnutritionplandetails`, `idnutritionplan`, `foodday`, `foodtime`, `description`) VALUES
(2, 2, 'Viernes', 'Desayuno', 'Dos huevos con tomate y jugo de zanahoria 500ml'),
(6, 4, 'Sabado', 'Merienda', 'Frutas de cualquier tipo con yogurt'),
(8, 5, 'Miercoles', 'Merienda', 'Dos vasos de agua con galleta integral y barra nutrivia'),
(10, 7, 'Lunes', 'Cena', 'Dos tajadas de queso con pan integral');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtrainingplan`
--

CREATE TABLE `tbtrainingplan` (
  `idtrainingplan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nametrainingplan` varchar(50) NOT NULL,
  `qrcodetrainingplan` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbtrainingplan`
--

INSERT INTO `tbtrainingplan` (`idtrainingplan`, `username`, `nametrainingplan`, `qrcodetrainingplan`) VALUES
(1, 'chinox701', 'Prueba', 'chinox701-1-Prueba'),
(2, 'chinox701', 'Juan', 'chinox701-2-Juan'),
(3, 'chinox701', 'Carlos', 'chinox701-3-Carlos');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbday`
--
ALTER TABLE `tbday`
  ADD PRIMARY KEY (`idday`);

--
-- Indices de la tabla `tbfavoriteplan`
--
ALTER TABLE `tbfavoriteplan`
  ADD PRIMARY KEY (`idfavoriteplan`);

--
-- Indices de la tabla `tbnutritionplan`
--
ALTER TABLE `tbnutritionplan`
  ADD PRIMARY KEY (`idnutritionplan`);

--
-- Indices de la tabla `tbnutritionplandetails`
--
ALTER TABLE `tbnutritionplandetails`
  ADD PRIMARY KEY (`idnutritionplandetails`);

--
-- Indices de la tabla `tbtrainingplan`
--
ALTER TABLE `tbtrainingplan`
  ADD PRIMARY KEY (`idtrainingplan`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbnutritionplandetails`
--
ALTER TABLE `tbnutritionplandetails`
  MODIFY `idnutritionplandetails` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
