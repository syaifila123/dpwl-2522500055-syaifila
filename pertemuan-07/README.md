# pertemuan-07
# Dokumentasi Praktikum Pertemuan 07 (P7)

## Tahap A: Memastikan Artefak P6 Siap Digunakan

### A.1. Laporan Pemeriksaan Kesiapan Aplikasi P6
Pemeriksaan dan pengujian dilakukan untuk memastikan seluruh fitur dasar hasil pengembangan Pertemuan 06 (P6) berjalan dengan baik sebagai *baseline* sebelum pengembangan fitur transaksi pada P7.

**Hasil Pemeriksaan Fitur Baseline (P6):**
* **Konfigurasi URL Clean (Tanpa `index.php`):** Berhasil. Seluruh rute aplikasi (seperti `/katalog`, `/auth/login-penyewa`, dll.) berjalan normal tanpa menyertakan `index.php` pada URL.
* **Koneksi & Basis Data:** Koneksi ke database MySQL melalui Laragon berjalan lancar tanpa galat.
* **Autentikasi & Sesi:** Fitur login/logout untuk Admin maupun Penyewa berfungsi dengan baik.
* **Pengelolaan Katalog & Mobil:** Halaman katalog kendaraan, detail kendaraan, serta CRUD data mobil pada sisi Admin berjalan sesuai spesifikasi.
* **Profil Penyewa:** Halaman profil penyewa dapat diakses dan diperbarui tanpa kendala.

**Kesimpulan A.1:**  
Aplikasi P6 sudah memenuhi syarat kesiapan, stabil, dan bebas dari galat yang menghambat. Workspace siap digunakan sebagai dasar pengembangan fitur transaksi P7.

---

### A.2. Riwayat Perubahan & Eksekusi Git
* Seluruh berkas pada workspace `dpwl-nim` telah disalin ke folder arsip `dpwl-nim-nama\pertemuan-07\`.
* Git commit dan push telah dilakukan untuk menandai titik awal (*baseline*) P7.

### Bagian B: Membuat Model dan Controller Transaksi serta Route Tambah ke Keranjang

#### B.1. Membuat Berkas application\models\Transaksi_model.php
* Telah dibuat berkas `application\models\Transaksi_model.php` sebagai fondasi pengelolaan transaksi.
* Mengimplementasikan metode `ambilKunci()` dan `lepasKunci()` menggunakan fungsi `GET_LOCK` dan `RELEASE_LOCK` dari MySQL untuk mengendalikan akses bersamaan (*concurrency control*).
* Mengimplementasikan metode `kunciDanBuatKodeSewa()` untuk menghasilkan kode transaksi unik dengan format `INV/YYYYMMDD/NN` (nomor urut harian dibatasi hingga 99).

---

#### B.2. Membuat Berkas application\controllers\Transaksi_controller.php
* Telah dibuat berkas `application\controllers\Transaksi_controller.php` untuk menangani permintaan penambahan kendaraan ke keranjang.
* Mengimplementasikan validasi login penyewa via `wajibLoginPenyewa()` dan validasi metode HTTP POST via `wajibMetode()`.
* Mengimplementasikan metode `redirectTambahDenganPesan()` untuk mengarahkan pengguna kembali ke halaman katalog/detail beserta notifikasi *flash message*.
* Mengimplementasikan metode `pesanBisnisAman()` untuk memastikan pesan galat yang ditampilkan ke pengguna bersifat aman tanpa membocorkan detail internal sistem.

**Status Pengujian B.2:**
* Struktur Controller dan penanganan proteksi akses telah siap.
* Pengujian fungsional penuh belum dilakukan di tahap ini karena masih menunggu integrasi Route (B.3) dan formulir pada View Katalog/Detail (Bagian C).


#### B.3. Menambahkan Route Transaksi
* Menambahkan rute baru pada `application\config\routes.php` untuk menghubungkan URL `transaksi/tambah` dengan metode `tambah()` pada `Transaksi_controller`:
  ```php
  $route['transaksi/tambah'] = 'Transaksi_controller/tambah';
  ```

**Status Pengujian Bagian B:**
* Struktur Controller, Model, dan Route telah berhasil dikonfigurasi tanpa adanya galat sintaks PHP.
* Pengujian fungsional penambahan kendaraan belum dilakukan di browser karena masih menunggu penyesuaian formulir pada View Katalog dan Detail Kendaraan di Bagian C

### Bagian C: Mengintegrasikan dan Menyesuaikan Tombol Tambah ke Keranjang pada Halaman Detail Kendaraan dan Halaman Katalog Kendaraan

#### C.1. Mengubah Formulir pada application\views\katalog\detail.php
* Mengintegrasikan formulir penambahan kendaraan ke keranjang pada halaman detail kendaraan[cite: 8].
* Menyesuaikan tampilan tombol `Add To Cart` menjadi bentuk kondisional berdasarkan status ketersediaan unit dan status login penyewa[cite: 8, 9]:
  1. **Belum Login:** Menampilkan notifikasi informasi beserta tombol **Login Penyewa** dan **Registrasi**[cite: 9, 10].
  2. **Kendaraan Tidak Tersedia:** Menampilkan notifikasi status `Kendaraan ini tidak dapat ditambahkan ke keranjang karena statusnya tidak tersedia`[cite: 9, 10].
  3. **Sudah Login & Tersedia:** Menampilkan formulir `POST` ke rute `transaksi/tambah` dengan tombol **Tambah ke Keranjang**[cite: 9, 11].
