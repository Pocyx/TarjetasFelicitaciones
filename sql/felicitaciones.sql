/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  PocyxDesigner
 * Created: 21-nov-2017
 */



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: felicitaciones
--
CREATE DATABASE IF NOT EXISTS `felicitaciones` DEFAULT CHARACTER SET utf8 ;
USE `felicitaciones`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE IF NOT EXISTS `tarjeta` (
  `tarjeta_id` int NOT NULL AUTO_INCREMENT,
  `fecha` varchar(50) ,
  `fecha_envio` varchar(50),
  `autor` varchar(100) ,
  `titulo` varchar(200) NOT NULL,
  `texto` varchar(800) NOT NULL,
  `publicado` varchar(50) ,
  `destinatario` varchar(200) NOT NULL,
  `imgTarjeta` VARCHAR(100),
  `votos` int,
  PRIMARY KEY (`tarjeta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
--
-- Estructura de tabla para la tabla `respuesta`
--
CREATE TABLE IF NOT EXISTS `respuesta` ( 
`respuesta_id` int NOT NULL AUTO_INCREMENT, 
`fecha` varchar(50) ,
`autor` varchar(100) ,
`titulo` varchar(200) NOT NULL,
`texto` varchar(800) NOT NULL, 
`tarjeta_id` int NOT NULL, 
PRIMARY KEY (`respuesta_id`), 
FOREIGN KEY (`tarjeta_id`) REFERENCES tarjeta(`tarjeta_id`) 
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
--
-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `datosTotal` int,
  `datosConsumidos` int,
  `datosRestantes` int,
  `cargo` int NOT NULL,
  `imgPerfil` VARCHAR(100),
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
