CREATE DATABASE IF NOT EXISTS db_sekolah CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_sekolah;

DROP TABLE IF EXISTS guru;
DROP TABLE IF EXISTS siswa;
DROP TABLE IF EXISTS anggota;

CREATE TABLE anggota (
  no_ktp        VARCHAR(20)  NOT NULL,
  nama_anggota  VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  email         VARCHAR(100) NOT NULL,
  password      CHAR(32)     NOT NULL COMMENT 'MD5',
  hp            VARCHAR(20)  NOT NULL,
  tautan_foto   VARCHAR(255) NULL,
  PRIMARY KEY (no_ktp),
  UNIQUE KEY uq_anggota_email (email),
  UNIQUE KEY uq_anggota_hp (hp)
) ENGINE=InnoDB;

CREATE TABLE siswa (
  no_ktp VARCHAR(20) NOT NULL,
  nim    VARCHAR(20) NOT NULL,
  kelas  VARCHAR(20) NOT NULL,
  status ENUM('A','TA') NOT NULL DEFAULT 'A',
  PRIMARY KEY (no_ktp),
  UNIQUE KEY uq_siswa_nim (nim),
  CONSTRAINT fk_siswa_anggota FOREIGN KEY (no_ktp) REFERENCES anggota(no_ktp)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE guru (
  no_ktp       VARCHAR(20)  NOT NULL,
  nik          VARCHAR(20)  NOT NULL,
  spesialisasi VARCHAR(100) NOT NULL,
  PRIMARY KEY (no_ktp),
  UNIQUE KEY uq_guru_nik (nik),
  CONSTRAINT fk_guru_anggota FOREIGN KEY (no_ktp) REFERENCES anggota(no_ktp)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Data contoh (password semuanya: password123)
INSERT INTO anggota (no_ktp, nama_anggota, jenis_kelamin, email, password, hp) VALUES
('3201010101010001', 'Budi Santoso', 'L', 'budi@sekolah.test', MD5('password123'), '081200000001'),
('3201010101010002', 'Siti Aminah',  'P', 'siti@sekolah.test', MD5('password123'), '081200000002'),
('3201010101010003', 'Andi Pratama', 'L', 'andi@sekolah.test', MD5('password123'), '081200000003');

INSERT INTO siswa (no_ktp, nim, kelas, status) VALUES
('3201010101010001', '2024001', 'XII-IPA-1', 'A'),
('3201010101010003', '2024002', 'XI-IPS-2',  'A');

INSERT INTO guru (no_ktp, nik, spesialisasi) VALUES
('3201010101010002', '198501012010011001', 'Matematika');
