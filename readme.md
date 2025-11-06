# Sistem Manajemen Penjualan - Ayam Geprek Mas Ucok

Proyek ini adalah aplikasi web sederhana yang dibangun menggunakan PHP native dan MySQL untuk mengelola dan mencatat penjualan di sebuah usaha kuliner ayam geprek.

## Fitur Utama

  * **Autentikasi Pengguna**: Sistem login dan logout yang aman untuk melindungi data.
  * **Dashboard**: Menampilkan ringkasan statistik penjualan hari ini, termasuk total pendapatan, total item terjual, dan jumlah jenis menu yang terjual.
  * **Input Penjualan**: Halaman formulir untuk menginput data penjualan baru. Daftar menu diambil langsung dari database, dan total harga diperbarui secara dinamis menggunakan JavaScript.
  * **Rekap Penjualan**: Laporan penjualan yang dapat difilter berdasarkan harian, bulanan, atau tahunan.
  * **Export ke Excel**: Fungsi sederhana untuk mengekspor data laporan penjualan di halaman rekap ke dalam format file `.xls`.

## Teknologi yang Digunakan

  * **Backend**: PHP (Native)
  * **Database**: MySQL
  * **Frontend**: HTML, CSS, JavaScript
  * **Framework/Library**: Bootstrap 5

## Cara Instalasi dan Setup

Untuk menjalankan proyek ini di lingkungan lokal (misalnya menggunakan XAMPP):

1.  **Clone atau Download Proyek**
    Unduh atau clone semua file proyek ini ke dalam satu folder.

2.  **Pindahkan Folder Proyek**
    Pindahkan folder proyek tersebut ke dalam direktori web server Anda (misalnya `C:/xampp/htdocs/`).

3.  **Setup Database**

      * Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
      * Buat database baru dengan nama `ayam_geprek`.
      * Pilih database `ayam_geprek` tersebut, lalu pergi ke tab **Import**.
      * Impor file `database.sql` (file ini harus ada di dalam proyek Anda) untuk membuat semua tabel yang diperlukan (`users`, `menu`, `penjualan`) dan mengisi data awal.

4.  **Konfigurasi Koneksi**

      * Buka file `config/database.php`.
      * Pastikan pengaturan `DB_HOST`, `DB_USER`, `DB_PASS`, dan `DB_NAME` sudah sesuai dengan pengaturan server MySQL Anda.

    <!-- end list -->

    ```php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', ''); // Sesuaikan jika MySQL Anda menggunakan password
    define('DB_NAME', 'ayam_geprek');
    ```

5.  **Jalankan Aplikasi**

      * Pastikan server Apache dan MySQL Anda berjalan (melalui XAMPP Control Panel).
      * Buka browser dan akses proyek melalui URL: `http://localhost/[NAMA_FOLDER_PROYEK]/`
      * Contoh: `http://localhost/ayam-geprek-mas-ucok/`
      * Anda akan otomatis diarahkan ke halaman login.

## Cara Penggunaan

1.  **Login**
    Gunakan kredensial demo yang tersedia di halaman login untuk masuk:

      * **Username**: `admin`
      * **Password**: `admin123`

2.  **Navigasi**

      * **Dashboard**: Halaman utama setelah login, menampilkan ringkasan hari ini.
      * **Input Penjualan**: Klik tombol "Input Penjualan" untuk masuk ke halaman formulir pencatatan penjualan.
      * **Lihat Rekap**: Klik tombol "Lihat Rekap" untuk melihat laporan penjualan.
