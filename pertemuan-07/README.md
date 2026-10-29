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
