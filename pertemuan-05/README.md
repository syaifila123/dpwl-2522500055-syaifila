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

# Dokumentasi Pertemuan 05: Pengelolaan Data Master Objek Bisnis dengan MVC (Bagian INSERT/CREATE)

## Deskripsi Singkat
Pada tahap ini, dilakukan implementasi fitur **INSERT (Tambah Data Kendaraan)** pada aplikasi rental mobil berbasis MVC tanpa framework. Fitur ini memungkinkan admin untuk menambahkan data kendaraan baru beserta unggahan foto kendaraan ke dalam basis data.

---

## Perubahan Berkas (Files Changed)
1. **`application/models/Mobil_model.php`**
   - Menambahkan method `create(array $data)` untuk menyimpan record data kendaraan baru ke dalam tabel `t_mobil` menggunakan *prepared statement* (`bind_param`).

2. **`application/controllers/Mobil_controller.php`**
   - Menambahkan method `tambah()` untuk menangani *request* GET (menampilkan form) dan POST (memproses data input).
   - Menambahkan method pendukung `validateMobilInput()` untuk validasi server-side.
   - Menambahkan method `uploadFoto()` untuk menangani proses unggah foto (JPEG, PNG, WEBP max 5MB).
   - Menambahkan method `hapusFotoBaru()` untuk membersihkan file foto baru jika proses simpan data ke basis data gagal.
   - Mengimplementasikan pola **Post/Redirect/Get (PRG)** menggunakan `set_flash_message()` saat penyimpanan berhasil.

3. **`application/views/admin/mobil_view.php`**
   - Menambahkan formulir input data kendaraan (Nomor Plat, Nama Mobil, Jumlah Kursi, Bagasi, Jenis Mobil, Transmisi, Tahun, Harga, Catatan, Status, dan Upload Foto).
   - Menambahkan JavaScript untuk fitur *live preview* gambar saat memilih file foto.

---

## Alur Implementasi INSERT
1. **Pemeriksaan Hak Akses & Metode HTTP:** Method `tambah()` memastikan admin telah login (`require_admin_login()`).
2. **Validasi Input:** Memeriksa kelengkapan data, tipe data, rentang nilai, serta batas karakter sesuai skema basis data.
3. **Pengolahan Foto:** Memproses unggahan foto depan, belakang, dan interior. Jika valid, file disimpan ke direktori `uploads/mobil/`.
4. **Penyimpanan Data:** Memanggil `Mobil_model->create()` dengan prepared statement. Jika gagal, file foto yang sempat terunggah dibersihkan menggunakan `hapusFotoBaru()`.
5. **Redirect (PRG):** Mengalihkan halaman kembali ke `admin/mobil` dengan pesan sukses melalui flash message.

---

## Hasil Pengujian Aktual (Testing)
- **Pengujian INSERT Berhasil:** Mencoba mengisi seluruh form kendaraan beserta foto, data berhasil tersimpan ke tabel `t_mobil` dan muncul di tabel daftar kendaraan.
- **Pengujian READ:** Memastikan data yang baru ditambahkan muncul dengan benar di daftar tabel tanpa merusak data lama.
- **Pengujian Validasi:** Memasukkan nilai yang salah (misal: jumlah kursi > 25 atau mengosongkan kolom wajib). Aplikasi berhasil menolak data dan menampilkan alert pesan kesalahan.
- **Pengujian Upload Foto:** Foto berhasil terunggah dan ditampilkan pratinjaunya di tabel daftar kendaraan.