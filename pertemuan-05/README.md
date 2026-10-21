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

# Dokumentasi Pertemuan 05 tahap D : Pengelolaan Data Master Objek Bisnis dengan MVC (Bagian INSERT/CREATE)

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

# Dokumentasi Praktikum Pertemuan 05 (P5) - Tahap E
**Mata Kuliah:** Desain dan Pemrograman Web Lanjutan (IS203)  
**Topik:** Mengimplementasikan UPDATE Data Kendaraan dengan MVC  

---

## 1. Ringkasan Perubahan Berkas

Pada Tahap E, implementasi fokus pada operasi **UPDATE** untuk mengubah data kendaraan yang tersimpan pada basis data (`t_mobil`). Berkas yang dimodifikasi antara lain:

1. **`application/models/Mobil_model.php`**
   - Menambahkan method `findByNoPlat(string $noPlat)` untuk mengambil data kendaraan berdasarkan nomor plat sebagai *primary key*.
   - Menambahkan method `update(string $noPlat, array $data)` untuk memperbarui record kendaraan di tabel `t_mobil` menggunakan *prepared statement*.

2. **`application/controllers/Mobil_controller.php`**
   - Menambahkan method `ubah(string $noPlat)` untuk menangani permintaan GET (menampilkan formulir ubah) dan POST (memproses pembaruan data).
   - Memanipulasi pemrosesan foto: mempertahankan foto lama jika tidak diunggah foto baru, serta menghapus foto lama secara otomatis jika diganti dengan berkas foto baru yang valid.
   - Memanfaatkan method `validateMobilInput()` untuk menjaga konsistensi aturan validasi input.
   - Menerapkan pola *Post/Redirect/Get* (PRG) dan pesan kilat (*flash message*) saat pembaruan berhasil.

3. **`application/views/admin/mobil_view.php`**
   - Memastikan formulir mendukung mode `ubah` dengan mengisi nilai awal dari `$mobil_dipilih`.
   - Mengatur elemen input `no_plat` dengan atribut `readonly` agar nomor plat tidak dapat diubah (sebagai kunci identitas data).
   - Menampilkan pratinjau foto yang saat ini tersimpan.

---

## 2. Alur Kerja Fitur UPDATE

1. **Akses Formulir Ubah (GET):**
   - Pengguna mengklik tombol **Ubah** pada daftar kendaraan.
   - Controller menerima parameter `no_plat`, memanggil `findByNoPlat()` dari Model, lalu menampilkan formulir yang sudah terisi data kendaraan terpilih.
2. **Validasi & Pemrosesan Data (POST):**
   - Input dari formulir diproses dan divalidasi oleh `validateMobilInput()`.
   - Jika validasi gagal, halaman ditampilkan kembali beserta pesan kesalahan tanpa mengubah data di database.
3. **Pengelolaan Foto:**
   - Jika pengguna mengunggah foto baru, sistem menyimpan berkas baru dan mencatat foto lama untuk dihapus setelah transaksi database berhasil.
   - Jika pengguna tidak mengunggah foto baru, nama berkas foto lama tetap dipertahankan.
4. **Pembaruan Database & Redireksi:**
   - Model menjalankan instruksi SQL `UPDATE`.
   - Jika berhasil, foto lama yang telah diganti akan dihapus dari folder `uploads/mobil/`, *flash message* sukses diset, dan halaman dialihkan kembali ke `admin/mobil` (PRG).

---

## 3. Hasil Pengujian Aktual

- **Pengujian Ubah Data Teks:**
  - [x] Berhasil mengubah nama kendaraan, harga sewa, dan catatan unit. Data pada daftar kendaraan dan database phpMyAdmin terbarui secara konsisten.
- **Pengujian Tanpa Mengganti Foto:**
  - [x] Memperbarui data tanpa memilih berkas foto baru tetap mempertahankan foto lama yang tersimpan sebelumnya.
- **Pengujian Penggantian Foto:**
  - [x] Berhasil mengganti foto depan/belakang/interior. Berkas foto baru berhasil tersimpan di folder `uploads/mobil/` dan foto lama terhapus secara bersih.
- **Pengujian Validasi & Keamanan:**
  - [x] Pengisian input tidak valid (misal: jumlah kursi > 25 atau harga negatif) menampilkan pesan peringatan dan pembaruan dibatalkan.
  - [x] Mengakses nomor plat yang tidak ada mengarahkan kembali ke halaman utama dengan pesan "Data kendaraan tidak ditemukan."
- **Regresi Fitur:**
  - [x] Fitur READ (daftar kendaraan) dan INSERT (tambah kendaraan) dari tahap sebelumnya tetap berfungsi normal tanpa kendala.

---

## 4. Riwayat Git (Commit Message)

- **Commit Message:** `P5: Mengimplementasikan UPDATE data kendaraan dengan MVC`
- **Berkas Terdampak:**
  - `application/models/Mobil_model.php`
  - `application/controllers/Mobil_controller.php`
  - `application/views/admin/mobil_view.php`
  - `pertemuan-05/README.md`