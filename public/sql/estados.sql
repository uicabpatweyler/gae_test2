-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-06-2019 a las 01:04:57
-- Versión del servidor: 10.2.23-MariaDB
-- Versión de PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u257167814_age`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(10) UNSIGNED NOT NULL,
  `estado_nombre` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `estado_capital` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `estado_nombre`, `estado_capital`, `created_at`, `updated_at`) VALUES
(1, 'Aguascalientes', 'Aguascalientes', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(2, 'Baja California', 'Mexicali', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(3, 'Baja California Sur', 'La Paz', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(4, 'Campeche', 'Campeche', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(5, 'Coahuila', 'Saltillo', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(6, 'Colima', 'Colima', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(7, 'Chiapas', 'Tuxtla Gutiérrez', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(8, 'Chihuahua', 'Chihuahua', '2017-06-04 07:07:04', '2017-06-04 07:07:04'),
(9, 'Distrito Federal', 'Ciudad de México', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(10, 'Durango', 'Durango', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(11, 'Guanajuato', 'Guanajuato', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(12, 'Guerrero', 'Chilpancingo', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(13, 'Hidalgo', 'Pachuca', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(14, 'Jalisco', 'Guadalajara', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(15, 'México', 'Toluca', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(16, 'Michoacán', 'Morelia', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(17, 'Morelos', 'Cuernavaca', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(18, 'Nayarit', 'Tepic', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(19, 'Nuevo León', 'Monterrey', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(20, 'Oaxaca', 'Oaxaca', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(21, 'Puebla', 'Puebla', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(22, 'Querétaro', 'Querétaro', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(23, 'Quintana Roo', 'Chetumal', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(24, 'San Luis Potosí', 'San Luis Potosí', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(25, 'Sinaloa', 'Culiacán', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(26, 'Sonora', 'Hermosillo', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(27, 'Tabasco', 'Villahermosa', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(28, 'Tamaulipas', 'Ciudad Victoria', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(29, 'Tlaxcala', 'Tlaxcala', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(30, 'Veracruz', 'Xalapa', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(31, 'Yucatán', 'Mérida', '2017-06-04 07:07:05', '2017-06-04 07:07:05'),
(32, 'Zacatecas', 'Zacatecas', '2017-06-04 07:07:05', '2017-06-04 07:07:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
