# Binotify REST Service

## DESCRIPTION

1. Seluruh pengguna harus melakukan autentikasi untuk dapat mengakses seluruh fitur lainnya. Hanya terdapat kategori admin dan penyanyi premium.
2. Admin dapat melakukan accept/reject permintaan subscribe dari pengguna dari binotify app.
3. Penyanyi dapat melakukan CRUD pada lagu-lagu yang dimilikinya.

## DATABASE SCHEMA

Berikut adalah skema basis data yang digunakan pada Tugas Besar ini:

1. Tabel User (user_id (PK), email, password, username, name, isAdmin )
2. Tabel Song (song_id (PK), judul, penyanyi_id, Audio_path)

## PEMBAGIAN TUGAS
1. DATABASE: 13520113
2. AUTENTIKASI: 13520113
3. CRUD LAGU PREMIUM: 13520059
4. GET LIST PENYANYI: 13520056
5. ENDPOINT UPLOAD FILE: 13520059
6. LIST LAGU PENYANYI: 13520059