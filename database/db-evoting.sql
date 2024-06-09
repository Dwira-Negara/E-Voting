-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jun 2024 pada 06.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-evoting`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_paslon`
--

CREATE TABLE `data_paslon` (
  `id` int(11) NOT NULL,
  `jenis` int(5) NOT NULL,
  `no_urut` int(5) NOT NULL,
  `nm_paslon` varchar(200) NOT NULL,
  `gambar1` varchar(100) NOT NULL,
  `gambar2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `data_paslon`
--

INSERT INTO `data_paslon` (`id`, `jenis`, `no_urut`, `nm_paslon`, `gambar1`, `gambar2`) VALUES
(4, 1, 1, 'Anies', 'paslon-1-anies.jpeg', 'visi-misi-01.png'),
(5, 1, 2, 'Prabowo Subianto', 'paslon-2-prabowo.jpg', 'visi-misi-02.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(1) NOT NULL,
  `lembaga` varchar(100) NOT NULL,
  `voting` varchar(100) NOT NULL,
  `tambahan` varchar(100) NOT NULL,
  `mulai` datetime NOT NULL,
  `selesai` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `lembaga`, `voting`, `tambahan`, `mulai`, `selesai`) VALUES
(1, 'E-VOTING', 'PEMILIHAN KETUA BEM', 'TAHUN 2024', '2024-05-07 18:15:00', '2024-06-30 18:15:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi`
--

CREATE TABLE `registrasi` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `kode_akses` varchar(20) NOT NULL,
  `nama_mhs` varchar(100) NOT NULL,
  `jurusan` varchar(25) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `registrasi`
--

INSERT INTO `registrasi` (`id`, `nim`, `kode_akses`, `nama_mhs`, `jurusan`, `no_hp`, `status`) VALUES
(1, '220040210', 'password', 'Surya Pranata', '', '', 'verified'),
(1111, '220040247', 'password', 'Kelvin Gaming', '', '', 'verified');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dpt`
--

CREATE TABLE `tbl_dpt` (
  `id` int(11) NOT NULL,
  `nim` varchar(100) NOT NULL,
  `kode_akses` varchar(25) NOT NULL,
  `nama_mhs` varchar(100) NOT NULL,
  `jurusan` varchar(12) NOT NULL,
  `kampus` varchar(100) NOT NULL,
  `ktm` varchar(100) NOT NULL,
  `level` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_dpt`
--

INSERT INTO `tbl_dpt` (`id`, `nim`, `kode_akses`, `nama_mhs`, `jurusan`, `kampus`, `ktm`, `level`) VALUES
(1, 'admin', 'password', 'Administrator', '1', 'ITB Stikom Bali', '', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_paslon`
--

CREATE TABLE `tbl_paslon` (
  `id` int(10) NOT NULL,
  `nim` varchar(15) NOT NULL,
  `nama_mhs` varchar(150) NOT NULL,
  `jurusan` int(3) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `vote` int(2) NOT NULL,
  `waktu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_paslon`
--

INSERT INTO `tbl_paslon` (`id`, `nim`, `nama_mhs`, `jurusan`, `jenis`, `vote`, `waktu`) VALUES
(1, '220040210', 'Surya Pranata', 0, '1', 2, '20:28:42pm');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_paslon`
--
ALTER TABLE `data_paslon`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id`,`nim`) USING BTREE;

--
-- Indeks untuk tabel `tbl_dpt`
--
ALTER TABLE `tbl_dpt`
  ADD PRIMARY KEY (`id`,`nim`) USING BTREE;

--
-- Indeks untuk tabel `tbl_paslon`
--
ALTER TABLE `tbl_paslon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_paslon`
--
ALTER TABLE `data_paslon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1112;

--
-- AUTO_INCREMENT untuk tabel `tbl_dpt`
--
ALTER TABLE `tbl_dpt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_paslon`
--
ALTER TABLE `tbl_paslon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=462;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
