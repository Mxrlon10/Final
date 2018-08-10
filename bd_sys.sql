-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 08-01-2018 a las 15:57:21
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bdconsultorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_tmp`
--

CREATE TABLE IF NOT EXISTS `caja_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `cant` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajero`
--

CREATE TABLE IF NOT EXISTS `cajero` (
  `usu` varchar(255) NOT NULL,
  `consultorio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cajero`
--

INSERT INTO `cajero` (`usu`, `consultorio`) VALUES
('112233444', '1'),
('017835432', '1'),
('026352271', '1'),
('admin', '1'),
('auxiliar', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medicas`
--

CREATE TABLE IF NOT EXISTS `citas_medicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(255) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` varchar(255) NOT NULL,
  `fechai` date NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `horario` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `consulta` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `citas_medicas`
--

INSERT INTO `citas_medicas` (`id`, `id_paciente`, `id_medico`, `consultorio`, `fechai`, `tipo`, `fecha`, `hora`, `horario`, `status`, `consulta`) VALUES
(2, '3', '112233444', '1', '2018-01-11', 'GEN', '2018-01-05', '16:05:35', '14:30:00', 'PENDIENTE', 'PENDIENTE'),
(3, '2', '112233444', '1', '2018-01-05', 'GEN', '2018-01-05', '04:16:16', '16:16:16', 'PENDIENTE', 'PENDIENTE'),
(4, '4', '112233444', '1', '2018-01-06', 'GEN', '2018-01-05', '16:26:37', '01:30:00', 'PENDIENTE', 'PENDIENTE'),
(5, '6', 'admin', '1', '2018-01-11', 'GEN', '2018-01-06', '11:04:03', '01:25:00', 'PENDIENTE', 'PENDIENTE'),
(6, '3', 'auxiliar', '1', '2018-01-10', 'GEN', '2018-01-06', '11:06:09', '12:40:00', 'PENDIENTE', 'PENDIENTE'),
(7, '3', 'auxiliar', '1', '2018-01-06', 'GEN', '2018-01-06', '11:06:48', '11:06:48', 'PENDIENTE', 'PENDIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_medicas`
--

CREATE TABLE IF NOT EXISTS `consultas_medicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(15) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `sintomas` text NOT NULL,
  `diagnostico` text NOT NULL,
  `tratamiento` text NOT NULL,
  `observaciones` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `tipo` varchar(12) NOT NULL,
  `consul` varchar(50) NOT NULL,
  `ant_per` text NOT NULL,
  `ant_fm` text NOT NULL,
  `peso` varchar(25) NOT NULL,
  `talla` varchar(25) NOT NULL,
  `ta` varchar(25) NOT NULL,
  `sc` varchar(25) NOT NULL,
  `pc` varchar(25) NOT NULL,
  `exlab` text NOT NULL,
  `vista` varchar(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorios`
--

CREATE TABLE IF NOT EXISTS `consultorios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `encargado` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `consultorios`
--

INSERT INTO `consultorios` (`id`, `nombre`, `direccion`, `telefono`, `encargado`, `estado`) VALUES
(1, 'CENTRO DE SALUD DE PANAJACHEL', 'PANAJACHEL, SOLOL&Aacute;', '(502)776-2034', 'DR. MARLON ELFRID MONROY', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE IF NOT EXISTS `detalle` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `factura` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `importe` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `consultorio` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(255) NOT NULL,
  `empresa` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pais` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `web` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `moneda` varchar(22) COLLATE utf8_spanish_ci NOT NULL,
  `anno` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `empresa`, `nit`, `direccion`, `pais`, `ciudad`, `tel`, `fax`, `web`, `correo`, `fecha`, `moneda`, `anno`) VALUES
