CREATE DATABASE IF NOT EXISTS `sistem_manajemen_anggota_gym`;

USE `db_anggota`;

CREATE TABLE IF NOT EXISTS `db_anggota` (
    `id_anggota` INT(11) NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(50) NOT NULL,
    `alamat` TEXT NOT NULL,
    `jenis_paket` VARCHAR(50) NOT NULL,
    `tanggal_mulai` DATE NOT NULL,
    `tanggal_berakhir` DATE NOT NULL,
    PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `db_anggota` (`nama`, `alamat`, `jenis_paket`, `tanggal_mulai`, `tanggal_berakhir`) VALUES
('Cabriella Vanesa Kawulusan', 'Condongcatur', 'VIP', '2025-06-25', '2025-07-25'),
('Desak Putu', 'Sleman', 'Reguler', '2025-06-25', '2025-07-25'),
('Cantika Putri', 'Bantul', 'Regular', '2025-06-25', '2025-07-25');
