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