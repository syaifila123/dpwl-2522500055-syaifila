# Tugas pertemuan-02

## 1. Tujuan Praktikum 
JAWABAN : 
* Memahami dan membangun arsitektur dasar MVC (Model-View-Controller) tanpa framework luar.
* Memahami peran index.php sebagai titik masuk utama aplikasi (Front Controller).
* Mengimplementasikan sistem routing untuk memetakan alamat URL ke Controller, method, parameter, dan View.
* Menggunakan fungsi helper base_url() untuk memanggil berkas aset (CSS/JS) dan site_url() untuk tautan navigasi halaman.


## 2. Struktur Direktori
  JAWABAN :
  dpwl-2522500055/
├── application/
│   ├── config/
│   │   ├── config.php      (Menyimpan konfigurasi dasar seperti Base URL)
│   │   └── routes.php      (Aturan pemetaan URL ke Controller)
│   ├── controllers/
│   │   └── Home.php        (Controller utama untuk menangani logika halaman)
│   ├── helpers/
│   │   └── url_helper.php  (Menyediakan fungsi base_url() dan site_url())
│   └── views/
│       └── home/
│           ├── index.php   (Tampilan halaman utama)
│           └── info.php    (Tampilan halaman informasi/routing)
├── assets/
│   └── css/
│       └── app.css         (Berkas gaya CSS aplikasi)
├── system/
│   └── core/
│       ├── Controller.php  (Base Controller / class induk)
│       └── Router.php      (Pengolah logika routing URL)
└── index.php               (Front Controller / pintu masuk utama)


## 3. Front controller 
JAWABAN :
index.php bertindak sebagai pintu masuk utama (Front Controller) bagi seluruh request dinamis aplikasi. Semua alamat URL yang diakses oleh pengguna harus melewati index.php terlebih dahulu. Di dalam file ini, sistem memuat konfigurasi, fungsi helper, Base Controller, dan Router sebelum akhirnya menentukan Controller mana yang harus dipanggil untuk memproses permintaan


## 4. Routing dan Pemetaan URL
JAWABAN :
 | URL/Route | Controller | Method | Parameter | View | |---|---|---|---|---| | / | Home | index | - | home/index.php | | home/index | Home | index | - | home/index.php | | home/info/mvc | Home | info | mvc | home/info.php | | info/routing | Home | info | routing | home/info.php |  | mahasiswa/detail/2522500055 | Mahasiswa | detail | 2522500055 | mahasiswa/detail.php
* PENJELASAN :
* URL / Route: User mengakses URL index.php/mahasiswa/detail/2522500055.
* Controller: Router membaca aturan dan memanggil Controller Mahasiswa.
* Method: Memanggil fungsi/method detail() yang ada di dalam Controller Mahasiswa.
* Parameter: Mengirimkan argumen "2522500055" sebagai ID mahasiswa ke method detail($id).
* View: Method detail() memproses permintaan lalu menampilkan berkas tampilan views/mahasiswa/detail.php.

## 5. Base URL dan Helper 
JAWABAN :
Penggunaan base_url() dan site_url() bertujuan agar jalur (URL) aplikasi bersifat dinamis dan tidak hard-coded, sehingga aplikasi tidak patah/rusak saat dipindahkan antar-lingkungan (environment) atau folder.   

base_url(): Mengembalikan URL dasar dari aplikasi ke akar direktori (termasuk folder assets).

• Contoh penggunaan memanggil CSS:
<link rel="stylesheet" href="<?= base_url('assets/css/app.css'); ?>">

site_url(): Mengembalikan URL lengkap yang menyertakan rute aplikasi/index.php untuk navigasi antar-halaman.   

• Contoh penggunaan navigasi route:
<a href="<?= site_url('info/routing'); ?>">Lihat Info Routing</a>

## 6. Alur Request-response 
JAWABAN :
   1. Alur eksekusi aktual P2:
    Browser → index.php → Router → Controller → View Response.
    * PENJELASAN :
    Permintaan masuk dari Browser ke index.php (Front Controller), diteruskan ke Router untuk dicocokkan rutenya, Controller mengeksekusi logika yang sesuai, memuat berkas View, lalu mengembalikan hasil rendernya sebagai Response ke peramban 
   2. Posisi Model dalam arsitektur MVC lengkap:
    Browser → index.php → Router → Controller → Model → basis data/data → Model → Controller → View → Response
    * PENJELASAN :
    Pada implementasi P2, Model belum digunakan karena akses dan pengelolaan basis data mulai diimplementasikan pada P3. 

## 7. Hasil Pengujian dan Debugging 
JAWABAN :
ditemukan kesalahan selama implementasi.

* Gejala:
Saat menjalankan perintah `php -1 index.php` di terminal VS Code, muncul error `php: The term 'php' is not recognized as the name of a cmdlet...` (CommandNotFoundException).

Penyebab:
* Windows belum mengenali  perintah `php karena path folder PHP dari Laragon belum didaftar ke System Environment Variables (PAΤΗ).

* Perbaikan:
Menambahkan path folder PHP Laragon (`C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64`) ke PATH Windows, terus restart VS Code supaya jalurnya terbaca.

* Hasil Uji Ulang:
Perintah `php-1` buat semua berkas berhasil dijalankan dan keluar respon No syntax errors detected in [nama_file]`.

## 8. Bukti Tangkapan Layar
### Gambar 1. Hasil Pengujian Halaman Utama  
![Gambar 1 - Halaman Utama](pertemuan-02/dpwl-2522500055/dokumentasi/gambar1.png.png)

### Gambar 2. Hasil Pengujian Custom Route  
![Gambar 2 - Custom Route](pertemuan-02/dpwl-2522500055/dokumentasi/gambar2.png.png)  

## 9. Kesimpulan P2 
Pada materi **P2**, kerangka aplikasi MVC buatan sendiri telah berhasil dibuat dan berfungsi untuk menangani *satu titik masuk (front controller)*, memproses *routing/pemetaan URL*, mengalirkan data dari *Controller* ke *View*, serta menggunakan *URL Helper* 

Hal yang belum ada di P2 dan **baru akan ditambahkan pada P3** adalah komponen **Model**, koneksi ke database MySQL menggunakan MySQLi/prepared statement, mekanisme autentikasi & sesi (login), kontrol hak akses, serta integrasi antarmuka template AdminLTE