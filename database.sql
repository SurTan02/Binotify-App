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

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('admin', 'admin@brisic.com', '$2y$10$Ak.28BnV7LurDwQ6znkHI.wNxDn.x1V8wFK84BWZpEoqXYoXe9uU2', true);
--
-- PostgreSQL database dump complete
--
CREATE OR REPLACE FUNCTION on_song_update() RETURNS TRIGGER AS $song_update$
    BEGIN
		IF OLD.album_id IS NOT NULL THEN
			UPDATE album
			SET total_duration = total_duration - OLD.duration
			WHERE album.album_id = OLD.album_id;
		END IF;
		
		IF NEW.album_id IS NOT NULL THEN
			UPDATE album
			SET total_duration = total_duration + NEW.duration
			WHERE album.album_id = NEW.album_id;
		END IF;
    END;
$song_update$ LANGUAGE plpgsql;


CREATE OR REPLACE TRIGGER on_song_update AFTER UPDATE ON song
FOR EACH ROW EXECUTE FUNCTION on_song_update();

CREATE OR REPLACE FUNCTION on_song_insert() RETURNS TRIGGER AS $song_update$
    BEGIN
        IF NEW.album_id IS NOT NULL THEN
			UPDATE album
			SET total_duration = total_duration + NEW.duration
			WHERE album.album_id = NEW.album_id;
		END IF;
    END;
$song_update$ LANGUAGE plpgsql;


CREATE OR REPLACE TRIGGER on_song_insert AFTER INSERT ON song
FOR EACH ROW EXECUTE FUNCTION on_song_insert();

CREATE OR REPLACE FUNCTION on_song_delete() RETURNS TRIGGER AS $song_update$
    BEGIN
		IF OLD.album_id IS NOT NULL THEN
			UPDATE album
			SET total_duration = total_duration - OLD.duration
			WHERE album.album_id = OLD.album_id;
		END IF;
    END;
$song_update$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER on_song_delete AFTER DELETE ON song
FOR EACH ROW EXECUTE FUNCTION on_song_delete();