(1, 'MINISTERIO DE SALUD P&Uacute;BLICA Y ASISTENCIA SOCIAL', '123111-4565-455', 'PANAJACHEL, SOLOL&Aacute;', 'GUATEMALA', 'PANAJACHEL', '7190-9187', '2637-0374', 'www.centrodesaludpanajachel.com', 'cappanajachel@yahoo.com', '2018-01-04', 'Q', '2014');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `body` text COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `class` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'event-important',
  `start` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `end` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `factura` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(255) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `usu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE IF NOT EXISTS `medicamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta` varchar(11) NOT NULL,
  `paciente` varchar(11) NOT NULL,
  `med1` text NOT NULL,
  `indi1` text NOT NULL,
  `med2` text NOT NULL,
  `indi2` text NOT NULL,
  `med3` text NOT NULL,
  `indi3` text NOT NULL,
  `med4` text NOT NULL,
  `indi4` text NOT NULL,
  `med5` text NOT NULL,
  `indi5` text NOT NULL,
  `med6` text NOT NULL,
  `indi6` text NOT NULL,
  `med7` text NOT NULL,
  `indi7` text NOT NULL,
  `med8` text NOT NULL,
  `indi8` text NOT NULL,
  `med9` text NOT NULL,
  `indi9` text NOT NULL,
  `med10` text NOT NULL,
  `indi10` text NOT NULL,
  `med11` text NOT NULL,
  `indi11` text NOT NULL,
  `med12` text NOT NULL,
  `indi12` text NOT NULL,
  `med13` text NOT NULL,
  `indi13` text NOT NULL,
  `med14` text NOT NULL,
  `indi14` text NOT NULL,
  `med15` text NOT NULL,
  `indi15` text NOT NULL,
  `fecha` date NOT NULL,
  `consultorio` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `medicamentos`
--

INSERT INTO `medicamentos` (`id`, `consulta`, `paciente`, `med1`, `indi1`, `med2`, `indi2`, `med3`, `indi3`, `med4`, `indi4`, `med5`, `indi5`, `med6`, `indi6`, `med7`, `indi7`, `med8`, `indi8`, `med9`, `indi9`, `med10`, `indi10`, `med11`, `indi11`, `med12`, `indi12`, `med13`, `indi13`, `med14`, `indi14`, `med15`, `indi15`, `fecha`, `consultorio`) VALUES
(1, '1', '1', 'Acetaminofen', '1 tableta cada 8 horas', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2018-01-04', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE IF NOT EXISTS `medicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(25) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL,
  `municipio` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `estado` varchar(250) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `especialidad` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `documento`, `nombre`, `direccion`, `departamento`, `municipio`, `telefono`, `sexo`, `email`, `estado`, `consultorio`, `especialidad`) VALUES
(3, '', 'Mauricio Pineda Cruz', 'col. las buenas nuevas casa #23', '', '', '4329-4792', 'm', 'prueba@hotmail.com', 's', 1, 'prueba de datos'),
(4, '', 'Carlos Guevara Ponce', 'col. las pruebas de datos', '', '', '7327-9173', 'm', 'carlos@gamil.com', 's', 1, 'General');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE IF NOT EXISTS `municipios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `departamento` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(25) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `nomp` varchar(255) NOT NULL,
  `nomm` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `edad` date NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `refpor` varchar(255) NOT NULL,
  `estado` varchar(250) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `control` varchar(25) NOT NULL,
  `feccita` date NOT NULL,
  `seguro` varchar(25) NOT NULL,
  `alergia` text NOT NULL,
  `enf_cro` text NOT NULL,
  `cuadro_vac` text NOT NULL,
  `ant_quir` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `documento`, `nombre`, `direccion`, `nomp`, `nomm`, `telefono`, `edad`, `sexo`, `refpor`, `estado`, `consultorio`, `control`, `feccita`, `seguro`, `alergia`, `enf_cro`, `cuadro_vac`, `ant_quir`) VALUES
(1, '', 'Marlon Felipe de Paz', 'San Andr&eacute;s Semetabaj, Solol&aacute;', 'Oscar Felipe Vasquez', 'Aida Victoria De Paz', '5414-5111', '1995-09-24', 'm', 'Dr. Molina', 'n', 1, '', '2018-01-04', 'ninguno', '', '', '', ''),
(2, '', 'Leonardo Francisco L&oacute;pez Casi&aacute;', 'Aldea Argueta, Solol&aacute;', 'Francisco L&oacute;pez', 'Mar&iacute;a Casi&aacute;', '2334-4333', '1995-02-14', 'm', 'Dr. Ismael D&iacute;az', 's', 1, '', '2018-01-05', 'sg', '', '', '', ''),
(3, '', 'Gaspar Ismael Diaz Domingo', 'Tzisbaj Jacaltenango, Huehuetenango', 'Victor Diaz', 'Marta Domingo', '8427-3409', '1991-06-21', 'm', '', 's', 1, '', '2018-01-05', 'paligmed', '', '', '', ''),
(4, '', 'Juan Froil&aacute;n D&iacute;az Jacinto', 'Tzisbaj Jacaltenango, Huehuetenango', 'Gaspar D&iacute;az', 'Mar&iacute;a Jacinto', '2222-2222', '1997-06-12', 'm', 'Manuela D&iacute;az', 's', 1, '', '2018-01-03', 'ninguno', '', '', '', ''),
(5, '', 'Julio Cesar Chavajay Garc&iacute;a', 'La Uni&oacute;n Argueta, Solol&aacute;', 'Julio Chavajay', 'Rosa Garc&iacute;a', '2222-2223', '1990-06-15', 'f', 'Dra. Lizzy Cutz', 's', 1, '', '2018-01-03', 'ninguno', '', '', '', ''),
(6, '', 'Victor Rafael Chiroy Yaxon', 'Aldea Basconcelos, Caseria Choacruz, Solola', 'Mario Chiroy', 'Marta Chumil', '9208-3901', '1991-11-07', 'm', 'Dr, Marlon de Cai', 's', 1, '', '2018-01-06', 'ninguno', '', '', '', ''),
(7, '', 'Antonio Escobar', 'Guatemala, Guatemala', 'Juan Escobar', 'Marta Juarez', '8732-8732', '1989-03-02', 'm', 'Dr, Juan Lopez', 's', 1, '', '2018-01-06', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pediatria`
--

