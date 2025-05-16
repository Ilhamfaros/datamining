-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Feb 2024 pada 11.39
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbmining`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `transformasi`
--

CREATE TABLE `transformasi` (
  `NIM` varchar(20) NOT NULL,
  `wilayah` int(20) NOT NULL,
  `prodi` int(20) NOT NULL,
  `ipk` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `upload_data`
--

CREATE TABLE `upload_data` (
  `NIM` varchar(20) NOT NULL,
  `wilayah` varchar(20) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `ipk` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(2, 'adminit', 'adminit@gmail.com', '4297f44b13955235245b2497399d7a93', 'admin'),
(9, 'adminit2', 'adminit2@gmail.com', '4297f44b13955235245b2497399d7a93', 'admin'),
(12, 'akademik', 'akademik@gmail.com', '4297f44b13955235245b2497399d7a93', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `transformasi`
--
ALTER TABLE `transformasi`
  ADD PRIMARY KEY (`NIM`);

--
-- Indeks untuk tabel `upload_data`
--
ALTER TABLE `upload_data`
  ADD PRIMARY KEY (`NIM`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
