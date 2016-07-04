/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.42-37.1-log : Database - adblicka_omgeventos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`adblicka_omgeventos` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `adblicka_omgeventos`;

/*Table structure for table `acreditados` */

DROP TABLE IF EXISTS `acreditados`;

CREATE TABLE `acreditados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `empresa` varchar(255) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `dni` int(11) DEFAULT NULL,
  `edad` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `conocio` varchar(255) DEFAULT NULL,
  `tipo_usuario` int(2) DEFAULT '0',
  `newsletter` int(1) NOT NULL,
  `medio_pago` varchar(255) DEFAULT NULL,
  `monto` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `discount_code` varchar(50) DEFAULT NULL,
  `lunch` int(2) DEFAULT NULL,
  `full_cart` text,
  `barcode` varchar(255) DEFAULT NULL,
  `fbId` int(11) DEFAULT NULL,
  `donante_mensual` int(2) DEFAULT '0',
  `no_asistente` int(2) DEFAULT '0',
  `reminder` int(1) DEFAULT '0',
  `salt` varchar(255) DEFAULT NULL,
  `acreditado` int(2) DEFAULT '0',
  `invitacion` int(2) DEFAULT '0',
  `status` int(2) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(3) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`,`edad`)
) ENGINE=MyISAM AUTO_INCREMENT=761 DEFAULT CHARSET=latin1;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `loggin_attempts` int(11) DEFAULT NULL,
  `principal` int(1) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(2) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `asistentes` */

DROP TABLE IF EXISTS `asistentes`;

CREATE TABLE `asistentes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `loggin_attempts` int(11) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(2) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `atributos` */

DROP TABLE IF EXISTS `atributos`;

CREATE TABLE `atributos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(55) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lineage` text,
  `deep` int(3) NOT NULL,
  `status` int(2) DEFAULT NULL,
  `descripcion` text,
  `json` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30005 DEFAULT CHARSET=utf8;

/*Table structure for table `categoriaSponsors` */

DROP TABLE IF EXISTS `categoriaSponsors`;

CREATE TABLE `categoriaSponsors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `extras` text,
  `orden` int(2) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(2) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(2) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cupons` */

DROP TABLE IF EXISTS `cupons`;

CREATE TABLE `cupons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `available` int(11) DEFAULT '0',
  `value` int(11) DEFAULT NULL,
  `percent` int(3) DEFAULT NULL,
  `status` int(3) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(3) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(3) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

/*Table structure for table `env` */

DROP TABLE IF EXISTS `env`;

CREATE TABLE `env` (
  `id` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` text COLLATE utf8_spanish_ci,
  `status` int(2) DEFAULT NULL,
  `system` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Table structure for table `eventos` */

DROP TABLE IF EXISTS `eventos`;

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `bajada` varchar(255) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `costo` int(5) DEFAULT NULL,
  `skin_id` int(2) DEFAULT NULL,
  `newsletter` int(1) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `json_socials` text,
  `reminder_one` date DEFAULT NULL,
  `reminder_two` date DEFAULT NULL,
  `payments_enabled` int(5) DEFAULT NULL,
  `show_register` int(5) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(2) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(2) DEFAULT NULL,
  `cupons_enabled` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `eventos_mediosPago` */

DROP TABLE IF EXISTS `eventos_mediosPago`;

CREATE TABLE `eventos_mediosPago` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `medio_pago_id` int(11) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(2) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(2) DEFAULT NULL,
  `status` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `formularioRegistro` */

DROP TABLE IF EXISTS `formularioRegistro`;

CREATE TABLE `formularioRegistro` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `required` int(2) DEFAULT NULL,
  `extras` text,
  `fa` datetime DEFAULT NULL,
  `ua` int(5) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(5) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `formularios` */

DROP TABLE IF EXISTS `formularios`;

CREATE TABLE `formularios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_form` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `json` text,
  `status` int(11) DEFAULT '0',
  `fa` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Table structure for table `gateways` */

DROP TABLE IF EXISTS `gateways`;

CREATE TABLE `gateways` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `extras` text,
  `fa` datetime DEFAULT NULL,
  `ua` int(2) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(2) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `helps` */

DROP TABLE IF EXISTS `helps`;

CREATE TABLE `helps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `json` text,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `lugares` */

DROP TABLE IF EXISTS `lugares`;

CREATE TABLE `lugares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `json_direccion` text,
  `fum` datetime DEFAULT NULL,
  `uum` int(5) DEFAULT NULL,
  `ua` int(5) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `oradores` */

DROP TABLE IF EXISTS `oradores`;

CREATE TABLE `oradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `brief` text,
  `json_socials` text,
  `cargo` varchar(100) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(3) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(3) DEFAULT NULL,
  `order` int(10) unsigned DEFAULT NULL,
  `speaker_group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Table structure for table `pagos` */

DROP TABLE IF EXISTS `pagos`;

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acreditado_id` int(11) NOT NULL,
  `collection_id` varchar(255) NOT NULL,
  `collection_status` varchar(255) NOT NULL,
  `preference_id` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `transaction_amount` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `currency_id` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `pago_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=761 DEFAULT CHARSET=latin1;

/*Table structure for table `schedule` */

DROP TABLE IF EXISTS `schedule`;

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `orador_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `brief` text,
  `hora` time DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(3) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Table structure for table `speaker_groups` */

DROP TABLE IF EXISTS `speaker_groups`;

CREATE TABLE `speaker_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ua` int(5) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `uum` int(5) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `sponsors` */

DROP TABLE IF EXISTS `sponsors`;

CREATE TABLE `sponsors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `categoria_id` int(5) DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `ua` int(3) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

/*Table structure for table `tickets` */

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) NOT NULL,
  `nombre` varchar(55) NOT NULL,
  `bajada` varchar(55) DEFAULT NULL,
  `descripcion` text,
  `precio_regular` int(11) NOT NULL,
  `status` int(3) DEFAULT NULL,
  `fa` datetime DEFAULT NULL,
  `precio_oferta` int(11) DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `ua` int(3) DEFAULT NULL,
  `fum` datetime DEFAULT NULL,
  `uum` int(3) DEFAULT NULL,
  `agotadas` int(3) DEFAULT NULL,
  `background` varchar(6) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `tipo_clientes` */

DROP TABLE IF EXISTS `tipo_clientes`;

CREATE TABLE `tipo_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
