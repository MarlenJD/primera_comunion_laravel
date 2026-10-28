-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2026 a las 03:13:13
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
-- Base de datos: `primera_comunion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes`
--

CREATE TABLE `aspirantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `bautismo` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `tutor_id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_inscripcion` date NOT NULL,
  `estado` enum('pendiente','en_revision','confirmada') NOT NULL DEFAULT 'pendiente',
  `registrado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aspirantes`
--

INSERT INTO `aspirantes` (`id`, `nombre`, `fecha_nacimiento`, `domicilio`, `bautismo`, `observaciones`, `tutor_id`, `grupo_id`, `fecha_inscripcion`, `estado`, `registrado_por`, `created_at`, `updated_at`) VALUES
(1, 'Jose Manuel Perez Lopez', '2017-05-14', 'San Simon de la Laguna, Donato Guerra, Estado de Mexico', 'Parroquia de San Simon', 'Documentacion completa y registro confirmado.', 1, 1, '2026-10-05', 'confirmada', 1, '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(2, 'Sofia Hernandez Ramirez', '2018-02-22', 'San Simon de la Laguna, Donato Guerra, Estado de Mexico', 'Parroquia de San Simon', 'Pendiente de entregar documentacion.', 2, 2, '2026-10-10', 'pendiente', 1, '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(3, 'Diego Alejandro Martinez Cruz', '2017-09-08', 'San Simon de la Laguna, Donato Guerra, Estado de Mexico', 'Parroquia de San Simon', 'Documentacion entregada y en proceso de revision.', 3, 3, '2026-10-15', 'en_revision', 1, '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(4, 'Eduardo Bernal Estrada', '1111-11-11', 'San Simon', 'aaa', 'dwefewf', 4, 3, '2026-10-28', 'pendiente', 1, '2026-10-28 08:10:02', '2026-10-28 08:10:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante_documento`
--

CREATE TABLE `aspirante_documento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `aspirante_id` bigint(20) UNSIGNED NOT NULL,
  `documento_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aspirante_documento`
--

INSERT INTO `aspirante_documento` (`id`, `aspirante_id`, `documento_id`, `fecha_entrega`) VALUES
(1, 4, 1, '2026-10-28'),
(2, 4, 3, '2026-10-28'),
(3, 4, 2, '2026-10-28'),
(4, 4, 4, '2026-10-28'),
(5, 4, 5, '2026-10-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catequistas`
--

CREATE TABLE `catequistas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `catequistas`
--

INSERT INTO `catequistas` (`id`, `nombre`, `telefono`, `correo`, `created_at`, `updated_at`) VALUES
(1, 'Maria Elena Lopez Garcia', '7221234501', 'maria.lopez@example.com', '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(2, 'Ana Patricia Hernandez Ruiz', '7221234502', 'ana.hernandez@example.com', '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(3, 'Rosa Isela Martinez Flores', '7221234503', 'rosa.martinez@example.com', '2026-10-28 00:50:31', '2026-10-28 00:50:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `obligatorio` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `nombre`, `obligatorio`, `created_at`, `updated_at`) VALUES
(1, 'Acta de nacimiento', 1, '2026-10-28 05:37:11', '2026-10-28 05:37:11'),
(2, 'Fe de bautismo', 1, '2026-10-28 05:37:11', '2026-10-28 05:37:11'),
(3, 'CURP', 1, '2026-10-28 05:37:11', '2026-10-28 05:37:11'),
(4, 'Fotografia', 1, '2026-10-28 05:37:11', '2026-10-28 05:37:11'),
(5, 'Identificacion del tutor', 1, '2026-10-28 05:37:11', '2026-10-28 05:37:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `catequista_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `horario`, `lugar`, `catequista_id`, `created_at`, `updated_at`) VALUES
(1, 'Grupo San Jose', 'Sabados 10:00 a 12:00', 'Salon parroquial 1', 1, '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(2, 'Grupo Virgen de Guadalupe', 'Domingos 09:00 a 11:00', 'Sal?n parroquial 2', 2, '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(3, 'Grupo Sagrado Corazon', 'Sabados 12:00 a 14:00', 'Salon parroquial 3', 3, '2026-10-28 00:50:31', '2026-10-28 00:50:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_01_01_000001_create_sistema', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutores`
--

CREATE TABLE `tutores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `parentesco` enum('padre','madre','tutor') NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tutores`
--

INSERT INTO `tutores` (`id`, `nombre`, `parentesco`, `telefono`, `domicilio`, `created_at`, `updated_at`) VALUES
(1, 'Laura Lopez Garcia', 'madre', '7222345601', 'San Simon de la Laguna, Donato Guerra, Estado de Mexico', '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(2, 'Carlos Hernandez Ruiz', 'padre', '7222345602', 'San Simon de la Laguna, Donato Guerra, Estado de Mexico', '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(3, 'Patricia Cruz Flores', 'madre', '7222345603', 'San Sim?n de la Laguna, Donato Guerra, Estado de M?xico', '2026-10-28 00:50:31', '2026-10-28 00:50:31'),
(4, 'Irene Estrada', 'madre', '1234567899', 'San Simon', '2026-10-28 08:10:02', '2026-10-28 08:10:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('administrador','encargado','coordinador','catequista') NOT NULL DEFAULT 'encargado',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `rol`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'admin@comunion.local', '$2y$12$f0Y.tM8XTgBaU6JJtlb6J.nyDxFH6CkKHSD78JMZNtFYrMFJNbaYW', 'administrador', NULL, '2026-10-28 05:37:11', '2026-10-28 05:37:11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aspirantes`
--
ALTER TABLE `aspirantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aspirantes_tutor_id_foreign` (`tutor_id`),
  ADD KEY `aspirantes_grupo_id_foreign` (`grupo_id`),
  ADD KEY `aspirantes_registrado_por_foreign` (`registrado_por`),
  ADD KEY `aspirantes_nombre_fecha_nacimiento_index` (`nombre`,`fecha_nacimiento`);

--
-- Indices de la tabla `aspirante_documento`
--
ALTER TABLE `aspirante_documento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aspirante_documento_aspirante_id_documento_id_unique` (`aspirante_id`,`documento_id`),
  ADD KEY `aspirante_documento_documento_id_foreign` (`documento_id`);

--
-- Indices de la tabla `catequistas`
--
ALTER TABLE `catequistas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documentos_nombre_unique` (`nombre`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grupos_nombre_unique` (`nombre`),
  ADD KEY `grupos_catequista_id_foreign` (`catequista_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tutores`
--
ALTER TABLE `tutores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aspirantes`
--
ALTER TABLE `aspirantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `aspirante_documento`
--
ALTER TABLE `aspirante_documento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `catequistas`
--
ALTER TABLE `catequistas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tutores`
--
ALTER TABLE `tutores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aspirantes`
--
ALTER TABLE `aspirantes`
  ADD CONSTRAINT `aspirantes_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `aspirantes_registrado_por_foreign` FOREIGN KEY (`registrado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `aspirantes_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `tutores` (`id`);

--
-- Filtros para la tabla `aspirante_documento`
--
ALTER TABLE `aspirante_documento`
  ADD CONSTRAINT `aspirante_documento_aspirante_id_foreign` FOREIGN KEY (`aspirante_id`) REFERENCES `aspirantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aspirante_documento_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_catequista_id_foreign` FOREIGN KEY (`catequista_id`) REFERENCES `catequistas` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
