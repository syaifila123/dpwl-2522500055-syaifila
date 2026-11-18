# Praktikum Mandiri P9 - Transaksi MVC II: Pembayaran Awal dan Verifikasi Pembayaran

## 1. Deskripsi Pengembangan
Pengembangan lanjutan Sistem Informasi Penyewaan Kendaraan berbasis PHP 8.4 (Homemade MVC) dari baseline Pertemuan 7 (P7). Fitur yang ditambahkan berfokus pada penyelesaian pembayaran awal (DP 30%) oleh penyewa dan proses verifikasi bukti transfer oleh administrator.

## 2. Riwayat Pengembangan Bertahap

### Tahap 1: Konfigurasi Routing dan Direktori Upload
- Membuat direktori penyimpanan bukti transfer pada `uploads/bayar/`.
- Menambahkan rute pembayaran penyewa (`/pembayaran`, `/pembayaran/detail/{kode}`, `/pembayaran/upload`) dan rute verifikasi admin (`/admin/verifikasi-pembayaran`, `/admin/verifikasi-pembayaran/detail/{kode}`, `/admin/verifikasi-pembayaran/proses`) pada `application/config/routes.php`.

### Tahap 2: Implementasi Model & Controller Pembayaran
- **File Baru**:
  - `pertemuan-09/application/models/Pembayaran_model.php`: Mengelola query data pembayaran DP dan transaksi sewa menggunakan MySQLi Prepared Statement serta Database Transaction (`begin_transaction`, `commit`, `rollback`) saat proses verifikasi admin.
  - `pertemuan-09/application/controllers/Pembayaran_controller.php`: Mengatur pembatasan hak akses (penyewa vs admin), validasi kepemilikan transaksi, validasi berkas bukti transfer (ekstensi JPG/JPEG/PNG/WEBP, MIME type `finfo`, ukuran maksimal 2 MB, penamaan file acak), dan pola Post-Redirect-Get (PRG).

  ### Tahap 3: View Pembayaran Penyewa & Navigasi Katalog
- **File Baru & Perubahan**:
  - `pertemuan-09/application/views/penyewa/pembayaran.php`: Menampilkan daftar transaksi penyewaan beserta rincian tagihan pembayaran awal (DP 30%), status unggahan bukti transfer, dan status verifikasi pembayaran.
  - `pertemuan-09/application/views/penyewa/pembayaran_detail.php`: Menampilkan detail rincian transaksi, perhitungan nominal DP 30%, pratinjau bukti transfer, serta formulir unggah bukti pembayaran (JPG/JPEG/PNG/WEBP, maksimal 2 MB).
  - `pertemuan-09/application/views/katalog/navbar.php`: Menambahkan menu navigasi **Pembayaran** pada bilah navigasi katalog khusus bagi penyewa yang sudah login.

  ### Tahap 4: Tampilan Verifikasi Pembayaran Admin & Menu Sidebar
- **File Baru & Perubahan**:
  - `application/views/admin/verifikasi_pembayaran.php`: Menampilkan daftar seluruh transaksi pembayaran awal (DP 30%) dari penyewa pada panel AdminLTE lengkap dengan status unggahan bukti dan status pembayaran.
  - `application/views/admin/verifikasi_pembayaran_detail.php`: Menampilkan rincian data penyewa, nominal transaksi dan DP 30%, pratinjau gambar bukti transfer, serta tombol aksi **Terima Pembayaran** dan **Tolak Pembayaran**.
  - `application/views/templates/sidebar.php`: Menambahkan item menu navigasi **Verifikasi Pembayaran** pada sidebar admin.
- **Aturan Perubahan Status Verifikasi**:
  - **Terima Pembayaran**: `t_bayar.sttus_byr` diubah menjadi `valid`, `t_sewa.status_sewa` menjadi `disetujui`, dan `t_bayar.tgl_wkt_ver` mencatat waktu verifikasi.
  - **Tolak Pembayaran**: `t_bayar.sttus_byr` diubah menjadi `invalid`, `t_sewa.status_sewa` menjadi `ditolak`, dan `t_bayar.tgl_wkt_ver` mencatat waktu verifikasi.