
CREATE DATABASE IF NOT EXISTS `behanzin_institute` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `behanzin_institute`;

CREATE TABLE `axes` (
  `id_axe` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `titre` VARCHAR(255) NOT NULL,
  `code_axe` VARCHAR(10) NOT NULL UNIQUE, 
  `description_courte` TEXT,
  `description_complete` LONGTEXT,
  `url_image` VARCHAR(255) 
);


CREATE TABLE `chercheurs` (
  `id_chercheur` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `titre` VARCHAR(150), 
  `email` VARCHAR(100) UNIQUE,
  `bio` TEXT,
  `photo_url` VARCHAR(255),
  `linkedin_url` VARCHAR(255)
);

CREATE TABLE `axes_chercheurs` (
  `id_axe` INT UNSIGNED NOT NULL,
  `id_chercheur` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_axe`, `id_chercheur`),
  FOREIGN KEY (`id_axe`) REFERENCES `axes`(`id_axe`) ON DELETE CASCADE,
  FOREIGN KEY (`id_chercheur`) REFERENCES `chercheurs`(`id_chercheur`) ON DELETE CASCADE
);

CREATE TABLE `partenaires` (
  `id_partenaire` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(255) NOT NULL,
  `type_partenariat` VARCHAR(100),
  `logo_url` VARCHAR(255),
  `site_web_url` VARCHAR(255)
);