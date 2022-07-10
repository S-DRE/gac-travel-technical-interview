-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2022 a las 03:02:15
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gac_travel_technical_interview`
--
CREATE DATABASE IF NOT EXISTS `gac_travel_technical_interview` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `gac_travel_technical_interview`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(97, 'electronics', '2022-07-10 02:57:41'),
(98, 'jewelery', '2022-07-10 02:57:41'),
(99, 'men\'s clothing', '2022-07-10 02:57:41'),
(100, 'women\'s clothing', '2022-07-10 02:57:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `created_at`, `stock`) VALUES
(223, 'Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops', 99, '2022-07-10 02:57:43', 61),
(224, 'Mens Casual Premium Slim Fit T-Shirts ', 99, '2022-07-10 02:57:43', 67),
(225, 'Mens Cotton Jacket', 99, '2022-07-10 02:57:44', 85),
(226, 'Mens Casual Slim Fit', 99, '2022-07-10 02:57:44', 54),
(227, 'John Hardy Women\'s Legends Naga Gold & Silver Dragon Station Cha', 98, '2022-07-10 02:57:45', 37),
(228, 'Solid Gold Petite Micropave ', 98, '2022-07-10 02:57:45', 43),
(229, 'White Gold Plated Princess', 98, '2022-07-10 02:57:46', 42),
(230, 'Pierced Owl Rose Gold Plated Stainless Steel Double', 98, '2022-07-10 02:57:46', 45),
(231, 'WD 2TB Elements Portable External Hard Drive - USB 3.0 ', 97, '2022-07-10 02:57:47', 50),
(232, 'SanDisk SSD PLUS 1TB Internal SSD - SATA III 6 Gb/s', 97, '2022-07-10 02:57:48', 71),
(233, 'Silicon Power 256GB SSD 3D NAND A55 SLC Cache Performance Boost ', 97, '2022-07-10 02:57:48', 68),
(234, 'WD 4TB Gaming Drive Works with Playstation 4 Portable External H', 97, '2022-07-10 02:57:49', 10),
(235, 'Acer SB220Q bi 21.5 inches Full HD (1920 x 1080) IPS Ultra-Thin', 97, '2022-07-10 02:57:49', 37),
(236, 'Samsung 49-Inch CHG90 144Hz Curved Gaming Monitor (LC49HG90DMNXZ', 97, '2022-07-10 02:57:50', 69),
(237, 'BIYLACLESEN Women\'s 3-in-1 Snowboard Jacket Winter Coats', 100, '2022-07-10 02:57:50', 43),
(238, 'Lock and Love Women\'s Removable Hooded Faux Leather Moto Biker J', 100, '2022-07-10 02:57:51', 36),
(239, 'Rain Jacket Women Windbreaker Striped Climbing Raincoats', 100, '2022-07-10 02:57:51', 86),
(240, 'MBJ Women\'s Solid Short Sleeve Boat Neck V ', 100, '2022-07-10 02:57:52', 22),
(241, 'Opna Women\'s Short Sleeve Moisture', 100, '2022-07-10 02:57:52', 70),
(242, 'DANVOUY Womens T Shirt Casual Cotton Short', 100, '2022-07-10 02:57:53', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_historic`
--

CREATE TABLE `stock_historic` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `roles`, `active`, `created_at`) VALUES
(5, 'johnd', '$2y$13$3vWkvDkAAOR1KdKeSLkJmOC4nkeBBqsrMTXcakZmddQHIzcxDnkdC', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:57:54'),
(6, 'mor_2314', '$2y$13$gXlQQReI7EqHx0V2K.fWGuHik3IXYuEYt/i.PM7CKd6WW/p0qRrNi', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:57:55'),
(7, 'kevinryan', '$2y$13$Pek53JzonPW7e1nm//vmFeyWxzfiE35QBNWG1cWLk5u8WXiThQ7FC', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:57:56'),
(8, 'donero', '$2y$13$v9IWtPfvRLlm6LkpZoR0FuuW7.rHtlQEwe2tLNw7tc4tKQYzXf2eO', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:57:57'),
(9, 'derek', '$2y$13$/QZse0zq/0yUsOMvdy3QROBOLrlvHtxJKIZ2qA8y3uB.QHdFGmelu', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:57:58'),
(10, 'david_r', '$2y$13$rRcRKeL/WT6zW2SXbsVKReFoq6oqDwTIktsSAeQMXimd4YwnXzzt.', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:57:59'),
(11, 'snyder', '$2y$13$SGMwsOSi/FrqG3mpoh4mGuxpYezernlr6eXEixgU9WeoNKDvYduY2', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:58:00'),
(12, 'hopkins', '$2y$13$aoJ0j/ryNVB/8Ua6gXIut.SBmHoPqCLorDt3lsYA58HDRC3.M..2q', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:58:01'),
(13, 'kate_h', '$2y$13$znKiVwwYW7.9kcpRobUnwOeqL1eWJqOfciHk86XcbFsJmAmQ/gur6', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:58:02'),
(14, 'jimmie_k', '$2y$13$rEIH8fBPZxvjkog8BtVeZefKFSKoPI9ofh7MjNdx0NHaqI0a/1U/G', '[\"ROLE_ADMIN\"]', 1, '2022-07-10 02:58:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category_id` (`category_id`);

--
-- Indices de la tabla `stock_historic`
--
ALTER TABLE `stock_historic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stock_historic_user_id` (`user_id`),
  ADD KEY `fk_stock_historic_product_id` (`product_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT de la tabla `stock_historic`
--
ALTER TABLE `stock_historic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `stock_historic`
--
ALTER TABLE `stock_historic`
  ADD CONSTRAINT `fk_stock_historic_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock_historic_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
