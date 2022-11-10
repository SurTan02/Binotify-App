# Brisic

## Deskripsi Aplikasi Web

Brisic (Brianaldo's Music) adalah suatu aplikasi berbasis web untuk mendengarkan musik. Pengguna dibedakan menjadi 3 kategori, yaitu
pengguna tidak terautentikasi(selanjutnya disebut <b>guest</b>), pengguna terautentikasi (selanjutnya disebut <b>user</b>), dan juga <b>admin</b>.

| Aktivitas             | Guest | User | Admin |
| :-------------------- | :---: | :--: | :---: |
| Melakukan Login       |  ✅   |  ✅  |  ✅   |
| Melakukan Register    |  ✅   |  ✅  |  ❌   |
| Mendengarkan Lagu     |  ⭕   |  ✅  |  ✅   |
| Melihat Detail Lagu   |  ✅   |  ✅  |  ✅   |
| Mengubah Detail Lagu  |  ❌   |  ❌  |  ✅   |
| Menambah lagu         |  ❌   |  ❌  |  ✅   |
| Menghapus lagu        |  ❌   |  ❌  |  ✅   |
| Melihat Detail Album  |  ✅   |  ✅  |  ✅   |
| Menambah Album        |  ❌   |  ❌  |  ✅   |
| Mengubah Detail Album |  ❌   |  ❌  |  ✅   |
| Menghapus Album       |  ❌   |  ❌  |  ✅   |
| Mencari Lagu          |  ✅   |  ✅  |  ✅   |
| Sortir lagu           |  ✅   |  ✅  |  ✅   |
| Filter Genre          |  ✅   |  ✅  |  ✅   |
| Melihat Daftar User   |  ❌   |  ❌  |  ✅   |

⭕ = Terbatas 3 Lagu perhari

## Daftar Requirement

- Docker
- Web Browser

## Cara Instalasi

1. Pull Repository ini
2. Aktifkan Docker Server
3. Masuk ke directory tugas ini
   ```bash
   cd tugas-besar-1
   ```
4. Setup environment variables dengan cara mengisi .env.example dan hapus .example pada nama file
5. Ketikkan
   ```bash
   docker-compose up --build
   ```

## Cara Menjalankan Server

1. Ketikkan
   ```bash
   docker-compose up
   ```
2. Buka Browser di http://localhost:8008/

## Screenshot

1. Halaman Login
   ![Login Page](./image/login.png)

2. Halaman Register
   ![Register Page](./image/register.png)

3. Halaman Home
   ![Home Page](./image/home.png)

4. Halaman Daftar Album
   ![Daftar Album Page](./image/daftar_album.png)

5. Halaman Search, Sort, Filter
   ![Search, Sort, Filter Page](./image/search.png)

6. Halaman Detail Lagu
   ![Detail Lagu Page](./image/detail_lagu.png)

7. Halaman Detail Lagu Guest User Terkena Limit
   ![Limit Page](./image/limit.png)

8. Halaman Edit Lagu  
   ![Edit Lagu Page](./image/edit_lagu.png)

9. Halaman Detail Album  
   ![Edit Album Page](./image/detail_album.png)

10. Halaman Tambah Lagu  
    ![Tambah Lagu Page](./image/tambah_lagu.png)

11. Halaman Tambah Lagu  
    ![Tambah Album Page](./image/tambah_album.png)

12. Halaman Daftar User  
    ![Daftar User Page](./image/daftar_user.png)

13. Halaman 404  
    ![404 Page](./image/404.png)

## Pembagian Tugas

### Server-side

1. Login : 13520056
2. Register : 13520056
3. Home : 13520059
4. Daftar Album : 13520113
5. Search, Sort, dan Filter : 13520113
6. Detail Lagu : 13520059
7. Detail Album : 13520113
8. Tambah Album : 13520059
9. Tambah Lagu : 13520059
10. Daftar User : 13520056

### Client-side

1. Login &nbsp; : 13520056
2. Register : 13520056
3. Home : 13520056, 13520113
4. Daftar Album : 13520113
5. Search, Sort, dan Filter : 13520113
6. Detail Lagu : 13520059, 13520056
7. Detail Album : 13520113
8. Tambah Album : 13520059, 13520056
9. Tambah Lagu : 13520059, 13520056
10. Daftar User : 13520056
11. Halaman 404 : 13520056
12. Navbar : 13520056

### Note

- Akun Admin :
  - Username : admin
  - Password : admin