CREATE TABLE IF NOT EXISTS `pediatria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(12) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `edad` date NOT NULL,
  `lugar` text NOT NULL,
  `padre` varchar(255) NOT NULL,
  `madre` varchar(255) NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `obstetra` varchar(255) NOT NULL,
  `referido` varchar(255) NOT NULL,
  `estado` varchar(250) NOT NULL,
  `consultorio` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pediatria_alim`
--

CREATE TABLE IF NOT EXISTS `pediatria_alim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(10) NOT NULL,
  `pecho` varchar(255) NOT NULL,
  `formula` varchar(255) NOT NULL,
  `vitaminas` varchar(255) NOT NULL,
  `suaves` varchar(255) NOT NULL,
  `dieta` varchar(255) NOT NULL,
  `habitos` varchar(255) NOT NULL,
  `vomitos` varchar(255) NOT NULL,
  `colicos` varchar(255) NOT NULL,
  `consultorio` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pediatria_drllo`
--

CREATE TABLE IF NOT EXISTS `pediatria_drllo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(10) NOT NULL,
  `termino` varchar(255) NOT NULL,
  `parto` varchar(255) NOT NULL,
  `rh` varchar(255) NOT NULL,
  `con_nac` varchar(255) NOT NULL,
  `peso_nac` varchar(255) NOT NULL,
  `talla_nac` varchar(25) NOT NULL,
  `con_semana` varchar(255) NOT NULL,
  `alimentacion` varchar(255) NOT NULL,
  `cianosis` varchar(255) NOT NULL,
  `sento` varchar(100) NOT NULL,
  `paro` varchar(100) NOT NULL,
  `convulsiones` varchar(255) NOT NULL,
  `camino` varchar(255) NOT NULL,
  `palabras` varchar(255) NOT NULL,
  `ictericia` varchar(255) NOT NULL,
  `diente` varchar(100) NOT NULL,
  `fraces` varchar(100) NOT NULL,
  `apga` varchar(100) NOT NULL,
  `vesical` varchar(100) NOT NULL,
  `instestinos` varchar(255) NOT NULL,
  `consultorio` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pediatria_enf`
--

CREATE TABLE IF NOT EXISTS `pediatria_enf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(10) NOT NULL,
  `tosferina` varchar(10) NOT NULL,
  `apendicitis` varchar(10) NOT NULL,
  `sarampion` varchar(10) NOT NULL,
  `reumatica` varchar(10) NOT NULL,
  `rubeola` varchar(10) NOT NULL,
  `otitis` varchar(10) NOT NULL,
  `paperas` varchar(10) NOT NULL,
  `irs` varchar(10) NOT NULL,
  `varicela` varchar(10) NOT NULL,
  `amigdalitis` varchar(10) NOT NULL,
  `escarlatina` varchar(10) NOT NULL,
  `convulsionesx` varchar(10) NOT NULL,
  `difteria` varchar(10) NOT NULL,
  `constipacion` varchar(10) NOT NULL,
  `operaciones` varchar(10) NOT NULL,
  `diarrea` varchar(10) NOT NULL,
  `amebiasis` varchar(10) NOT NULL,
  `otrosenf` varchar(10) NOT NULL,
  `consultorio` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pediatria_hf`
