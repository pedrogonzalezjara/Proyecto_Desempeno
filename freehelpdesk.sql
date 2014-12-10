-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2014 a las 21:38:58
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `freehelpdesk`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_calls`
--

CREATE TABLE IF NOT EXISTS `site_calls` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `call_first_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_last_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_phone` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `call_department` int(11) NOT NULL DEFAULT '0',
  `call_request` int(11) NOT NULL DEFAULT '0',
  `call_device` int(11) NOT NULL DEFAULT '0',
  `call_details` text COLLATE latin1_general_ci NOT NULL,
  `call_date` int(11) NOT NULL DEFAULT '0',
  `call_date2` int(11) NOT NULL DEFAULT '0',
  `call_status` int(11) NOT NULL DEFAULT '0',
  `call_solution` text COLLATE latin1_general_ci NOT NULL,
  `call_user` int(11) NOT NULL DEFAULT '0',
  `call_staff` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`call_id`),
  KEY `call_department` (`call_department`),
  KEY `call_request` (`call_request`),
  KEY `call_device` (`call_device`),
  KEY `call_status` (`call_status`),
  KEY `call_user` (`call_user`),
  KEY `call_staff` (`call_staff`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `site_calls`
--

INSERT INTO `site_calls` (`call_id`, `call_first_name`, `call_last_name`, `call_phone`, `call_email`, `call_department`, `call_request`, `call_device`, `call_details`, `call_date`, `call_date2`, `call_status`, `call_solution`, `call_user`, `call_staff`) VALUES
(1, 'Peter', '', '7654321', 'pdro.gonzalez@gmail.com', 17, 4, 14, 'no me funciona el software', 1418149320, 0, 0, '', 2, 0),
(2, 'marco', '', '5667789', 'marco@mail.com', 16, 4, 9, 'tengo problema de seÃ±alll', 1418166000, 0, 0, 'no tiene problema ctm', 3, 2),
(3, 'marco', '', '', 'marco@mail.com', 2, 8, 13, 'qweqwe', 1418166000, 0, 0, '', 3, 2),
(4, 'marco', '', '45567998', 'marco@mail.com', 15, 8, 5, 'no me funciona el monitor', 1418239560, 0, 0, '', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_notes`
--

CREATE TABLE IF NOT EXISTS `site_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note_title` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `note_body` text COLLATE latin1_general_ci NOT NULL,
  `note_relation` int(11) NOT NULL DEFAULT '0',
  `note_type` int(1) NOT NULL DEFAULT '0',
  `note_post_date` int(11) NOT NULL DEFAULT '0',
  `note_post_ip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `note_post_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_id`),
  KEY `note_relation` (`note_relation`),
  KEY `note_type` (`note_type`),
  KEY `note_post_user` (`note_post_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `site_notes`
--

INSERT INTO `site_notes` (`note_id`, `note_title`, `note_body`, `note_relation`, `note_type`, `note_post_date`, `note_post_ip`, `note_post_user`) VALUES
(1, '', 'nota\r\n', 1, 1, 1418124543, '::1', 2),
(2, '', 'no pienso responder oe\r\n', 1, 1, 1418125257, '::1', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_options`
--

CREATE TABLE IF NOT EXISTS `site_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) DEFAULT NULL,
  `option_value` varchar(500) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `site_options`
--

