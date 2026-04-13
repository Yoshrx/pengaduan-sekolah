-- ============================================================
-- DATABASE: pengaduan_sekolah
-- Sistem Pengaduan Sarana Sekolah - UKK RPL 2025/2026
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

CREATE DATABASE IF NOT EXISTS `pengaduan_sekolah`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `pengaduan_sekolah`;

-- ------------------------------------------------------------
-- Tabel: kategoris
-- Menyimpan kategori sarana yang dapat diadukan
-- ------------------------------------------------------------
CREATE TABLE `kategoris` (
  `id`           BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` VARCHAR(50)        NOT NULL,
  `created_at`   TIMESTAMP          NULL DEFAULT NULL,
  `updated_at`   TIMESTAMP          NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kategoris` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Kebersihan',           NOW(), NOW()),
(2, 'Fasilitas Kelas',      NOW(), NOW()),
(3, 'Toilet',               NOW(), NOW()),
(4, 'Lapangan & Olahraga',  NOW(), NOW()),
(5, 'Kantin',               NOW(), NOW()),
(6, 'Perpustakaan',         NOW(), NOW()),
(7, 'Laboratorium',         NOW(), NOW()),
(8, 'Lainnya',              NOW(), NOW());

-- ------------------------------------------------------------
-- Tabel: users
-- Menyimpan data admin dan siswa
-- ------------------------------------------------------------
CREATE TABLE `users` (
  `id`                BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`              VARCHAR(255)        NOT NULL,
  `username`          VARCHAR(255)        NOT NULL,
  `nis`               VARCHAR(20)         NULL DEFAULT NULL,
  `kelas`             VARCHAR(20)         NULL DEFAULT NULL,
  `email`             VARCHAR(255)        NOT NULL,
  `email_verified_at` TIMESTAMP           NULL DEFAULT NULL,
  `password`          VARCHAR(255)        NOT NULL,
  `role`              ENUM('admin','siswa') NOT NULL DEFAULT 'siswa',
  `remember_token`    VARCHAR(100)        NULL DEFAULT NULL,
  `created_at`        TIMESTAMP           NULL DEFAULT NULL,
  `updated_at`        TIMESTAMP           NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password: admin123 & siswa123 (bcrypt hash demo)
INSERT INTO `users` (`id`, `name`, `username`, `nis`, `kelas`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Sekolah', 'admin',  NULL,      NULL,         'admin@sekolah.test', '$2y$12$example_hash_admin', 'admin', NOW(), NOW()),
(2, 'Budi Santoso',  'siswa1', '2024001', 'XII RPL 1',  'budi@sekolah.test',  '$2y$12$example_hash_siswa', 'siswa', NOW(), NOW()),
(3, 'Siti Rahayu',   'siswa2', '2024002', 'XII RPL 2',  'siti@sekolah.test',  '$2y$12$example_hash_siswa', 'siswa', NOW(), NOW()),
(4, 'Andi Pratama',  'siswa3', '2024003', 'XII RPL 1',  'andi@sekolah.test',  '$2y$12$example_hash_siswa', 'siswa', NOW(), NOW());

-- ------------------------------------------------------------
-- Tabel: pengaduans
-- Menyimpan data aspirasi / pengaduan siswa
-- status: Menunggu | Proses | Selesai  (sesuai ERD soal)
-- ------------------------------------------------------------
CREATE TABLE `pengaduans` (
  `id`            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`       BIGINT(20) UNSIGNED NOT NULL,
  `kategori_id`   BIGINT(20) UNSIGNED NULL DEFAULT NULL,
  `judul`         VARCHAR(255)        NOT NULL,
  `isi_pengaduan` TEXT                NOT NULL,
  `lokasi`        VARCHAR(100)        NULL DEFAULT NULL,
  `foto`          VARCHAR(255)        NULL DEFAULT NULL,
  `status`        ENUM('Menunggu','Proses','Selesai') NOT NULL DEFAULT 'Menunggu',
  `feedback`      TEXT                NULL DEFAULT NULL,
  `created_at`    TIMESTAMP           NULL DEFAULT NULL,
  `updated_at`    TIMESTAMP           NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengaduans_user_id_foreign` (`user_id`),
  KEY `pengaduans_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `pengaduans_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengaduans_kategori_id_foreign`
    FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data contoh pengaduan
INSERT INTO `pengaduans` (`user_id`, `kategori_id`, `judul`, `isi_pengaduan`, `lokasi`, `status`, `feedback`, `created_at`, `updated_at`) VALUES
(2, 3, 'Keran air toilet rusak', 'Keran air di toilet lantai 2 sudah rusak sejak 2 minggu yang lalu dan belum diperbaiki. Siswa kesulitan mencuci tangan.', 'Toilet Lantai 2', 'Proses', 'Terima kasih atas laporan Anda. Tim maintenance sedang dalam proses perbaikan.', NOW(), NOW()),
(3, 2, 'AC kelas tidak berfungsi', 'AC di ruang kelas XII RPL 2 tidak dingin sejak awal semester. Konsentrasi belajar terganggu karena panas.', 'Kelas XII RPL 2', 'Menunggu', NULL, NOW(), NOW()),
(4, 1, 'Halaman sekolah kotor', 'Halaman depan sekolah banyak sampah berserakan terutama setelah jam istirahat. Perlu penambahan tempat sampah.', 'Halaman Depan', 'Selesai', 'Sudah ditambahkan 5 tempat sampah baru di halaman depan. Terima kasih atas masukan yang membangun!', NOW(), NOW());

-- ------------------------------------------------------------
-- Cache & Sessions (struktur minimal)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cache` (
  `key`        VARCHAR(255) NOT NULL,
  `value`      MEDIUMTEXT   NOT NULL,
  `expiration` INT(11)      NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id`            VARCHAR(255)   NOT NULL,
  `user_id`       BIGINT(20) UNSIGNED NULL DEFAULT NULL,
  `ip_address`    VARCHAR(45)    NULL DEFAULT NULL,
  `user_agent`    TEXT           NULL DEFAULT NULL,
  `payload`       LONGTEXT       NOT NULL,
  `last_activity` INT(11)        NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
