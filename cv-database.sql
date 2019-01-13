--Base de datos para la aplicación de DanRamz

--Creación de la base de datos de la aplicación
CREATE DATABASE IF NOT EXISTS cv_database;

--En la aplicación se tendrán multiples tablas para la aplicación.
--Las tablas definidas para la aplicación son:
--Users
--Abouts
--Knowledges
--Trainings
--Portafolios

--La tabla de Users contendrá:
--id
--Email
--Pass
CREATE TABLE IF NOT EXISTS users(
  `id` SERIAL,
  `username` VARCHAR(20) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE (`username`, `email`)
);

--La tabla de Abouts contendrá:
--id
--Name
--Degree
--Birth
--Phone_number
--Email
--Live
--Description
--Github_link
--Twitter_link
--Linkedin_link
--Facebook_llnk
CREATE TABLE IF NOT EXISTS abouts(
  `id` SERIAL,
  `name` VARCHAR(80) NOT NULL,
  `degree` VARCHAR(100) NOT NULL,
  `birth` DATE,
  `phone_ext` VARCHAR(2),
  `phone_number` VARCHAR(12),
  `email` VARCHAR(50) NOT NULL,
  `state` VARCHAR(30),
  `city` VARCHAR(30),
  `description` TEXT,
  `github_link` VARCHAR(100),
  `twitter_link` VARCHAR(100),
  `linkedin_link` VARCHAR(100),
  `facebook_link` VARCHAR(100),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

--La tabla de Knowledges contendrá:
--id
--Knowledge
--Percentage
CREATE TABLE IF NOT EXISTS knowledges(
  `id` SERIAL,
  `knowledge` VARCHAR(20) NOT NULL,
  `percentage` INT(3) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE (`knowledge`)
);

--La tabla de Trainings contendrá:
--id
--Training_name
--Training_place
--Training_start_date
--Training_finish_date

--La tabla de Portfolio contendrá:
--id
--Name
--Description
--Technologies
--Link
--Image
CREATE TABLE IF NOT EXISTS portafolios(
  `id` SERIAL,
  `name` VARCHAR(80) NOT NULL,
  `description` TEXT NOT NULL,
  `technologies` VARCHAR(80) NOT NULL,
  `link` VARCHAR(255),
  `image` VARCHAR(255),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
