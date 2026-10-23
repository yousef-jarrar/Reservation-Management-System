-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 12:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `physiotherapy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `availability_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `session_id`, `availability_id`, `status`) VALUES
(1, 1, 1, 1, 'Accepted'),
(2, 1, 1, 3, 'Pending'),
(3, 1, 1, 2, 'Accepted'),
(4, 1, 2, 4, 'Accepted'),
(5, 10, 1, 5, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `id` int(11) NOT NULL,
  `physiotherapist_id` int(11) NOT NULL,
  `available_date` date NOT NULL,
  `available_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`id`, `physiotherapist_id`, `available_date`, `available_time`) VALUES
(1, 2, '2026-10-30', '10:00:00'),
(2, 2, '2026-10-23', '16:55:00'),
(3, 6, '2026-10-24', '19:29:00'),
(4, 2, '2026-10-30', '14:01:00'),
(5, 2, '2026-10-30', '19:48:00'),
(6, 2, '2026-10-29', '14:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `duration`, `price`) VALUES
(1, 'Physiotherapy Session', 60, 25.00),
(2, 'phsi', 90, 280.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'yousef', 'yousef@gmail.com', '$2y$10$uPdAoaQe5w0YKB3GBguG5uKo.54WU2N/S6exkMjq5eyq//g.8tZbO', 'patient'),
(2, 'ahmad omar musa', 'ahmad@gmail.com', '$2y$10$08/AbtyW13vZw2nB/cg/Eee70Ugy2/FKTogJhEYTtwb6RVb3K33G2', 'physiotherapist'),
(3, 'adam', 'adam@gmail.com', '$2y$10$APzWR1YO9DQEJPlISNwakecyBuLw2mMf6TY3Env.ok2DAlDikzXnu', 'admin'),
(6, 'samer', 'samer@gmail.com', '$2y$10$yMcn7yvc.vjrp7FvrbqxxebsDS3jcEtK0ZuFUtvF3KnMpZ3vq6RWK', 'physiotherapist'),
(9, 'tamer', 'tamer@gmail.com', '$2y$10$dYN97PDvSJzYuj49elIamuY41GTx.MMq4Myx2uBIHxgdM8YPaKDty', 'physiotherapist'),
(10, 'fadi', 'fadi@gmail.com', '$2y$10$4hSOQbo8nszXyjugANhjg.ZkYNtnTukoV2wUH24PwVkADb4Nu5bhu', 'patient'),
(11, 'rami', 'rami@gmail.com', '$2y$10$oG4H3dGeo7lbE/wTWITdWOQ7.5bFyrNEJoNHD7L7CpcjR0Bsdlk66', 'patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `availability_id` (`availability_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `physiotherapist_id` (`physiotherapist_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`availability_id`) REFERENCES `availability` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_appointments_session` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`physiotherapist_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
