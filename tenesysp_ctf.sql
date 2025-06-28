-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.0.100
-- Waktu pembuatan: 15 Jun 2025 pada 06.54
-- Versi server: 8.0.41-32
-- Versi PHP: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tenesysp_ctf`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `cat_id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`cat_id`, `name`) VALUES
(19, 'test'),
(18, 'Web Exploitation');

-- --------------------------------------------------------

--
-- Struktur dari tabel `challenges`
--

CREATE TABLE `challenges` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `score` int NOT NULL,
  `file` varchar(500) DEFAULT NULL,
  `cat_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `challenges`
--

INSERT INTO `challenges` (`id`, `title`, `description`, `flag`, `score`, `file`, `cat_id`) VALUES
(29, 'Sanity Check', 'check this website ', 'Tenesys{S3arch1ng-For-Th3-L0st-K3y5}', 100, NULL, 18),
(33, 'Robots', 'Do you know robots?', 'Tenesys{F1nd1ng-Th3-Unc4ch3d-R0b0t-Tr41l}', 100, NULL, 18);

-- --------------------------------------------------------

--
-- Struktur dari tabel `scoreboard`
--

CREATE TABLE `scoreboard` (
  `s_id` int NOT NULL,
  `user_id` int NOT NULL,
  `c_id` int NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `scoreboard`
--

INSERT INTO `scoreboard` (`s_id`, `user_id`, `c_id`, `ts`) VALUES
(46, 20, 29, '2025-06-14 05:20:14'),
(48, 1, 33, '2025-06-14 13:40:05'),
(49, 1, 29, '2025-06-14 13:44:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role` varchar(10) DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `reset_token`, `reset_token_expires`) VALUES
(1, 'Rommel', 'ichbinerwin99@gmail.com', '1234', 'admin', NULL, NULL),
(19, 'Udin', 'Asep00@gmail.com', '123456', 'user', NULL, NULL),
(20, 'A', 'a@gmail.com', '1234', 'user', NULL, NULL),
(22, 'Tenesys', 'test@gmail.com', 'Tenesys', 'user', NULL, NULL),
(23, 'Lann', 'olansiallagan6@gmail.com', 'olan1256', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `visitors`
--

CREATE TABLE `visitors` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `visitors`
--

INSERT INTO `visitors` (`id`, `name`, `email`, `message`) VALUES
(1, 'Admin', 'test@gmail.com', 'Test');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeks untuk tabel `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indeks untuk tabel `scoreboard`
--
ALTER TABLE `scoreboard`
  ADD PRIMARY KEY (`s_id`,`user_id`,`c_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `scoreboard`
--
ALTER TABLE `scoreboard`
  MODIFY `s_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `scoreboard`
--
ALTER TABLE `scoreboard`
  ADD CONSTRAINT `scoreboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scoreboard_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
