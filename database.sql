--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5
-- Dumped by pg_dump version 14.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: Album; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.Album (
    album_id SERIAL NOT NULL,
    Judul character varying(64) NOT NULL,
    Penyanyi character varying(128) NOT NULL,
    Total_duration integer NOT NULL,
    Image_path character varying(256) NOT NULL,
    Tanggal_Terbit date NOT NULL,
    Genre character varying(64)
);


ALTER TABLE public.Album OWNER TO postgres;

--
-- Name: Song; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.Song (
    song_id SERIAL NOT NULL,
    Judul character varying(64) NOT NULL,
    Penyanyi character varying(128),
    Tanggal_terbit date NOT NULL,
    Genre character varying(64),
    Duration integer NOT NULL,
    Audio_path character varying(256) NOT NULL,
    Image_path character varying(256) NOT NULL,
    album_id integer
);


ALTER TABLE public.Song OWNER TO postgres;

--
-- Name: user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user (
    user_id SERIAL NOT NULL,
    email character varying(256) NOT NULL,
    password character varying(256) NOT NULL,
    username character varying(256) NOT NULL,
    isAdmin boolean DEFAULT false NOT NULL
);


ALTER TABLE public.user OWNER TO postgres;

--
-- Data for Name: Album; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.Album (album_id, Judul, Penyanyi, Total_duration, Image_path, Tanggal_Terbit, Genre) FROM stdin;
\.


--
-- Data for Name: Song; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.Song (song_id, Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path, album_id) FROM stdin;
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user (user_id, email, password, username, isAdmin) FROM stdin;
1	admin@gmail.com	sayaadmin	admin	t
\.


--
-- Name: Album Album_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.Album
    ADD CONSTRAINT "Album_pkey" PRIMARY KEY (album_id);


--
-- Name: user User_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user
    ADD CONSTRAINT "User_pkey" PRIMARY KEY (user_id);


--
-- Name: Song fk_album_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.Song
    ADD CONSTRAINT fk_album_id FOREIGN KEY (album_id) REFERENCES public.Album(album_id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

