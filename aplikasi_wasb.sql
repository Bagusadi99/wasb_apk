-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Mar 2025 pada 02.55
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_wasb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `halte`
--

CREATE TABLE `halte` (
  `halte_id` int(11) NOT NULL,
  `halte_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `koridor`
--

CREATE TABLE `koridor` (
  `koridor_id` int(11) NOT NULL,
  `koridor_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `koridor`
--

INSERT INTO `koridor` (`koridor_id`, `koridor_nama`) VALUES
(1, 'Koridor 1'),
(2, 'Koridor 2'),
(3, 'Koridor 3'),
(4, 'Koridor 4'),
(5, 'Koridor 5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_halte`
--

CREATE TABLE `laporan_halte` (
  `laporan_halte_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `koridor_id` int(11) DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `halte_id` int(11) DEFAULT NULL,
  `lokasi_halte` varchar(255) DEFAULT NULL,
  `tanggal_waktu_halte` datetime NOT NULL,
  `bukti_kebersihan_lantai_halte` text DEFAULT NULL,
  `bukti_kebersihan_kaca_halte` text DEFAULT NULL,
  `bukti_kebersihan_sampah_halte` text DEFAULT NULL,
  `kendala_halte` text DEFAULT NULL,
  `bukti_kondisi_halte` text DEFAULT NULL,
  `pekerja_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_pool`
--

CREATE TABLE `laporan_pool` (
  `laporan_pool_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `koridor_id` int(11) DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `halte_id` int(11) DEFAULT NULL,
  `lokasi_pool` varchar(255) DEFAULT NULL,
  `tanggal_waktu_pool` datetime NOT NULL,
  `bukti_kebersihan_lantai_pool` text DEFAULT NULL,
  `bukti_kebersihan_kaca_pool` text DEFAULT NULL,
  `bukti_kebersihan_sampah_pool` text DEFAULT NULL,
  `kendala_pool` text DEFAULT NULL,
  `bukti_kondisi_pool` text DEFAULT NULL,
  `pekerja_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerja`
--

CREATE TABLE `pekerja` (
  `pekerja_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `nama_pekerja` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pekerja`
--

INSERT INTO `pekerja` (`pekerja_id`, `shift_id`, `nama_pekerja`) VALUES
(61, 1, 'IRAWAN HADI'),
(62, 2, 'DWI AGUNG'),
(63, 3, 'AGUS TRIANTONO'),
(64, 1, 'MOCH TONY'),
(65, 2, 'ARDINTA NUR'),
(66, 3, 'BAGUS BUDI'),
(67, 1, 'ABDUL AZIZ'),
(68, 2, 'ANDY SATRIA'),
(69, 3, 'MUKTI ERMAWAN'),
(70, 1, 'MEI AHADI TRIJAYANTO');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE `shift` (
  `shift_id` int(11) NOT NULL,
  `shift_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`shift_id`, `shift_nama`) VALUES
(1, 'shift1'),
(2, 'shift2'),
(3, 'middle');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `halte`
--
ALTER TABLE `halte`
  ADD PRIMARY KEY (`halte_id`);

--
-- Indeks untuk tabel `koridor`
--
ALTER TABLE `koridor`
  ADD PRIMARY KEY (`koridor_id`);

--
-- Indeks untuk tabel `laporan_halte`
--
ALTER TABLE `laporan_halte`
  ADD PRIMARY KEY (`laporan_halte_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `koridor_id` (`koridor_id`),
  ADD KEY `shift_id` (`shift_id`),
  ADD KEY `halte_id` (`halte_id`),
  ADD KEY `pekerja_id` (`pekerja_id`);

--
-- Indeks untuk tabel `laporan_pool`
--
ALTER TABLE `laporan_pool`
  ADD PRIMARY KEY (`laporan_pool_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `koridor_id` (`koridor_id`),
  ADD KEY `shift_id` (`shift_id`),
  ADD KEY `halte_id` (`halte_id`),
  ADD KEY `pekerja_id` (`pekerja_id`);

--
-- Indeks untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`pekerja_id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Indeks untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `halte`
--
ALTER TABLE `halte`
  MODIFY `halte_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `koridor`
--
ALTER TABLE `koridor`
  MODIFY `koridor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan_halte`
--
ALTER TABLE `laporan_halte`
  MODIFY `laporan_halte_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_pool`
--
ALTER TABLE `laporan_pool`
  MODIFY `laporan_pool_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `pekerja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `shift`
--
ALTER TABLE `shift`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan_halte`
--
ALTER TABLE `laporan_halte`
  ADD CONSTRAINT `laporan_halte_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_halte_ibfk_2` FOREIGN KEY (`koridor_id`) REFERENCES `koridor` (`koridor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_halte_ibfk_3` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`shift_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_halte_ibfk_4` FOREIGN KEY (`halte_id`) REFERENCES `halte` (`halte_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_halte_ibfk_5` FOREIGN KEY (`pekerja_id`) REFERENCES `pekerja` (`pekerja_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_pool`
--
ALTER TABLE `laporan_pool`
  ADD CONSTRAINT `laporan_pool_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_pool_ibfk_2` FOREIGN KEY (`koridor_id`) REFERENCES `koridor` (`koridor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_pool_ibfk_3` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`shift_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_pool_ibfk_4` FOREIGN KEY (`halte_id`) REFERENCES `halte` (`halte_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_pool_ibfk_5` FOREIGN KEY (`pekerja_id`) REFERENCES `pekerja` (`pekerja_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  ADD CONSTRAINT `pekerja_ibfk_1` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`shift_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
