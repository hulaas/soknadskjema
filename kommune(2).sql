-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01. Mar, 2019 01:55 AM
-- Tjener-versjon: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kommune`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `brukere`
--

CREATE TABLE `brukere` (
  `id` int(11) NOT NULL,
  `brukernavn` varchar(30) NOT NULL,
  `epost` varchar(50) NOT NULL,
  `passord` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `rolle` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `brukere`
--

INSERT INTO `brukere` (`id`, `brukernavn`, `epost`, `passord`, `salt`, `rolle`, `admin`) VALUES
(1, 'test', 'test@test.no', 'a373ed56ff3f9a791fea121c74b2e3dde37609a4baa0a63a18b0f89814896cf36e60354434fd28681d23401bd1f3425b7fe5dc7756b899253f355ac5565efd35', '3ee73baa6473ba8c3ae897e421cc0b4c89c0d7047b8d0e305146a7e6a79cfa2601f75004d6128245b7639235572fd6986bee9773a1949c6ae84175e8d1ac088b', 'Leder', 1),
(2, 'bruker', 'bruker@bruker.no', 'b278e9bbe2e3e0605e5aa167f83a19242827380b7e524be6e5383f2456ee9394e45a497b67adf45f2f75a33f3d320f13f44085c1cc8e60904fd415f9aec5c06a', '7b22549e6027eead4405a1336e7edd3d4a0358479cb975d809f028e573278f6fe76f64580e5b4630ebcbc5f054778099650abb630671742a32b7f69eec36945b', 'Leder', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `cookie_logginn_autentisering`
--

CREATE TABLE `cookie_logginn_autentisering` (
  `bruker_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `logginn_forsok`
--

CREATE TABLE `logginn_forsok` (
  `bruker_id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `tid` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `logginn_forsok`
--

INSERT INTO `logginn_forsok` (`bruker_id`, `ip`, `tid`) VALUES
(1, '::1', '1551220854'),
(1, '::1', '1551220857'),
(1, '::1', '1551220861'),
(1, '::1', '1551365681'),
(1, '::1', '1551365685'),
(1, '::1', '1551365688'),
(1, '::1', '1551365777'),
(1, '::1', '1551365782'),
(1, '::1', '1551365787');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `pollett_logginn_autentisering`
--

CREATE TABLE `pollett_logginn_autentisering` (
  `bruker_id` int(11) NOT NULL,
  `passord_hash` varchar(255) NOT NULL,
  `valg_hash` varchar(255) NOT NULL,
  `utløpt` int(11) NOT NULL DEFAULT '0',
  `utløpt_dato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brukere`
--
ALTER TABLE `brukere`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cookie_logginn_autentisering`
--
ALTER TABLE `cookie_logginn_autentisering`
  ADD KEY `bruker_id` (`bruker_id`);

--
-- Indexes for table `logginn_forsok`
--
ALTER TABLE `logginn_forsok`
  ADD KEY `bruker_id` (`bruker_id`);

--
-- Indexes for table `pollett_logginn_autentisering`
--
ALTER TABLE `pollett_logginn_autentisering`
  ADD KEY `bruker_id` (`bruker_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brukere`
--
ALTER TABLE `brukere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `cookie_logginn_autentisering`
--
ALTER TABLE `cookie_logginn_autentisering`
  ADD CONSTRAINT `cookie_logginn_autentisering_ibfk_1` FOREIGN KEY (`bruker_id`) REFERENCES `brukere` (`id`);

--
-- Begrensninger for tabell `logginn_forsok`
--
ALTER TABLE `logginn_forsok`
  ADD CONSTRAINT `logginn_forsok_ibfk_1` FOREIGN KEY (`bruker_id`) REFERENCES `brukere` (`id`);

--
-- Begrensninger for tabell `pollett_logginn_autentisering`
--
ALTER TABLE `pollett_logginn_autentisering`
  ADD CONSTRAINT `pollett_logginn_autentisering_ibfk_1` FOREIGN KEY (`bruker_id`) REFERENCES `brukere` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