INSERT INTO `site_options` (`id`, `option_name`, `option_value`, `timestamp`) VALUES
(1, 'encrypted_passwords', 'yes', '2014-03-16 18:43:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_types`
--

CREATE TABLE IF NOT EXISTS `site_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '0',
  `type_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `type_email` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `type_location` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `type_phone` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`type_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `site_types`
--

INSERT INTO `site_types` (`type_id`, `type`, `type_name`, `type_email`, `type_location`, `type_phone`) VALUES
(1, 1, 'Ventas', '', '', ''),
(2, 1, 'Soporte Moviles\r\n', '', '', ''),
(3, 2, 'Urgente', '', '', ''),
(4, 2, 'Pregunta', '', '', ''),
(5, 3, 'Facturas', '', '', ''),
(6, 3, 'Sistema Operativo\r\n', '', '', ''),
(8, 2, 'No Urgente', '', '', ''),
(9, 3, 'Internet', '', '', ''),
(10, 3, 'Red', '', '', ''),
(11, 3, 'Otro', '', '', ''),
(12, 3, 'Equipo', '', '', ''),
(13, 3, 'Datos Internet', '', '', ''),
(14, 3, 'Sistema', '', '', ''),
(15, 1, 'Soporte Banda Ancha', '', '', ''),
(16, 1, 'Servicio Al Cliente', '', '', ''),
(17, 1, 'Soporte General', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_upload`
--

CREATE TABLE IF NOT EXISTS `site_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `call_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_ext` varchar(4) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `call_id` (`call_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_users`
--

CREATE TABLE IF NOT EXISTS `site_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `user_password` varchar(225) COLLATE latin1_general_ci DEFAULT NULL,
  `user_name` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_address` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_city` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_state` char(3) COLLATE latin1_general_ci NOT NULL,
  `user_zip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user_country` char(3) COLLATE latin1_general_ci NOT NULL,
  `user_phone` varchar(39) COLLATE latin1_general_ci NOT NULL,
  `user_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_email2` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_im_aol` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_icq` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_msn` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_yahoo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_other` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_status` int(1) NOT NULL DEFAULT '0',
  `user_level` int(1) NOT NULL DEFAULT '0',
  `user_pending` int(11) NOT NULL DEFAULT '0',
  `user_date` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user_msg_send` int(1) NOT NULL DEFAULT '0',
  `user_msg_subject` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_protect_delete` int(1) DEFAULT '0',
  `user_protect_edit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_pending` (`user_pending`),
  KEY `user_level` (`user_level`),
  KEY `user_status` (`user_status`),
  KEY `user_protect_edit` (`user_protect_edit`),
  KEY `user_msg_send` (`user_msg_send`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=0 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `site_users`
--

INSERT INTO `site_users` (`user_id`, `user_login`, `user_password`, `user_name`, `user_address`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_email`, `user_email2`, `user_im_aol`, `user_im_icq`, `user_im_msn`, `user_im_yahoo`, `user_im_other`, `user_status`, `user_level`, `user_pending`, `user_date`, `last_login`, `last_ip`, `user_msg_send`, `user_msg_subject`, `user_protect_delete`, `user_protect_edit`) VALUES
(1, 'admin', '$2a$08$oId6n7GyLv8fFjPDT40G0ury7Qm7mdvncEM0i6JYtJ12FYm63M.dy', 'Administrador del Sitio', '', '', '', '', '', '', 'admin@example.com', 'someone@example.com', '', '', '', '', '', 0, 0, 0, 0, 1418241565, '::1', 1, 'New Message', 1, 0),
(2, 'neko', '$2a$08$xucyy9RxRun0gUEjNbNVn.W0AqZjka8YaaJWzo6re06XRcGbQjGtu', 'pedro', '', '', '', '', '', '7654321', 'pdro.gonzalez@gmail.com', '', '', '', '', '', 'uzamuhadu', 0, 0, 0, 0, 1418241393, '::1', 0, '', 1, 0),
(3, 'marco', '$2a$08$0eaUF4jCgvrs6BElqSmwiuBzGJ6xVg6qEMjdZeGcPp.QLZgKaG92C', 'marco', '', '', '', '', '', '', 'marco@mail.com', '', '', '', '', '', '', 1, 1, 0, 0, 1418241663, '::1', 0, '', 0, 0),
(4, 'nazzio', '$2a$08$TvGbPLu0uTZU8V4BXjsh4et1FxiXXPRc9UE7dbGjGb4bAc56AWMlK', 'nazzio', '', '', '', '', '', '', 'nazzio@mail.cl', '', '', '', '', '', '', 1, 1, 0, 0, 1418241080, '::1', 1, '', 0, 0),
(5, 'tali', '$2a$08$mI9hHRJQhboa0ydr9CZ0Ju/r44hxs7IgNeWCvSGfwzDYOE02naqjG', 'tali', '', '', '', '', '', '', 'tali@mail.cl', '', '', '', '', '', '', 1, 1, 0, 0, 0, '::1', 1, '', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
