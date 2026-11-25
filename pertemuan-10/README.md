# Laporan Praktikum Pertemuan 10 (P10)
**Topik:** Pelunasan dan Cetakan / Dokumen Transaksi Berbasis MVC

## 1. Identitas Mahasiswa
- **Nama:** Syaifila Wulandari
- **NIM:** 2522500055
- **Kelas:** SI3A

## 2. Artefak dan Kondisi Awal Aplikasi P9
- **Artefak Awal:** Proyek aplikasi penyewaan kendaraan berbasis MVC dari `pertemuan-09` yang disalin ke workspace `dpwl-252250055\`[cite: 5].
- **Kondisi Awal:** Layanan Apache dan MySQL pada Laragon berjalan normal, koneksi basis data `db_dpwl_wulan` terhubung dengan baik, dan seluruh struktur direktori P9 tersedia[cite: 5, 45].

## 3. Hasil Pemeriksaan Fitur dari P9
- Login sebagai admin dan tampilan halaman dashboard admin — **Berfungsi normal**
- Login sebagai penyewa dan tampilan halaman katalog — **Berfungsi normal**
- Daftar transaksi & detail pada menu *Pembayaran Saya* — **Berfungsi normal**
- Pengunggahan bukti pembayaran DP oleh penyewa — **Berfungsi normal**
- Proses verifikasi pembayaran DP oleh admin serta perubahan status pembayaran & transaksi — **Berfungsi normal**
- Informasi kendaraan pada detail transaksi — **Berfungsi normal**

## 4. Tahapan Pengembangan P10
- **Tahap A (Selesai):** Menyiapkan workspace dan artefak P9, menguji kesiapan seluruh fitur dasar P9, serta menyiapkan dokumentasi awal `README.md` dan repositori Git.
- **Tahap B (Selesai):** Menyesuaikan struktur basis data dengan menambahkan nilai ENUM `'lunas'` pada kolom `status_sewa` di tabel `t_sewa`.
- **Tahap C (Selesai):** Mengimplementasikan Model Pelunasan pada `application\models\Pembayaran_model.php` dengan menambahkan 4 *method* baru dan mempertahankan seluruh fitur pembayaran dari P9.

## 5. Daftar Berkas yang Ditambahkan atau Diubah
- `pertemuan-10/README.md` (Diperbarui dengan catatan perubahan struktur basis data dan hasil verifikasi Tahap B)
- `application/models/Pembayaran_model.php` (Diubah — menambahkan *method* `getDaftarPelunasan()`, `getDetailPelunasan()`, `buatKodeBayarPelunasan()`, dan `simpanPelunasan()` tanpa menghapus fitur P9)

## 6. Perubahan Struktur Basis Data
- **Basis Data & Tabel:** `db_dpwl_wulan` — Tabel `t_sewa` (Kolom `status_sewa`).
- **Perubahan:** Menambahkan nilai ENUM `'lunas'` dengan tetap mempertahankan 7 nilai ENUM sebelumnya (`diajukan`, `disetujui`, `ditolak`, `aktif`, `selesai`, `batal`, `keranjang`).
- **Perintah SQL yang dijalankan:**
  ```sql
  ALTER TABLE `t_sewa` CHANGE `status_sewa` `status_sewa` ENUM('diajukan','disetujui','ditolak','aktif','selesai','batal','keranjang','lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT 'keranjang';
  - **Perintah SQL yang dijalankan:**
  

## 7. Hasil Pengujian Setiap Tahap
- **Pengujian Tahap A (Baseline P9):** Seluruh alur transaksi P9 dari pengajuan sewa, unggah bukti DP, hingga verifikasi oleh admin berjalan lancar tanpa error.
- **Pengujian Tahap B (Verifikasi Struktur Database):** Pemeriksaan kembali pada tab *Structure* tabel `t_sewa` di phpMyAdmin memastikan bahwa kolom `status_sewa` kini telah memuat nilai ENUM `'lunas'` dan seluruh nilai ENUM lama tetap tersedia tanpa perubahan pada kolom lain.
```markdown
- **Pemeriksaan Awal Tahap C (Model Pelunasan):**
  - `getDaftarPelunasan()` mengambil transaksi berstatus `disetujui` atau `lunas` yang memiliki detail kendaraan pada `t_pilih`, serta menghitung total transaksi dari *snapshot* tarif (`hrg_sewa * n_hari`) dan sisa kewajiban (`total_transaksi - total_terbayar`).
  - `getDetailPelunasan()` mengambil detail transaksi, identitas penyewa, total transaksi, pembayaran valid, sisa kewajiban, riwayat pembayaran, dan rincian kendaraan.
  - `buatKodeBayarPelunasan()` menghasilkan kode pembayaran berformat `PAY/YYYYMMDD/NN` dengan *named lock* `dpwl_payment_code_sequence` yang sama dengan P9.
  - `simpanPelunasan()` memvalidasi metode bayar (`tunai`/`transfer`), bukti transfer, sisa kewajiban, serta mencegah duplikasi pelunasan secara atomik (`GET_LOCK`, `SELECT ... FOR UPDATE`, `INSERT`, `UPDATE`, `COMMIT`/`ROLLBACK`) dan mengubah status transaksi menjadi `lunas` tanpa mengubah status kendaraan pada `t_mobil`.

## 8. Kendala, Proses Debugging, dan Perbaikan
- **Kendala:** Tidak ditemukan kendala saat menambahkan nilai ENUM `'lunas'` pada tabel `t_sewa`.
- **Perbaikan:** -