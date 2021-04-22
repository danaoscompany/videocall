-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 30 Mar 2021 pada 08.11
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dann5478_gomel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topic` text DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `topics`
--

INSERT INTO `topics` (`id`, `topic`, `date`) VALUES
(1, 'SmallTalk', '2021-03-29 18:40:03'),
(2, 'Dating', '2021-03-28 18:40:03'),
(14, 'Pet', '2021-03-27 18:40:03'),
(15, 'Photography', '2021-03-26 18:40:03'),
(16, 'Technology', '2021-03-25 18:40:03'),
(17, 'Film', '2021-03-24 18:40:03'),
(18, 'NewFriend', '2021-03-23 18:40:03'),
(19, 'Dating', '2021-03-22 18:40:03'),
(20, 'Photography', '2021-03-21 18:40:03'),
(21, 'Technology', '2021-03-20 18:40:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `name` text DEFAULT NULL,
  `gender` text DEFAULT NULL COMMENT 'male',
  `country` text DEFAULT NULL,
  `profile_picture` text DEFAULT NULL,
  `looking_for` text DEFAULT NULL,
  `latitude` double DEFAULT 0,
  `longitude` double DEFAULT 0,
  `verified` int(11) DEFAULT 0,
  `fcm_id` text DEFAULT NULL,
  `video_uuid` text DEFAULT NULL,
  `busy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `gender`, `country`, `profile_picture`, `looking_for`, `latitude`, `longitude`, `verified`, `fcm_id`, `video_uuid`, `busy`) VALUES
(1, 'user1@gmail.com', 'abc', 'User 1', 'male', 'Indonesia', 'profile_picture_1.jpg', 'female', -7.403512224117803, 112.67467148602009, 1, 'c33mCPDJSqCCQtr4CtIy0x:APA91bETohRuiFxnCkYtK4e2QJXXEy1tMOTV_vS85-scNrXy3bUTEsNRyWsisPh9cKccEfqzSqhvx2azLUPxJoaPW4bEBHc2JqUz2f5PPSsRkRBAMXlxoSOSykbYRO6m_XFCfYJc_4Kx', '152e20df-3d4a-40f6-a8d2-8b09e1515fa4', 0),
(2, 'user2@gmail.com', 'abc', 'User 2', 'female', 'Indonesia', 'profile_picture_2.jpg', 'male', -7.4009247, 112.6833688, 0, 'crYM7QIDRUeJ76M7se7yVu:APA91bEBD38y6FFg2KvZ9A_b8hUG4W1jHmvnjc6SsM4Uke_mxeB40pjkx-QL_PlBryKgh1JbaNLeH2l6vdtZQDEfJAn2R0gTTgs9REUGpuA3ztidCuEQLQUCz-CDLAZKr9lLVg2o-iDd', '152e20df-3d4a-40f6-a8d2-8b09e1515fa4', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
