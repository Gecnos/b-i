-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : dim. 28 sep. 2025 à 00:33
-- Version du serveur : 8.0.43
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `behanzin_institute`
--

-- --------------------------------------------------------

--
-- Structure de la table `axes`
--

CREATE TABLE `axes` (
  `id_axe` int UNSIGNED NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_axe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_courte` text COLLATE utf8mb4_unicode_ci,
  `description_complete` longtext COLLATE utf8mb4_unicode_ci,
  `url_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `axes`
--

INSERT INTO `axes` (`id_axe`, `titre`, `code_axe`, `description_courte`, `description_complete`, `url_image`) VALUES
(1, 'Dynamiques sociales, démographiques et transformations culturelles', 'GEO', 'Les sociétés contemporaines connaissent des bouleversements rapides et profonds, à la croisée des transformations globales et des dynamiques locales. Cet axe de recherche entend explorer les tensions, recompositions et innovations sociales qui émergent dans un monde marqué par la mobilité, les chocs démographiques, les fractures culturelles et les reconfigurations des identités collectives.', '1. Migrations internes et transnationales\r\nLe Béhanzin Institute propose de :\r\n\r\nAnalyser les causes profondes des migrations (conflits, pauvreté, climat, inégalités, aspirations).\r\nAnalyser les effets des migrations sur les structures sociales, économiques et politiques.\r\nExaminer les politiques migratoires, les dynamiques diasporiques et les tensions sociales.\r\nProposer des approches inclusives intégrant genre, jeunesse et vulnérabilité.\r\n2. Transitions démographiques et recompositions générationnelles\r\nDéfis de l\'emploi des jeunes, accès à l\'éducation, santé, services publics.\r\nPolitiques de population et impacts socio-économiques.\r\nSocialisation, aspirations et engagement des jeunes générations.\r\nVieillissement et solidarité intergénérationnelle.\r\n3. Transformations culturelles, identités sociales et mutations des normes\r\nStructures familiales, parentalités, rôles sociaux.\r\nNormes de genre, religion, sexualité et politisation.\r\nTensions tradition/modernité, globalisation/enracinement.\r\nRésistance culturelle, créativité populaire, identités postcoloniales.\r\n4. Urbanisation, gouvernance territoriale et inégalités spatiales\r\nUrbanisation rapide : infrastructures, services, cohésion.\r\nGouvernance urbaine, acteurs privés et participation citoyenne.\r\nSégrégation socio-spatiale, quartiers informels, aménagement.\r\nRésilience face aux crises climatiques et démographiques.', 'uploads/68d877ef3a83a-me-infj.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `axes_chercheurs`
--

CREATE TABLE `axes_chercheurs` (
  `id_axe` int UNSIGNED NOT NULL,
  `id_chercheur` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chercheurs`
--

CREATE TABLE `chercheurs` (
  `id_chercheur` int UNSIGNED NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chercheurs`
--

INSERT INTO `chercheurs` (`id_chercheur`, `nom`, `prenom`, `titre`, `email`, `bio`, `photo_url`, `linkedin_url`) VALUES
(1, 'GUEDOU', 'Joanne', 'Journaliste', 'admin@gesnote.fr', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'uploads/68d87ae92096e-me-infj.jpg', ''),
(3, 'GUEDOU', 'Joanne', 'Journaliste', 'admvin@gesnote.fr', '', 'uploads/68d87b8fda49d-115835-les_cheveux_bruns-lanime-japon-coiffure-3840x2160.jpg', '');

-- --------------------------------------------------------

--
-- Structure de la table `partenaires`
--

CREATE TABLE `partenaires` (
  `id_partenaire` int UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_partenariat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_web_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `partenaires`
--

INSERT INTO `partenaires` (`id_partenaire`, `nom`, `type_partenariat`, `logo_url`, `site_web_url`) VALUES
(1, 'BGSI', 'Amitié', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int UNSIGNED NOT NULL,
  `nom_utilisateur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom_utilisateur`, `email`, `mot_de_passe`) VALUES
(1, 'Vianney67', 'vianneyhoueho@gmail.com', '$2y$12$T9IdFTaoQTMUagb7nKnF3eCwid00WtqaBsXRzoUjNgKiOprCAmVAu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `axes`
--
ALTER TABLE `axes`
  ADD PRIMARY KEY (`id_axe`),
  ADD UNIQUE KEY `code_axe` (`code_axe`);

--
-- Index pour la table `axes_chercheurs`
--
ALTER TABLE `axes_chercheurs`
  ADD PRIMARY KEY (`id_axe`,`id_chercheur`),
  ADD KEY `id_chercheur` (`id_chercheur`);

--
-- Index pour la table `chercheurs`
--
ALTER TABLE `chercheurs`
  ADD PRIMARY KEY (`id_chercheur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `partenaires`
--
ALTER TABLE `partenaires`
  ADD PRIMARY KEY (`id_partenaire`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `axes`
--
ALTER TABLE `axes`
  MODIFY `id_axe` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `chercheurs`
--
ALTER TABLE `chercheurs`
  MODIFY `id_chercheur` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `partenaires`
--
ALTER TABLE `partenaires`
  MODIFY `id_partenaire` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `axes_chercheurs`
--
ALTER TABLE `axes_chercheurs`
  ADD CONSTRAINT `axes_chercheurs_ibfk_1` FOREIGN KEY (`id_axe`) REFERENCES `axes` (`id_axe`) ON DELETE CASCADE,
  ADD CONSTRAINT `axes_chercheurs_ibfk_2` FOREIGN KEY (`id_chercheur`) REFERENCES `chercheurs` (`id_chercheur`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
