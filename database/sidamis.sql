--
-- PostgreSQL database dump
--

-- Dumped from database version 10.5
-- Dumped by pg_dump version 10.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: karyawan_kar_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawan_kar_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.karyawan_kar_id_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: karyawan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.karyawan (
    kar_id integer DEFAULT nextval('public.karyawan_kar_id_seq'::regclass) NOT NULL,
    kar_nama character varying,
    kar_nip character varying(255),
    kar_pangkat character varying(255),
    kar_jabatan character varying(255),
    kar_created_at timestamp(6) without time zone,
    kar_created_by integer,
    kar_visible boolean
);


ALTER TABLE public.karyawan OWNER TO postgres;

--
-- Name: ref_group_akses_ref_group_akses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_group_akses_ref_group_akses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_group_akses_ref_group_akses_id_seq OWNER TO postgres;

--
-- Name: ref_group_akses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_group_akses (
    ref_group_akses_id integer DEFAULT nextval('public.ref_group_akses_ref_group_akses_id_seq'::regclass) NOT NULL,
    ref_group_akses_label character varying(255)
);


ALTER TABLE public.ref_group_akses OWNER TO postgres;

--
-- Name: ref_modul_akses_ref_modul_akses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_modul_akses_ref_modul_akses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_modul_akses_ref_modul_akses_id_seq OWNER TO postgres;

--
-- Name: ref_modul_akses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_modul_akses (
    ref_modul_akses_id integer DEFAULT nextval('public.ref_modul_akses_ref_modul_akses_id_seq'::regclass) NOT NULL,
    ref_modul_akses_label character varying(255),
    ref_modul_akses_group_id integer
);


ALTER TABLE public.ref_modul_akses OWNER TO postgres;

--
-- Name: ref_user_akses_ref_user_akses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_user_akses_ref_user_akses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_user_akses_ref_user_akses_id_seq OWNER TO postgres;

--
-- Name: ref_user_akses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_user_akses (
    ref_user_akses_id integer DEFAULT nextval('public.ref_user_akses_ref_user_akses_id_seq'::regclass) NOT NULL,
    ref_user_akses_user_id integer,
    ref_user_akses_group_id integer
);


ALTER TABLE public.ref_user_akses OWNER TO postgres;

--
-- Name: ruta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ruta (
    ruta_id integer NOT NULL,
    ruta_tahun integer NOT NULL,
    ruta_periode smallint,
    ruta_id_bdt integer,
    ruta_kd_prop integer,
    ruta_kd_kab integer,
    ruta_kd_kec integer,
    ruta_kd_desa integer,
    ruta_alamat character varying(255),
    ruta_nama_sls character varying(255),
    ruta_nama_krt character varying(255),
    ruta_jumlah_art smallint,
    ruta_jumlah_kk smallint,
    ruta_sta_bangunan smallint,
    ruta_luas_lantai smallint,
    ruta_sta_lantai smallint,
    ruta_sta_dinding smallint,
    ruta_kondisi_dinding smallint,
    ruta_sta_atap smallint,
    ruta_kondisi_atap smallint,
    ruta_jumlah_kamar smallint,
    ruta_sumber_air_minum smallint,
    ruta_nomor_meter_air character varying(32),
    ruta_cara_peroleh_air smallint,
    ruta_sumber_penerangan smallint,
    ruta_daya smallint,
    ruta_nomor_pln character varying(255),
    ruta_bb_masak smallint
);


ALTER TABLE public.ruta OWNER TO postgres;

--
-- Name: ruta_ruta_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ruta_ruta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ruta_ruta_id_seq OWNER TO postgres;

--
-- Name: ruta_ruta_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ruta_ruta_id_seq OWNED BY public.ruta.ruta_id;


--
-- Name: user_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_user_id_seq OWNER TO postgres;

--
-- Name: user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."user" (
    user_id integer DEFAULT nextval('public.user_user_id_seq'::regclass) NOT NULL,
    user_name character varying,
    user_password character varying(255),
    user_kar_id integer,
    user_disable boolean,
    user_created_at timestamp(6) without time zone,
    user_namalengkap character varying(255)
);


ALTER TABLE public."user" OWNER TO postgres;

--
-- Name: ruta ruta_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruta ALTER COLUMN ruta_id SET DEFAULT nextval('public.ruta_ruta_id_seq'::regclass);


--
-- Data for Name: karyawan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.karyawan (kar_id, kar_nama, kar_nip, kar_pangkat, kar_jabatan, kar_created_at, kar_created_by, kar_visible) FROM stdin;
\.


--
-- Data for Name: ref_group_akses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_group_akses (ref_group_akses_id, ref_group_akses_label) FROM stdin;
\.


--
-- Data for Name: ref_modul_akses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_modul_akses (ref_modul_akses_id, ref_modul_akses_label, ref_modul_akses_group_id) FROM stdin;
\.


--
-- Data for Name: ref_user_akses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_user_akses (ref_user_akses_id, ref_user_akses_user_id, ref_user_akses_group_id) FROM stdin;
\.


--
-- Data for Name: ruta; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ruta (ruta_id, ruta_tahun, ruta_periode, ruta_id_bdt, ruta_kd_prop, ruta_kd_kab, ruta_kd_kec, ruta_kd_desa, ruta_alamat, ruta_nama_sls, ruta_nama_krt, ruta_jumlah_art, ruta_jumlah_kk, ruta_sta_bangunan, ruta_luas_lantai, ruta_sta_lantai, ruta_sta_dinding, ruta_kondisi_dinding, ruta_sta_atap, ruta_kondisi_atap, ruta_jumlah_kamar, ruta_sumber_air_minum, ruta_nomor_meter_air, ruta_cara_peroleh_air, ruta_sumber_penerangan, ruta_daya, ruta_nomor_pln, ruta_bb_masak) FROM stdin;
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."user" (user_id, user_name, user_password, user_kar_id, user_disable, user_created_at, user_namalengkap) FROM stdin;
1	admin	d033e22ae348aeb5660fc2140aec35850c4da997	0	f	2020-09-16 10:34:30.089515	Admin
\.


--
-- Name: karyawan_kar_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_kar_id_seq', 1, false);


--
-- Name: ref_group_akses_ref_group_akses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_group_akses_ref_group_akses_id_seq', 1, false);


--
-- Name: ref_modul_akses_ref_modul_akses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_modul_akses_ref_modul_akses_id_seq', 1, false);


--
-- Name: ref_user_akses_ref_user_akses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_user_akses_ref_user_akses_id_seq', 1, false);


--
-- Name: ruta_ruta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ruta_ruta_id_seq', 1, false);


--
-- Name: user_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_user_id_seq', 1, false);


--
-- Name: karyawan karyawan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.karyawan
    ADD CONSTRAINT karyawan_pkey PRIMARY KEY (kar_id);


--
-- Name: ref_group_akses ref_group_akses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_group_akses
    ADD CONSTRAINT ref_group_akses_pkey PRIMARY KEY (ref_group_akses_id);


--
-- Name: ref_modul_akses ref_modul_akses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_modul_akses
    ADD CONSTRAINT ref_modul_akses_pkey PRIMARY KEY (ref_modul_akses_id);


--
-- Name: ref_user_akses ref_user_akses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_user_akses
    ADD CONSTRAINT ref_user_akses_pkey PRIMARY KEY (ref_user_akses_id);


--
-- Name: ruta ruta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruta
    ADD CONSTRAINT ruta_pkey PRIMARY KEY (ruta_id);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (user_id);


--
-- PostgreSQL database dump complete
--

