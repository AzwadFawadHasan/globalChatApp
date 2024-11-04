-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 04, 2024 at 11:23 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='This table stores info about user login credentials';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'root', 'root@gmail.com', 'root'),
(2, 'devuser', 'devuser@gmail.com', '$2y$10$uFOv1sM7Mguj75KuTMklqelnXlmDanI4E3FhZUr0HHtEwCMUUZnPu'),
(3, 'devuser', 'root@gmail.com', '$2y$10$N3D7hpH6HudCQKK6B.nbkeUzSDL66L49fcMtL.2Kpe9LjMski1ZXy'),
(4, 'devuser', 'devuser@gmail.com', '$2y$10$hyJ2Bs1/01pCLP9ALquefeaDNgOSlxHxiFNLEfHOBd.6DfVJsYc42'),
(5, 'root', 'root@gmail.com', '$2y$10$IbGlqGFrnrX6pW5sRmQFCudPMp6Kptt.9iInfOwjWcZ0X59DmmT/q'),
(6, 'root', 'root@gmail.com', '$2y$10$A9qpIIpoJakjSgc1bMXAWer6tdynnQP5AuaZVs5IG.59xGBTa0.m6'),
(7, 'root', 'root@gmail.com', '$2y$10$YwewmIGZ0PxCJ/4Sk.zg0.EyI1wcLFwh7CuwbtwZcAe1aXqdEnCxi'),
(8, 'root', 'root@gmail.com', '$2y$10$MSJQbALCVgOBQGxfFGMqxeRIMce33T4p9jq8J507eOmKKtYSDDwB.'),
(9, 'root', 'root@gmail.com', '$2y$10$tN8LcT3wIpza2bKc3d.07OhSwtDAUFwFCHu2Rik4l1ftmQmBOi/za'),
(10, 'root', 'root@gmail.com', '$2y$10$PtgXn2Zn93wb5XAu3HpeN.bW8w85Few3wG5MYwdmDa0vouCTLnlZG'),
(11, 'root', 'root@gmail.com', '$2y$10$MhKj7jQcUurvwcoIy0J5dOAmVQznRQ8xznVEvq.v2LhX7EvQoaydu'),
(12, 'mydev', 'mydev@gmail.com', '$2y$10$gWbPjyGRh3xlnlcRqMYBueVJ6hSNmOJqiLqXWrcs/AMmHj4ANeMYy'),
(13, 'mydev2', 'mydev2@gmail.com', '$2y$10$aYLmPfHijd8Dk4.Lub6.ROz5Qi2OTMyRjmylTibAr5LPy7T1EG.X2'),
(14, 'root@gmail.com', 'rooot@gmail.com', '$2y$10$qJPW7IjHDcbBBHCrVYYFQOu1NrL35xk9XGez1s/dFlrFKW7ZXcKFa');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
