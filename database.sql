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
-- Name: on_song_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.on_song_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    BEGIN
		IF OLD.album_id IS NOT NULL THEN
			UPDATE public.album
			SET total_duration = total_duration - OLD.duration
			WHERE album.album_id = OLD.album_id;
		END IF;
        
        RETURN NULL;
    END;
$$;


ALTER FUNCTION public.on_song_delete() OWNER TO postgres;

--
-- Name: on_song_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.on_song_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    BEGIN
        IF NEW.album_id IS NOT NULL THEN
			UPDATE public.album
			SET total_duration = total_duration + NEW.duration
			WHERE album.album_id = NEW.album_id;
		END IF;

        RETURN NULL;
    END;
$$;


ALTER FUNCTION public.on_song_insert() OWNER TO postgres;

--
-- Name: on_song_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.on_song_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    BEGIN
		IF OLD.album_id IS NOT NULL THEN
			UPDATE public.album
			SET total_duration = total_duration - OLD.duration
			WHERE album.album_id = OLD.album_id;
		END IF;
		
		IF NEW.album_id IS NOT NULL THEN
			UPDATE public.album
			SET total_duration = total_duration + NEW.duration
			WHERE album.album_id = NEW.album_id;
		END IF;

        RETURN NULL;
    END;
$$;


ALTER FUNCTION public.on_song_update() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: album; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.album (
    album_id SERIAL NOT NULL,
    judul character varying(64) NOT NULL,
    penyanyi character varying(128) NOT NULL,
    total_duration integer NOT NULL DEFAULT 0,
    image_path character varying(256) NOT NULL,
    tanggal_terbit date NOT NULL,
    genre character varying(64)
);


ALTER TABLE public.Album OWNER TO postgres;

--
-- Name: song; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.song (
    song_id SERIAL NOT NULL,
    judul character varying(64) NOT NULL,
    penyanyi character varying(128),
    tanggal_terbit date NOT NULL,
    genre character varying(64),
    duration integer NOT NULL,
    audio_path character varying(256) NOT NULL,
    image_path character varying(256) NOT NULL,
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

CREATE TYPE public.statusenum AS ENUM ('PENDING', 'ACCEPTED', 'REJECTED');

CREATE TABLE public.subscription (
    creator_id integer NOT NULL,
    subscriber_id integer NOT NULL,
    status public.statusenum DEFAULT 'PENDING' NOT NULL
);


ALTER TABLE public.user OWNER TO postgres;

--
-- Name: album Album_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.album
    ADD CONSTRAINT "Album_pkey" PRIMARY KEY (album_id);


--
-- Name: user User_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user
    ADD CONSTRAINT "User_pkey" PRIMARY KEY (user_id);

ALTER TABLE ONLY public.user
    ADD CONSTRAINT "User_unique" UNIQUE (username);
    
--
-- Name: song fk_album_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.song
    ADD CONSTRAINT "Song_pkey" PRIMARY KEY (song_id);

--
-- Name: song on_song_delete; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER on_song_delete AFTER DELETE ON public.song FOR EACH ROW EXECUTE FUNCTION public.on_song_delete();


--
-- Name: song on_song_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER on_song_insert AFTER INSERT ON public.song FOR EACH ROW EXECUTE FUNCTION public.on_song_insert();


--
-- Name: song on_song_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER on_song_update AFTER UPDATE ON public.song FOR EACH ROW EXECUTE FUNCTION public.on_song_update();



ALTER TABLE public.subscription OWNER TO postgres;

ALTER TABLE ONLY public.subscription
    ADD CONSTRAINT subscription_pkey PRIMARY KEY (creator_id, subscriber_id);

ALTER TABLE ONLY public.subscription
    ADD CONSTRAINT fk_subscriber_id FOREIGN KEY (subscriber_id) REFERENCES public.user(user_id) ON DELETE SET NULL;

--
-- Name: song fk_album_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.Song
    ADD CONSTRAINT fk_album_id FOREIGN KEY (album_id) REFERENCES public.Album(album_id) ON DELETE SET NULL;

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('admin', 'admin@brisic.com', '$2y$10$Ak.28BnV7LurDwQ6znkHI.wNxDn.x1V8wFK84BWZpEoqXYoXe9uU2', true);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('brianaldo', 'brianaldo@brisic.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', true);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('suryanto', 'suryanto@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', true);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('fikrikhoironn', 'fikrikf470@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', true);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('viel', 'viel@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', false);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('cello', 'cello@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', false);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('dian', 'dian@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', false);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('doni', 'doni@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', false);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('dwi', 'dwi@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', false);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('fikri', 'fikri@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', false);

INSERT INTO public.user (username, email, password, isAdmin) VALUES ('firdaus', 'firdaus@gmail.com', '$2y$10$21OxUj8OiYONDvBAKFBJk.uSrgLvqU6Xz0Pk2trqxxeil2kQzeWV6', false);

INSERT INTO public.album (judul, penyanyi, image_path, tanggal_terbit, genre) 
    VALUES ('Manusia', 'Tulus', '/view/assets/img/album_manusia.jpeg', '2022-09-10', 'Pop');
INSERT INTO public.album (judul, penyanyi, image_path, tanggal_terbit, genre) 
    VALUES ('Bohemian Rhapsody', 'Queen', '/view/assets/img/album_bohemian-rhapsody.jpeg', '2017-09-10', 'Rock');
INSERT INTO public.album (judul, penyanyi, image_path, tanggal_terbit, genre) 
    VALUES ('Monokrom', 'Tulus', '/view/assets/img/album_monokrom.jpeg', '2019-09-10', 'Metal');
INSERT INTO public.album (judul, penyanyi, image_path, tanggal_terbit, genre) 
    VALUES ('The Book', 'YOASOBI', '/view/assets/img/album_the-book.jpeg', '2021-09-10', 'Hip-hop');
INSERT INTO public.album (judul, penyanyi, image_path, tanggal_terbit, genre) 
    VALUES ('Rubik', 'Dere', '/view/assets/img/album_rubik.jpeg', '2022-09-10', 'Hip-hop');

INSERT INTO public.song (Judul, Penyanyi, Tanggal_terbit, duration, album_id, Genre, Audio_path, Image_path) VALUES (
'Diri', 'Tulus', '2015-09-10', 1094, 1, 'Pop', '/view/assets/song/diri.mp3', '/view/assets/img/album_manusia.jpeg');

INSERT INTO public.song (Judul, Penyanyi, Tanggal_terbit, duration, album_id, Genre, Audio_path, Image_path) VALUES (
'Hati Hati Di Jalan', 'Tulus', '2019-09-10', 647, 1, 'Pop', '/view/assets/song/Hati Hati di Jalan.mp3', '/view/assets/img/album_manusia.jpeg');

INSERT INTO public.song (Judul, Penyanyi, Tanggal_terbit, duration,  Genre, Audio_path, Image_path) VALUES (
'Satu Kali', 'Tulus', '2021-09-10', 981,  'Dangdut', '/view/assets/song/Satu Kali.mp3', '/view/assets/img/album_manusia.jpeg');

INSERT INTO public.song (Judul, Penyanyi, Tanggal_terbit, duration, album_id, Genre, Audio_path, Image_path) VALUES (
'Dont Stop Me Now', 'Queen', '1990-09-10', 479, 2, 'Metal', '/view/assets/song/Dont Stop Me Now.mp3', '/view/assets/img/album_bohemian-rhapsody.jpeg');
--
-- PostgreSQL database dump complete
--
