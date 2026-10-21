# Dokumentasi Pertemuan 05 - Pengelolaan Data Master Objek Bisnis dengan MVC

**Nama:** Syaifila Wulandari  
**NIM:** 2522500055  
**Mata Kuliah:** Desain dan Pemrograman Web Lanjutan  

---

## Tahap A: Menambahkan Menu Manajemen Kendaraan

### 1. Deskripsi Perubahan
Pada tahap ini, dilakukan penambahan menu navigasi baru yaitu **Manajemen Kendaraan** pada antarmuka admin untuk mengakses pengelolaan data mobil.

### 2. Berkas yang Diubah / Terdampak
- `application/views/templates/sidebar.php`  
  Menambahkan elemen menu baru **Manajemen Kendaraan** tepat di bawah menu *Manajemen Admin*.
- `application/config/routes.php`  
  Menambahkan konfigurasi route baru `$route['admin/mobil'] = 'Mobil_controller/index';` untuk mengarahkan URL `admin/mobil` ke controller `Mobil_controller`.

### 3. Hasil Pengujian
- **Tampilan Navigasi:** Menu *Manajemen Kendaraan* berhasil tampil di sidebar di bawah menu *Manajemen Admin*.
- **Navigasi URL:** Saat menu diklik, URL pada peramban berubah menjadi `admin/mobil`.
- **Kondisi Tampilan:** Halaman menampilkan pesan *"Controller tidak ditemukan."* Hal ini merupakan kondisi yang diharapkan karena berkas `Mobil_controller.php` belum dibuat (akan dibuat pada tahap berikutnya).

---

## Tahap B: Menambahkan Route Manajemen Kendaraan

### 1. Deskripsi Perubahan
Pada tahap ini, dilakukan penambahan konfigurasi route pada aplikasi untuk mendukung operasi penambahan (CREATE), pengubahan (UPDATE), dan penghapusan (DELETE) data kendaraan.

### 2. Berkas yang Diubah / Terdampak
- `application/config/routes.php`  
  Menambahkan 3 konfigurasi route baru di bawah route `admin/mobil`:
  - `$route['admin/mobil/tambah'] = 'Mobil_controller/tambah';`
  - `$route['admin/mobil/ubah/(:any)'] = 'Mobil_controller/ubah/$1';`
  - `$route['admin/mobil/hapus/(:any)'] = 'Mobil_controller/hapus/$1';`

### 3. Hasil Pengujian
- **Pengujian Route:** Saat mengakses URL `admin/mobil/tambah`, `admin/mobil/ubah/BN1234XX`, maupun `admin/mobil/hapus/BN1234XX`, sistem menampilkan pesan *"Controller tidak ditemukan."*
- **Kondisi:** Pesan tersebut merupakan kondisi yang diharapkan (*expected behavior*) karena `Mobil_controller.php` baru akan diimplementasikan pada Tahap C.

---

## Tahap C: Mengimplementasikan READ Data Kendaraan dengan MVC

### 1. Deskripsi Perubahan
Pada tahap ini, dilakukan implementasi operasi **READ** untuk membaca dan menampilkan daftar data kendaraan dari tabel `t_mobil` menggunakan arsitektur MVC (Model-View-Controller).

### 2. Berkas yang Diubah / Ditambahkan
- **`application/models/Mobil_model.php`** (Berkas Baru):  
  Dibuat untuk menangani kueri ke basis data. Menambahkan method `getAll()` yang menjalankan SQL `SELECT` pada tabel `t_mobil` terurut berdasarkan `no_plat ASC`.
- **`application/controllers/Mobil_controller.php`** (Berkas Baru):  
  Dibuat untuk mengatur alur logika. Menambahkan method `index()` yang memuat helper autentikasi/flash, memanggil `Mobil_model->getAll()`, dan meneruskan datanya ke View.
- **`application/views/admin/mobil_view.php`** (Berkas Baru):  
  Dibuat untuk menampilkan antarmuka halaman admin/mobil. Berisi tabel HTML (menggunakan DataTables) yang menampilkan detail kendaraan (nomor plat, nama, kursi, bagasi, jenis, transmisi, tahun, harga, status, foto depan, serta tombol aksi CRUD).

### 3. Hasil Pengujian
- **Akses Halaman:** Saat membuka URL `admin/mobil` melalui browser, halaman *Manajemen Kendaraan* berhasil dimuat tanpa galat.
- **Penyajian Data:** Data kendaraan dari tabel `t_mobil` tampil secara akurat pada tabel antarmuka sesuai dengan data di MySQL (phpMyAdmin).
- **Tampilan Tabel Kosong:** Halaman tetap beroperasi dengan normal dan menampilkan pesan bahwa data belum tersedia jika tabel `t_mobil` dalam kondisi kosong.
- **Keamanan & Integrasi Fitur:** Akses halaman terlindungi oleh autentikasi admin (`require_admin_login()`) dan tidak mengganggu fitur dari Pertemuan 04 (Manajemen Admin).