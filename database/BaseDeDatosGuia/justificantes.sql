-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2024 a las 05:25:41
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
-- Base de datos: `justificantes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `NoControl` int(100) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `SemGru` varchar(100) NOT NULL,
  `Turno` varchar(100) NOT NULL,
  `Tutor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `justificante`
--

CREATE TABLE `justificante` (
  `Folio` int(11) NOT NULL,
  `Estudiante` int(100) NOT NULL,
  `FechaExp` date NOT NULL,
  `MotivoIna` int(11) NOT NULL,
  `FechaIna` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Orientador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivoina`
--

CREATE TABLE `motivoina` (
  `IdMotivo` int(11) NOT NULL,
  `Motivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orientador`
--

CREATE TABLE `orientador` (
  `idOri` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor`
--

CREATE TABLE `tutor` (
  `numTutor` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`NoControl`),
  ADD KEY `Tutor` (`Tutor`);

--
-- Indices de la tabla `justificante`
--
ALTER TABLE `justificante`
  ADD PRIMARY KEY (`Folio`),
  ADD KEY `Estudiante` (`Estudiante`),
  ADD KEY `MotivoIna` (`MotivoIna`),
  ADD KEY `Orientador` (`Orientador`);

--
-- Indices de la tabla `motivoina`
--
ALTER TABLE `motivoina`
  ADD PRIMARY KEY (`IdMotivo`);

--
-- Indices de la tabla `orientador`
--
ALTER TABLE `orientador`
  ADD PRIMARY KEY (`idOri`);

--
-- Indices de la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`numTutor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `NoControl` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `justificante`
--
ALTER TABLE `justificante`
  MODIFY `Folio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `motivoina`
--
ALTER TABLE `motivoina`
  MODIFY `IdMotivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orientador`
--
ALTER TABLE `orientador`
  MODIFY `idOri` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tutor`
--
ALTER TABLE `tutor`
  MODIFY `numTutor` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`Tutor`) REFERENCES `tutor` (`numTutor`);

--
-- Filtros para la tabla `justificante`
--
ALTER TABLE `justificante`
  ADD CONSTRAINT `justificante_ibfk_1` FOREIGN KEY (`Estudiante`) REFERENCES `estudiantes` (`NoControl`),
  ADD CONSTRAINT `justificante_ibfk_2` FOREIGN KEY (`MotivoIna`) REFERENCES `motivoina` (`IdMotivo`),
  ADD CONSTRAINT `justificante_ibfk_3` FOREIGN KEY (`Orientador`) REFERENCES `orientador` (`idOri`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
