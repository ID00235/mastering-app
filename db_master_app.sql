-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2018 at 01:17 PM
-- Server version: 5.7.20-0ubuntu0.17.04.1
-- PHP Version: 7.1.9-1+ubuntu17.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_eplanning_2018`
--

-- --------------------------------------------------------

--
-- Table structure for table `daerah`
--


CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(250) NOT NULL,
  `url` varchar(120) NOT NULL,
  `id_menu_induk` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `icon` varchar(120) DEFAULT NULL,
  `uuid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `url`, `id_menu_induk`, `urutan`, `icon`, `uuid`) VALUES
(1, 'Setting', '#', 0, 1, 'fa fa-cog', '88d2bbfd-44bb-3ff2-b3cc-887dba7001b9'),
(2, 'Menu', 'setting-menu', 1, 1, '', '63255de2-8b6e-3b6b-9ddf-1b76055ab3d6'),
(3, 'User', 'setting-user', 1, 3, '', 'c1ecf261-4ea2-3b40-be87-c810534a47b8'),
(4, 'Role', 'setting-role', 1, 2, '', 'c5ac1a69-19a8-3e9a-a66d-bc2e201da3e3'),
(5, 'User Role instansi', 'user-role-instansi', 1, 4, '', 'c7d7d645-e8ed-30e0-a981-2590379e33d3');

-- --------------------------------------------------------


--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(120) NOT NULL,
  `uuid` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_role`, `uuid`) VALUES
(1, 'Administrator', '6dfc0e85-ad7c-3da7-8356-78467bdd9c63'),
(2, 'Operator', '2a5d51ce-1898-38ad-83b3-234a7fd40b2f');

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `id_role_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `a_create` int(11) NOT NULL DEFAULT '0',
  `a_update` int(11) NOT NULL DEFAULT '0',
  `a_delete` int(11) NOT NULL DEFAULT '0',
  `uuid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `role_menu`
--

INSERT INTO `role_menu` (`id_role_menu`, `id_role`, `id_menu`, `a_create`, `a_update`, `a_delete`, `uuid`) VALUES
(1, 1, 2, 1, 1, 1, '2b55bf92-02ca-3b9d-84db-36a04d702bb5'),
(2, 1, 3, 1, 1, 1, 'ba8c81b0-29e3-3525-9be1-5f410452d491'),
(3, 1, 4, 1, 1, 1, '825b82b3-40bf-3648-9094-c9d1b1716295'),
(4, 1, 5, 1, 1, 1, 'e9115324-9676-3d5e-9e17-6f15f65588ca'),
(7, 1, 6, 1, 1, 1, '3d1992c1-8f86-3d41-9994-7f53e21d534f');


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(250) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `remember_token` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `uuid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `username`, `password`, `nama_pengguna`, `email`, `telp`, `remember_token`, `created_at`, `updated_at`, `uuid`) VALUES
(1, 'ngadmin', '$2y$10$S/BBYPjHWSvdKV5YeyAZe.h4oSOvFMuHuBVR./S3mVLpr1UV7G5py', 'Administrator Sistem', 'adminsistem@batangharikab.go.id', '081231241256', 'iIy7AyfERpiYZAMq7LIuTjdmOJAndK0jlfA4uItLHNxFiAcUouj3aFzI3f4O', '2018-03-06 09:00:00', '0000-00-00 00:00:00', '568042ed-ec8a-3acb-8c56-5a4d87054cb6'),
(2, 'opbappeda', '$2y$10$S/BBYPjHWSvdKV5YeyAZe.h4oSOvFMuHuBVR./S3mVLpr1UV7G5py', 'Operator Bappeda', 'bappeda@batangharikab.go.id', '08528938393811', 'wEZvOhRnYBpYF0uYmXoVLKw3BSVwQDxoJAAkz49Ij1ta28KA7XL4AqzZG7LI', '2018-03-06 09:00:00', '0000-00-00 00:00:00', 'd197b65a-b6e1-3cf9-826a-6e98ab11d380'),
(4, 'diskominfo', '$2y$10$AxT41uSSNaJKcG2Lp.iXIeLba7bL2mqXocnySRvONo2UdCKuWNR2O', 'Dinas Komunikasi dan Informatika', 'diskominfo@batangharikab.go.id', '0743-2221', NULL, '2018-03-26 06:14:36', NULL, '0c79c7b6-314c-35bd-bfc4-e616f6f5fe38');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_user_role`, `id_role`, `id_user`, `uuid`) VALUES
(1, 1, 1, 'c235d41e-2650-301c-aa7f-5f1094c6bb1c'),
(2, 2, 2, '0afb5b99-ce1a-384c-8626-845abc1f40d3');
-- --------------------------------------------------------

--
-- Table structure for table `user_role_instansi`
--

CREATE TABLE `user_role_instansi` (
  `id_user_role_instansi` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_daerah` varchar(15) NOT NULL,
  `kode_urusan` varchar(15) NOT NULL COMMENT 'Kode Organisasi (OPD)',
  `uuid` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `uuid`
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`) USING BTREE,
  ADD KEY `uuid` (`uuid`),
  ADD KEY `uuid_2` (`uuid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`) USING BTREE,
  ADD KEY `uuid` (`uuid`);

--
-- Indexes for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id_role_menu`) USING BTREE,
  ADD KEY `id_role` (`id_role`) USING BTREE,
  ADD KEY `id_menu` (`id_menu`) USING BTREE,
  ADD KEY `uuid` (`uuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `uuid` (`uuid`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user_role`) USING BTREE,
  ADD KEY `uuid` (`uuid`);

--
-- Indexes for table `user_role_instansi`
--
ALTER TABLE `user_role_instansi`
  ADD PRIMARY KEY (`id_user_role_instansi`) USING BTREE,
  ADD KEY `id_role` (`id_role`) USING BTREE,
  ADD KEY `id_menu` (`id_user`) USING BTREE,
  ADD KEY `uuid` (`uuid`),
  ADD KEY `kode_daerah` (`kode_daerah`),
  ADD KEY `kode_urusan` (`kode_urusan`);

ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `misi`
--

ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `role_menu`
--

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_role_instansi`
--
ALTER TABLE `user_role_instansi`
  MODIFY `id_user_role_instansi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usulan`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
