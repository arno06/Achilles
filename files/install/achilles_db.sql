SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `achilles_db`
--
CREATE DATABASE IF NOT EXISTS `achilles_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `achilles_db`;

-- --------------------------------------------------------

--
-- Structure de la table `main_category`
--

CREATE TABLE IF NOT EXISTS `main_category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permalink_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `main_comment`
--

CREATE TABLE IF NOT EXISTS `main_comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `text_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `added_date_comment` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_comment` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `main_post`
--

CREATE TABLE IF NOT EXISTS `main_post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `title_post` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text_post` text COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `url_post` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_upload` int(11) NOT NULL,
  `added_date_post` datetime NOT NULL,
  `status_post` int(1) NOT NULL,
  `permalink_post` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `main_user`
--

CREATE TABLE IF NOT EXISTS `main_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login_user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_user` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `permissions_user` int(11) NOT NULL,
  `pseudo_user` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `bio_user` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `main_user`
--

INSERT INTO `main_user` (`id_user`, `login_user`, `password_user`, `permissions_user`, `pseudo_user`, `bio_user`) VALUES
(1, 'root', '7de630b67016a8b78b28c93f1e24c8f6', 7, 'root', 'WOot');

-- --------------------------------------------------------

--
-- Structure de la table `post_category`
--

CREATE TABLE IF NOT EXISTS `post_category` (
  `id_post` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id_post`,`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
