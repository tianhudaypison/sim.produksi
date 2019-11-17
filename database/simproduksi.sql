/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50725
 Source Host           : localhost:3306
 Source Schema         : simproduksi

 Target Server Type    : MySQL
 Target Server Version : 50725
 File Encoding         : 65001

 Date: 18/11/2019 03:33:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mbahan
-- ----------------------------
DROP TABLE IF EXISTS `mbahan`;
CREATE TABLE `mbahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `keterangan` text,
  `satuan` varchar(50) DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mbahan
-- ----------------------------
BEGIN;
INSERT INTO `mbahan` VALUES (1, 'Kain American Drill', '-', 'Meter', 12500, '1');
COMMIT;

-- ----------------------------
-- Table structure for motorisasi
-- ----------------------------
DROP TABLE IF EXISTS `motorisasi`;
CREATE TABLE `motorisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(125) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of motorisasi
-- ----------------------------
BEGIN;
INSERT INTO `motorisasi` VALUES (1, 'Pemilik', '1');
INSERT INTO `motorisasi` VALUES (2, 'Bagian Produksi', '1');
INSERT INTO `motorisasi` VALUES (3, 'Bagian Marketing', '1');
COMMIT;

-- ----------------------------
-- Table structure for mpegawai
-- ----------------------------
DROP TABLE IF EXISTS `mpegawai`;
CREATE TABLE `mpegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `alamat` text,
  `telepon` varchar(12) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mpegawai
-- ----------------------------
BEGIN;
INSERT INTO `mpegawai` VALUES (1, 'Gunali Rezqi Mauludi', 'Cileunyi', '085721334500', '1');
COMMIT;

-- ----------------------------
-- Table structure for mpelanggan
-- ----------------------------
DROP TABLE IF EXISTS `mpelanggan`;
CREATE TABLE `mpelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `alamat` text,
  `telepon` varchar(12) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mpelanggan
-- ----------------------------
BEGIN;
INSERT INTO `mpelanggan` VALUES (1, 'Rendi Nugraha', 'Cileunyi', '085726383737', '1');
COMMIT;

-- ----------------------------
-- Table structure for mpengguna
-- ----------------------------
DROP TABLE IF EXISTS `mpengguna`;
CREATE TABLE `mpengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpegawai` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `idhakakses` char(1) DEFAULT NULL COMMENT '1 : Pemilik\n2 : Bagian Produksi\n3 : Bagian Marketing',
  `terakhirlogin` datetime DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  PRIMARY KEY (`id`,`idpegawai`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mpengguna
-- ----------------------------
BEGIN;
INSERT INTO `mpengguna` VALUES (1, 1, 'gunalirezqi', 'e10adc3949ba59abbe56e057f20f883e', '1', '2019-11-18 03:32:06', 1);
COMMIT;

-- ----------------------------
-- Table structure for mproduk
-- ----------------------------
DROP TABLE IF EXISTS `mproduk`;
CREATE TABLE `mproduk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `margin` decimal(10,0) DEFAULT NULL,
  `hargajual` decimal(10,0) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for mproduk_detail
-- ----------------------------
DROP TABLE IF EXISTS `mproduk_detail`;
CREATE TABLE `mproduk_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idkategori` int(11) DEFAULT NULL,
  `idbahan` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for mstasiun
-- ----------------------------
DROP TABLE IF EXISTS `mstasiun`;
CREATE TABLE `mstasiun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `keterangan` text,
  `totalkapasitas` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for mstasiun_detail
-- ----------------------------
DROP TABLE IF EXISTS `mstasiun_detail`;
CREATE TABLE `mstasiun_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idstasiun` int(11) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
