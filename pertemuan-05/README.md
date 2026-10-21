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