--

CREATE TABLE IF NOT EXISTS `pediatria_hf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(10) NOT NULL,
  `padrehf` varchar(255) NOT NULL,
  `edadpdre` varchar(25) NOT NULL,
  `madrehf` varchar(255) NOT NULL,
  `edadmdre` varchar(25) NOT NULL,
  `hermanohf` varchar(255) NOT NULL,
  `edadhno` varchar(25) NOT NULL,
  `hermanahf` varchar(255) NOT NULL,
  `edadhna` varchar(25) NOT NULL,
  `tuberculosis` varchar(10) NOT NULL,
  `diabetes` varchar(10) NOT NULL,
  `alergia` varchar(10) NOT NULL,
  `convulsioneshf` varchar(10) NOT NULL,
  `congenicas` varchar(10) NOT NULL,
  `otroshf` text NOT NULL,
  `consultorio` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permiso` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `permiso`, `usu`, `estado`) VALUES
(11, '1', '112233444', 's'),
(12, '2', '112233444', 's'),
(13, '3', '112233444', 's'),
(14, '4', '112233444', 's'),
(15, '5', '112233444', 's'),
(106, '1', '1234567', 's'),
(107, '2', '1234567', 's'),
(108, '3', '1234567', 'n'),
(109, '4', '1234567', 'n'),
(110, '5', '1234567', 's'),
(111, '1', '123', 's'),
(112, '2', '123', 's'),
(113, '3', '123', 's'),
(114, '4', '123', 's'),
(115, '5', '123', 's'),
(116, '1', '1234', 'n'),
(117, '2', '1234', 's'),
(118, '3', '1234', 'n'),
(119, '4', '1234', 'n'),
(120, '5', '1234', 'n'),
(121, '1', '017835432', 's'),
(122, '2', '017835432', 's'),
(123, '3', '017835432', 's'),
(124, '4', '017835432', 's'),
(125, '5', '017835432', 's'),
(126, '1', '026352271', 's'),
(127, '2', '026352271', 's'),
(128, '3', '026352271', 'n'),
(129, '4', '026352271', 'n'),
(130, '5', '026352271', 's'),
(131, '1', 'admin', 's'),
(132, '2', 'admin', 's'),
(133, '3', 'admin', 's'),
(134, '4', 'admin', 's'),
(135, '5', 'admin', 's'),
(136, '1', 'auxiliar', 's'),
(137, '2', 'auxiliar', 's'),
(138, '3', 'auxiliar', 's'),
(139, '4', 'auxiliar', 'n'),
(140, '5', 'auxiliar', 'n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_tmp`
--

CREATE TABLE IF NOT EXISTS `permisos_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `permisos_tmp`
--

INSERT INTO `permisos_tmp` (`id`, `nombre`) VALUES
(1, 'Crear Pacientes'),
(2, 'Crear Citas'),
(3, 'Crear consultas'),
(4, 'Administracion'),
(5, 'Caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `doc`, `nom`, `cargo`, `estado`) VALUES
(1, '112233444', 'Administrador', 'admin', 's'),
(15, '017835432', 'Dra. Jackeline Sosa', '2', 's'),
(16, '026352271', 'Maria Rodriguez', '1', 's'),
(17, 'admin', 'administrador2', 'admin', 's'),
(18, 'auxiliar', 'Ramiro Estacuy', '3', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prenatal`
--

CREATE TABLE IF NOT EXISTS `prenatal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `opciones` varchar(25) NOT NULL,
  `familiares` text NOT NULL,
  `personales` text NOT NULL,
  `ultimo` date NOT NULL,
  `parto` varchar(255) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `consultorio` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prenatal_emb`
--

CREATE TABLE IF NOT EXISTS `prenatal_emb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `pesopre` varchar(255) NOT NULL,
  `tallapre` varchar(255) NOT NULL,
  `fur` varchar(255) NOT NULL,
  `app` varchar(255) NOT NULL,
  `a` varchar(255) NOT NULL,
  `hemoglobina` varchar(255) NOT NULL,
  `rh` varchar(255) NOT NULL,
  `toxoplasmosis` varchar(255) NOT NULL,
  `glucosa` varchar(255) NOT NULL,
  `igm` varchar(250) NOT NULL,
  `igg` varchar(255) NOT NULL,
  `vdrl` varchar(255) NOT NULL,
  `ego` varchar(255) NOT NULL,
  `hiv` varchar(255) NOT NULL,
  `egh` varchar(255) NOT NULL,
  `citologoa` varchar(255) NOT NULL,
  `otrospre` varchar(255) NOT NULL,
  `vacinacion` varchar(255) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `consultorio` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen`
--

CREATE TABLE IF NOT EXISTS `resumen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente` varchar(255) NOT NULL,
  `concepto` varchar(250) NOT NULL,
  `factura` varchar(255) NOT NULL,
  `clase` varchar(250) NOT NULL,
  `valor` varchar(250) NOT NULL,
  `tipo` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `usu` varchar(250) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `estado` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguros`
--

CREATE TABLE IF NOT EXISTS `seguros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(11) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas`
--

CREATE TABLE IF NOT EXISTS `tarifas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `config` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_permisos`
--

CREATE TABLE IF NOT EXISTS `tipo_permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permiso` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `tipo_permisos`
--

INSERT INTO `tipo_permisos` (`id`, `permiso`, `tipo`, `estado`) VALUES
(1, '1', '1', 'n'),
(2, '2', '1', 'n'),
(3, '3', '1', 'n'),
(4, '4', '1', 'n'),
(5, '5', '1', 'n'),
(6, '1', '2', 'n'),
(7, '2', '2', 'n'),
(8, '3', '2', 'n'),
(9, '4', '2', 'n'),
(10, '5', '2', 'n'),
(11, '1', '3', 'n'),
(12, '2', '3', 'n'),
(13, '3', '3', 'n'),
(14, '4', '3', 'n'),
(15, '5', '3', 'n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `nombre`) VALUES
(1, 'SECRETARIA'),
(2, 'DOCTOR'),
(3, 'AUXILIAR DE ENFERMERIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ultra_embarazo`
--

CREATE TABLE IF NOT EXISTS `ultra_embarazo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(15) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `solicitante` varchar(255) NOT NULL,
  `fur` varchar(255) NOT NULL,
  `saco` varchar(255) NOT NULL,
  `lcr` varchar(100) NOT NULL,
  `dbp` varchar(100) NOT NULL,
  `lf` varchar(100) NOT NULL,
  `lh` varchar(100) NOT NULL,
  `lcf` varchar(100) NOT NULL,
  `liquido` varchar(100) NOT NULL,
  `localizacion` varchar(255) NOT NULL,
  `grado` varchar(100) NOT NULL,
  `observaciones` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ultra_ginecologica`
--

CREATE TABLE IF NOT EXISTS `ultra_ginecologica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(15) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `solicitante` varchar(255) NOT NULL,
  `opciones` text NOT NULL,
  `utero` text NOT NULL,
  `endometrio` text NOT NULL,
  `anexo` text NOT NULL,
  `saco` text NOT NULL,
  `observaciones` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ultra_mamas`
--

CREATE TABLE IF NOT EXISTS `ultra_mamas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(15) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `informe` text NOT NULL,
  `dx` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ultra_prostata`
--

CREATE TABLE IF NOT EXISTS `ultra_prostata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` varchar(15) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `vejiga` text NOT NULL,
  `prostata` text NOT NULL,
  `conclusion` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc` varchar(255) NOT NULL,
  `con` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cargo` varchar(20) NOT NULL,
  `nota` varchar(255) NOT NULL,
  `salario` double NOT NULL,
  `estado` varchar(20) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `consultorio` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `doc`, `con`, `nombre`, `cargo`, `nota`, `salario`, `estado`, `tipo`, `consultorio`) VALUES
(16, '017835432', 'admin', 'Administrador', 'Administrador', 'Ninguna', 0, 's', 'Admin', '1'),
(38, 'memonroy', 'admin', 'Dr. Marlon Elfrid Monroy', 'DOCTOR', 'Ninguna', 0, 's', '2', '1'),
(39, 'secretaria', 'admin', 'Maria Rodriguez', 'SECRETARIA', 'Ninguna', 0, 's', '1', '1'),
(40, 'admin', 'admin2', 'administrador2', 'Administrador', 'Ninguna', 0, 's', 'Admin', '1'),
(41, 'auxiliar', 'auxiliar', 'Ramiro Estacuy', 'AUXILIAR DE ENFERMER', 'Ninguna', 0, 's', '3', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
