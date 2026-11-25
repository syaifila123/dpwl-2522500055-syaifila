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

## 5. Daftar Berkas yang Ditambahkan atau Diubah
- `pertemuan-10/README.md` (Diperbarui dengan catatan perubahan struktur basis data dan hasil verifikasi Tahap B)

## 6. Perubahan Struktur Basis Data
- **Basis Data & Tabel:** `db_dpwl_wulan` — Tabel `t_sewa` (Kolom `status_sewa`).
- **Perubahan:** Menambahkan nilai ENUM `'lunas'` dengan tetap mempertahankan 7 nilai ENUM sebelumnya (`diajukan`, `disetujui`, `ditolak`, `aktif`, `selesai`, `batal`, `keranjang`).
- **Perintah SQL yang dijalankan:**
  ```sql
  ALTER TABLE `t_sewa` CHANGE `status_sewa` `status_sewa` ENUM('diajukan','disetujui','ditolak','aktif','selesai','batal','keranjang','lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT 'keranjang';
  

## 7. Hasil Pengujian Setiap Tahap
- **Pengujian Tahap A (Baseline P9):** Seluruh alur transaksi P9 dari pengajuan sewa, unggah bukti DP, hingga verifikasi oleh admin berjalan lancar tanpa error.
- **Pengujian Tahap B (Verifikasi Struktur Database):** Pemeriksaan kembali pada tab *Structure* tabel `t_sewa` di phpMyAdmin memastikan bahwa kolom `status_sewa` kini telah memuat nilai ENUM `'lunas'` dan seluruh nilai ENUM lama tetap tersedia tanpa perubahan pada kolom lain.

## 8. Kendala, Proses Debugging, dan Perbaikan
- **Kendala:** Tidak ditemukan kendala saat menambahkan nilai ENUM `'lunas'` pada tabel `t_sewa`.
- **Perbaikan:** -