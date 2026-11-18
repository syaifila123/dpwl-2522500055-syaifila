# Praktikum Mandiri P9 - Transaksi MVC II: Pembayaran Awal dan Verifikasi Pembayaran

## 1. Deskripsi Pengembangan
Pengembangan lanjutan Sistem Informasi Penyewaan Kendaraan berbasis PHP 8.4 (Homemade MVC) dari baseline Pertemuan 7 (P7). Fitur yang ditambahkan berfokus pada penyelesaian pembayaran awal (DP 30%) oleh penyewa dan proses verifikasi bukti transfer oleh administrator.

## 2. Riwayat Pengembangan Bertahap

### Tahap 1: Konfigurasi Routing dan Direktori Upload
- Membuat direktori penyimpanan bukti transfer pada `uploads/bayar/`.
- Menambahkan rute pembayaran penyewa (`/pembayaran`, `/pembayaran/detail/{kode}`, `/pembayaran/upload`) dan rute verifikasi admin (`/admin/verifikasi-pembayaran`, `/admin/verifikasi-pembayaran/detail/{kode}`, `/admin/verifikasi-pembayaran/proses`) pada `application/config/routes.php`.