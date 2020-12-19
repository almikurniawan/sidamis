/*
 Navicat Premium Data Transfer

 Source Server         : koneksipostgres
 Source Server Type    : PostgreSQL
 Source Server Version : 100015
 Source Host           : localhost:5432
 Source Catalog        : sidamis
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 100015
 File Encoding         : 65001

 Date: 09/12/2020 13:15:33
*/


-- ----------------------------
-- Sequence structure for karyawan_kar_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."karyawan_kar_id_seq";
CREATE SEQUENCE "public"."karyawan_kar_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for ref_group_akses_ref_group_akses_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."ref_group_akses_ref_group_akses_id_seq";
CREATE SEQUENCE "public"."ref_group_akses_ref_group_akses_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for ref_modul_akses_ref_modul_akses_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."ref_modul_akses_ref_modul_akses_id_seq";
CREATE SEQUENCE "public"."ref_modul_akses_ref_modul_akses_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for ref_user_akses_ref_user_akses_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."ref_user_akses_ref_user_akses_id_seq";
CREATE SEQUENCE "public"."ref_user_akses_ref_user_akses_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for ruta_ruta_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."ruta_ruta_id_seq";
CREATE SEQUENCE "public"."ruta_ruta_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for seq_berita_id
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."seq_berita_id";
CREATE SEQUENCE "public"."seq_berita_id" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for user_user_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_user_id_seq";
CREATE SEQUENCE "public"."user_user_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for berita
-- ----------------------------
DROP TABLE IF EXISTS "public"."berita";
CREATE TABLE "public"."berita" (
  "berita_id" int4 NOT NULL DEFAULT nextval('seq_berita_id'::regclass),
  "berita_judul" varchar(255) COLLATE "pg_catalog"."default",
  "berita_tanggal" date,
  "berita_konten" varchar(255) COLLATE "pg_catalog"."default",
  "berita_foto" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of berita
-- ----------------------------
INSERT INTO "public"."berita" VALUES (1, 'banjir', '2020-12-06', 'berita <br> banjir', 'foto1.jpg');

-- ----------------------------
-- Table structure for dinas
-- ----------------------------
DROP TABLE IF EXISTS "public"."dinas";
CREATE TABLE "public"."dinas" (
  "dinas_id" int4 NOT NULL,
  "dinas_nama" varchar(255) COLLATE "pg_catalog"."default",
  "dinas_logo" varchar(255) COLLATE "pg_catalog"."default",
  "dinas_link" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for gallery
-- ----------------------------
DROP TABLE IF EXISTS "public"."gallery";
CREATE TABLE "public"."gallery" (
  "gallery_id" int4 NOT NULL,
  "gallery_nama" varchar(255) COLLATE "pg_catalog"."default",
  "gallery_foto" varchar(255) COLLATE "pg_catalog"."default",
  "gallery_deskripsi" varchar(255) COLLATE "pg_catalog"."default",
  "kategori_id" int4
)
;

-- ----------------------------
-- Records of gallery
-- ----------------------------
INSERT INTO "public"."gallery" VALUES (1, 'Kegiatan 1', 'foto1.jpg', 'snsisjss', 1);
INSERT INTO "public"."gallery" VALUES (2, 'Event 1', 'foto1.jpg', 'snj jsn snj', 2);

-- ----------------------------
-- Table structure for gallery_kategori
-- ----------------------------
DROP TABLE IF EXISTS "public"."gallery_kategori";
CREATE TABLE "public"."gallery_kategori" (
  "gallery_kategori_id" int4 NOT NULL,
  "kategori_nama" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of gallery_kategori
-- ----------------------------
INSERT INTO "public"."gallery_kategori" VALUES (1, 'KEGIATAN');
INSERT INTO "public"."gallery_kategori" VALUES (2, 'EVENT');

-- ----------------------------
-- Table structure for informasi
-- ----------------------------
DROP TABLE IF EXISTS "public"."informasi";
CREATE TABLE "public"."informasi" (
  "informasi_id" int4 NOT NULL,
  "informasi_nama" varchar(255) COLLATE "pg_catalog"."default",
  "informasi_tanggal" date,
  "informasi_isi" varchar(255) COLLATE "pg_catalog"."default",
  "informasi_file" varchar(255) COLLATE "pg_catalog"."default",
  "informasi_foto" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of informasi
-- ----------------------------
INSERT INTO "public"."informasi" VALUES (2, '1', '2020-12-09', '1', '1.jpg', 'foto1.jpg');
INSERT INTO "public"."informasi" VALUES (1, '1', '2020-12-09', '1', '1.jpg', 'foto1.jpg');

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS "public"."karyawan";
CREATE TABLE "public"."karyawan" (
  "kar_id" int4 NOT NULL DEFAULT nextval('karyawan_kar_id_seq'::regclass),
  "kar_nama" varchar COLLATE "pg_catalog"."default",
  "kar_nip" varchar(255) COLLATE "pg_catalog"."default",
  "kar_pangkat" varchar(255) COLLATE "pg_catalog"."default",
  "kar_jabatan" varchar(255) COLLATE "pg_catalog"."default",
  "kar_created_at" timestamp(6),
  "kar_created_by" int4,
  "kar_visible" bool
)
;

-- ----------------------------
-- Table structure for kontak
-- ----------------------------
DROP TABLE IF EXISTS "public"."kontak";
CREATE TABLE "public"."kontak" (
  "kontak_id" int4 NOT NULL,
  "kontak_nama" varchar(255) COLLATE "pg_catalog"."default",
  "kontak_email" varchar(255) COLLATE "pg_catalog"."default",
  "kontak_telp" varchar(255) COLLATE "pg_catalog"."default",
  "kontak_pesan" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for layanan
-- ----------------------------
DROP TABLE IF EXISTS "public"."layanan";
CREATE TABLE "public"."layanan" (
  "layanan_id" int4 NOT NULL,
  "layanan_nama" varchar(255) COLLATE "pg_catalog"."default",
  "layanan_deskripsi" varchar(255) COLLATE "pg_catalog"."default",
  "layanan_foto" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of layanan
-- ----------------------------
INSERT INTO "public"."layanan" VALUES (1, 'SIDAMIS', 'SIDAMIS', 'foto1.jpg');

-- ----------------------------
-- Table structure for ref_group_akses
-- ----------------------------
DROP TABLE IF EXISTS "public"."ref_group_akses";
CREATE TABLE "public"."ref_group_akses" (
  "ref_group_akses_id" int4 NOT NULL DEFAULT nextval('ref_group_akses_ref_group_akses_id_seq'::regclass),
  "ref_group_akses_label" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for ref_modul_akses
-- ----------------------------
DROP TABLE IF EXISTS "public"."ref_modul_akses";
CREATE TABLE "public"."ref_modul_akses" (
  "ref_modul_akses_id" int4 NOT NULL DEFAULT nextval('ref_modul_akses_ref_modul_akses_id_seq'::regclass),
  "ref_modul_akses_label" varchar(255) COLLATE "pg_catalog"."default",
  "ref_modul_akses_group_id" int4
)
;

-- ----------------------------
-- Table structure for ref_user_akses
-- ----------------------------
DROP TABLE IF EXISTS "public"."ref_user_akses";
CREATE TABLE "public"."ref_user_akses" (
  "ref_user_akses_id" int4 NOT NULL DEFAULT nextval('ref_user_akses_ref_user_akses_id_seq'::regclass),
  "ref_user_akses_user_id" int4,
  "ref_user_akses_group_id" int4
)
;

-- ----------------------------
-- Table structure for ruta
-- ----------------------------
DROP TABLE IF EXISTS "public"."ruta";
CREATE TABLE "public"."ruta" (
  "ruta_id" int4 NOT NULL DEFAULT nextval('ruta_ruta_id_seq'::regclass),
  "ruta_tahun" int4 NOT NULL,
  "ruta_periode" int2,
  "ruta_id_bdt" int4,
  "ruta_kd_prop" int4,
  "ruta_kd_kab" int4,
  "ruta_kd_kec" int4,
  "ruta_kd_desa" int4,
  "ruta_alamat" varchar(255) COLLATE "pg_catalog"."default",
  "ruta_nama_sls" varchar(255) COLLATE "pg_catalog"."default",
  "ruta_nama_krt" varchar(255) COLLATE "pg_catalog"."default",
  "ruta_jumlah_art" int2,
  "ruta_jumlah_kk" int2,
  "ruta_sta_bangunan" int2,
  "ruta_luas_lantai" int2,
  "ruta_sta_lantai" int2,
  "ruta_sta_dinding" int2,
  "ruta_kondisi_dinding" int2,
  "ruta_sta_atap" int2,
  "ruta_kondisi_atap" int2,
  "ruta_jumlah_kamar" int2,
  "ruta_sumber_air_minum" int2,
  "ruta_nomor_meter_air" varchar(32) COLLATE "pg_catalog"."default",
  "ruta_cara_peroleh_air" int2,
  "ruta_sumber_penerangan" int2,
  "ruta_daya" int2,
  "ruta_nomor_pln" varchar(255) COLLATE "pg_catalog"."default",
  "ruta_bb_masak" int2
)
;

-- ----------------------------
-- Table structure for slide
-- ----------------------------
DROP TABLE IF EXISTS "public"."slide";
CREATE TABLE "public"."slide" (
  "slide_id" int4 NOT NULL,
  "slide_judul" varchar(255) COLLATE "pg_catalog"."default",
  "slide_tag" varchar(255) COLLATE "pg_catalog"."default",
  "slide_foto" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of slide
-- ----------------------------
INSERT INTO "public"."slide" VALUES (1, 'Slide 1', 'slide 1 merupakan ......', 'foto1.jpg');
INSERT INTO "public"."slide" VALUES (2, 'Slide 2', 'slide 2 merupakan ......', 'foto2.jpg');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS "public"."user";
CREATE TABLE "public"."user" (
  "user_id" int4 NOT NULL DEFAULT nextval('user_user_id_seq'::regclass),
  "user_name" varchar COLLATE "pg_catalog"."default",
  "user_password" varchar(255) COLLATE "pg_catalog"."default",
  "user_kar_id" int4,
  "user_disable" bool,
  "user_created_at" timestamp(6),
  "user_namalengkap" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO "public"."user" VALUES (1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 0, 'f', '2020-09-16 10:34:30.089515', 'Admin');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."karyawan_kar_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."ref_group_akses_ref_group_akses_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."ref_modul_akses_ref_modul_akses_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."ref_user_akses_ref_user_akses_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."ruta_ruta_id_seq"
OWNED BY "public"."ruta"."ruta_id";
SELECT setval('"public"."ruta_ruta_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."seq_berita_id"', 2, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."user_user_id_seq"', 2, false);

-- ----------------------------
-- Primary Key structure for table berita
-- ----------------------------
ALTER TABLE "public"."berita" ADD CONSTRAINT "berita_pkey" PRIMARY KEY ("berita_id");

-- ----------------------------
-- Primary Key structure for table dinas
-- ----------------------------
ALTER TABLE "public"."dinas" ADD CONSTRAINT "dinas_pkey" PRIMARY KEY ("dinas_id");

-- ----------------------------
-- Primary Key structure for table gallery
-- ----------------------------
ALTER TABLE "public"."gallery" ADD CONSTRAINT "gallery_pkey" PRIMARY KEY ("gallery_id");

-- ----------------------------
-- Primary Key structure for table gallery_kategori
-- ----------------------------
ALTER TABLE "public"."gallery_kategori" ADD CONSTRAINT "gallery_kategori_pkey" PRIMARY KEY ("gallery_kategori_id");

-- ----------------------------
-- Primary Key structure for table informasi
-- ----------------------------
ALTER TABLE "public"."informasi" ADD CONSTRAINT "informasi_pkey" PRIMARY KEY ("informasi_id");

-- ----------------------------
-- Primary Key structure for table karyawan
-- ----------------------------
ALTER TABLE "public"."karyawan" ADD CONSTRAINT "karyawan_pkey" PRIMARY KEY ("kar_id");

-- ----------------------------
-- Primary Key structure for table kontak
-- ----------------------------
ALTER TABLE "public"."kontak" ADD CONSTRAINT "kontak_pkey" PRIMARY KEY ("kontak_id");

-- ----------------------------
-- Primary Key structure for table layanan
-- ----------------------------
ALTER TABLE "public"."layanan" ADD CONSTRAINT "layanan_pkey" PRIMARY KEY ("layanan_id");

-- ----------------------------
-- Primary Key structure for table ref_group_akses
-- ----------------------------
ALTER TABLE "public"."ref_group_akses" ADD CONSTRAINT "ref_group_akses_pkey" PRIMARY KEY ("ref_group_akses_id");

-- ----------------------------
-- Primary Key structure for table ref_modul_akses
-- ----------------------------
ALTER TABLE "public"."ref_modul_akses" ADD CONSTRAINT "ref_modul_akses_pkey" PRIMARY KEY ("ref_modul_akses_id");

-- ----------------------------
-- Primary Key structure for table ref_user_akses
-- ----------------------------
ALTER TABLE "public"."ref_user_akses" ADD CONSTRAINT "ref_user_akses_pkey" PRIMARY KEY ("ref_user_akses_id");

-- ----------------------------
-- Primary Key structure for table ruta
-- ----------------------------
ALTER TABLE "public"."ruta" ADD CONSTRAINT "ruta_pkey" PRIMARY KEY ("ruta_id");

-- ----------------------------
-- Primary Key structure for table slide
-- ----------------------------
ALTER TABLE "public"."slide" ADD CONSTRAINT "slide_pkey" PRIMARY KEY ("slide_id");

-- ----------------------------
-- Primary Key structure for table user
-- ----------------------------
ALTER TABLE "public"."user" ADD CONSTRAINT "user_pkey" PRIMARY KEY ("user_id");