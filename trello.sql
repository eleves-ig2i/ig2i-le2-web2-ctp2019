-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 22 Janvier 2019 à 18:46
-- Version du serveur :  5.7.24-0ubuntu0.18.04.1
-- Version de PHP :  7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `trello`
--

-- --------------------------------------------------------

--
-- Structure de la table `boards`
--

CREATE TABLE `boards` (
  `id` int(11) NOT NULL COMMENT 'clé primaire',
  `label` text NOT NULL COMMENT 'description du board',
  `ordre` int(11) NOT NULL COMMENT 'ordre d''affichage des boards'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `boards`
--

INSERT INTO `boards` (`id`, `label`, `ordre`) VALUES
(1, 'Board modifie', 1);

-- --------------------------------------------------------

--
-- Structure de la table `colonnes`
--

CREATE TABLE `colonnes` (
  `id` int(11) NOT NULL,
  `label` text CHARACTER SET latin1 NOT NULL,
  `ordre` int(11) NOT NULL,
  `idBoard` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marqueurs`
--

CREATE TABLE `marqueurs` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `valeur` varchar(200) NOT NULL,
  `idPostit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `postits`
--

CREATE TABLE `postits` (
  `id` int(11) NOT NULL,
  `numColonne` int(11) NOT NULL,
  `idBoard` int(11) NOT NULL,
  `label` text NOT NULL,
  `avancement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `passe` varchar(50) NOT NULL,
  `initiales` varchar(3) NOT NULL,
  `fullname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `passe`, `initiales`, `fullname`) VALUES
(1, 'toto', 'toto', 'TB', 'Thomas Bou');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `colonnes`
--
ALTER TABLE `colonnes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `marqueurs`
--
ALTER TABLE `marqueurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `postits`
--
ALTER TABLE `postits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'clé primaire', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `colonnes`
--
ALTER TABLE `colonnes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `marqueurs`
--
ALTER TABLE `marqueurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `postits`
--
ALTER TABLE `postits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
