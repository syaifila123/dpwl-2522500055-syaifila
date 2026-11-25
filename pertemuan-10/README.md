# Laporan Praktikum Pertemuan 10 (P10)
**Topik:** Pelunasan dan Cetakan / Dokumen Transaksi Berbasis MVC

## 1. Identitas Mahasiswa
- **Nama:** Syaifila Wulandari
- **NIM:** 2522500055
- **Kelas:** SI3A

## 2. Artefak dan Kondisi Awal Aplikasi P9
- **Artefak Awal:** Proyek aplikasi penyewaan kendaraan berbasis MVC dari `pertemuan-09` yang disalin ke workspace `dpwl-2522500055\`.
- **Kondisi Awal:** Layanan Apache dan MySQL pada Laragon berjalan normal, koneksi basis data `db_dpwl_wulan` terhubung dengan baik, dan seluruh struktur direktori P9 tersedia.

## 3. Hasil Pemeriksaan Fitur dari P9
1. Login sebagai admin dan tampilan halaman administrasi — **Berfungsi normal**
2. Login sebagai penyewa dan tampilan halaman penyewa (`katalog`) — **Berfungsi normal**
3. Daftar transaksi & detail pada menu *Pembayaran Saya* — **Berfungsi normal**
4. Proses pembayaran uang muka (DP) & pengunggahan bukti pembayaran DP oleh penyewa — **Berfungsi normal**
5. Proses verifikasi pembayaran DP oleh admin — **Berfungsi normal**
6. Perubahan status pembayaran (`valid`) dan status transaksi (`disetujui`) sesuai hasil verifikasi — **Berfungsi normal**
7. Informasi kendaraan pada detail transaksi tetap ditampilkan — **Berfungsi normal**

## 4. Tahapan Pengembangan P10
- **Tahap A (Selesai):** Menyiapkan workspace dan artefak P9, menguji kesiapan seluruh fitur dasar P9, serta menyiapkan dokumentasi awal `README.md` dan repositori Git.
- **Tahap B (Selesai):** Menyesuaikan struktur basis data dengan menambahkan nilai ENUM `'lunas'` pada kolom `status_sewa` di tabel `t_sewa`.
- **Tahap C (Selesai):** Mengimplementasikan Model Pelunasan pada `application\models\Pembayaran_model.php` dengan menambahkan 4 *method* baru dan mempertahankan seluruh fitur pembayaran dari P9.
- **Tahap D (Selesai):** Mengimplementasikan Controller Pelunasan dan Dokumen Transaksi pada `application\controllers\Pembayaran_controller.php` dengan menambahkan 4 *method* baru (`pelunasanIndex()`, `pelunasanDetail()`, `prosesPelunasan()`, dan `dokumenTransaksi()`) serta mempertahankan seluruh fungsi pembayaran P9.
- **Tahap E (Selesai):** Menambahkan *route* pelunasan dan dokumen transaksi pada `application\config\routes.php` serta mengintegrasikan menu **Pelunasan Transaksi** pada sidebar admin `application\views\templates\sidebar.php`.
- **Tahap F (Selesai):** Membuat antarmuka daftar dan detail pelunasan pada `application\views\admin\pelunasan.php` serta `application\views\admin\pelunasan_detail.php`, dan melakukan pengujian fungsional alur pelunasan.
- **Tahap G (Selesai):** Membuat dan mengimplementasikan tampilan cetak dokumen transaksi pada `application\views\admin\dokumen_transaksi.php` serta melakukan pengujian tampilan dan cetak/simpan sebagai PDF.

## 5. Daftar Berkas yang Ditambahkan atau Diubah
- `application/models/Pembayaran_model.php` (Diubah — menambahkan *method* `getDaftarPelunasan()`, `getDetailPelunasan()`, `buatKodeBayarPelunasan()`, dan `simpanPelunasan()` tanpa menghapus fitur P9)
- `application/controllers/Pembayaran_controller.php` (Diubah — menambahkan *method* `pelunasanIndex()`, `pelunasanDetail()`, `prosesPelunasan()`, dan `dokumenTransaksi()` sambil mempertahankan fungsi pembayaran P9)
- `application/config/routes.php` (Diubah — menambahkan 4 *route* baru untuk fitur pelunasan dan dokumen transaksi tanpa mengubah *route* P9)
- `application/views/templates/sidebar.php` (Diubah — menambahkan menu navigasi **Pelunasan Transaksi** pada sidebar admin)
- `application/views/admin/pelunasan.php` (Ditambahkan — halaman daftar transaksi yang dapat diproses pelunasannya)
- `application/views/admin/pelunasan_detail.php` (Ditambahkan — halaman detail informasi transaksi, rincian kendaraan, riwayat pembayaran, dan formulir pencatatan pelunasan)
- `application/views/admin/dokumen_transaksi.php` (Ditambahkan — halaman cetak dokumen transaksi sewa kendaraan dan riwayat pembayaran siap simpan PDF)
- `pertemuan-10/README.md` (Diperbarui dengan dokumentasi lengkap progres Tahap A hingga Tahap G)

## 6. Perubahan Struktur Basis Data
- **Basis Data & Tabel:** `db_dpwl_wulan` — Tabel `t_sewa` (Kolom `status_sewa`).
- **Perubahan:** Menambahkan nilai ENUM `'lunas'` dengan tetap mempertahankan 7 nilai ENUM sebelumnya (`diajukan`, `disetujui`, `ditolak`, `aktif`, `selesai`, `batal`, `keranjang`).
- **Perintah SQL yang dijalankan:**
  ```sql
  ALTER TABLE `t_sewa` CHANGE `status_sewa` `status_sewa` ENUM('diajukan','disetujui','ditolak','aktif','selesai','batal','keranjang','lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT 'keranjang';
  ```

## 7. Hasil Pengujian Setiap Tahap
- **Pengujian Tahap A (Baseline P9):** Seluruh alur transaksi P9 dari pengajuan sewa, unggah bukti DP, hingga verifikasi oleh admin berjalan lancar tanpa error.
- **Pengujian Tahap B (Verifikasi Struktur Database):** Pemeriksaan kembali pada tab *Structure* tabel `t_sewa` di phpMyAdmin memastikan bahwa kolom `status_sewa` kini telah memuat nilai ENUM `'lunas'` dan seluruh nilai ENUM lama tetap tersedia tanpa perubahan pada kolom lain.
- **Pemeriksaan Awal Tahap C (Model Pelunasan):**
  - `getDaftarPelunasan()` mengambil transaksi berstatus `disetujui` atau `lunas` yang memiliki detail kendaraan pada `t_pilih`, serta menghitung total transaksi dari *snapshot* tarif (`hrg_sewa * n_hari`) dan sisa kewajiban (`total_transaksi - total_terbayar`).
  - `getDetailPelunasan()` mengambil detail transaksi, identitas penyewa, total transaksi, pembayaran valid, sisa kewajiban, riwayat pembayaran, dan rincian kendaraan.
  - `buatKodeBayarPelunasan()` menghasilkan kode pembayaran berformat `PAY/YYYYMMDD/NN` dengan *named lock* `dpwl_payment_code_sequence` yang sama dengan P9.
  - `simpanPelunasan()` memvalidasi metode bayar (`tunai`/`transfer`), bukti transfer, sisa kewajiban, serta mencegah duplikasi pelunasan secara atomik (`GET_LOCK`, `SELECT ... FOR UPDATE`, `INSERT`, `UPDATE`, `COMMIT`/`ROLLBACK`) dan mengubah status transaksi menjadi `lunas` tanpa mengubah status kendaraan pada `t_mobil`.
- **Pemeriksaan Awal Tahap D (Controller Pelunasan):**
  - Penambahan `pelunasanIndex()` (GET) untuk menampilkan daftar transaksi yang masih memiliki kewajiban pelunasan dari `getDaftarPelunasan()` ke View `admin/pelunasan`.
  - Penambahan `pelunasanDetail()` (GET) untuk memeriksa ketersediaan kode transaksi, mengonversi karakter `~` pada URL menjadi `/`, memanggil `getDetailPelunasan()`, mengembalikan respons `404` jika transaksi tidak ditemukan, serta mengirimkan data ke View `admin/pelunasan_detail`.
  - Penambahan `prosesPelunasan()` (POST) untuk memvalidasi input metode pembayaran (`tunai` tanpa unggahan bukti, atau `transfer` dengan unggahan bukti `ft_byr` maksimal 5 MB format JPEG/PNG/WEBP melalui helper `simpanFileBukti()`), memanggil `simpanPelunasan()` pada Model, menghapus bukti baru jika terjadi kegagalan (`hapusBuktiBaru()`), mencatat error lewat `error_log()`, dan menerapkan pola Post-Redirect-Get (`redirectDenganPesan()`).
  - Penambahan `dokumenTransaksi()` (GET) untuk menyajikan data transaksi lengkap ke View cetak `admin/dokumen_transaksi`.
  - Seluruh *method* baru dibatasi aksesnya hanya untuk admin melalui `require_admin_login()`, sedangkan seluruh fungsi pembayaran P9 (`verifikasiIndex()`, `verifikasiDetail()`, `prosesVerifikasi()`, `index()`, `detail()`, `uploadBukti()`) dan helper pendukung tetap dipertahankan tanpa perubahan.
- **Pemeriksaan Awal Tahap E (Route dan Navigasi Menu):**
  - Route daftar pelunasan (`admin/pembayaran/pelunasan`) telah mengarah ke `Pembayaran_controller/pelunasanIndex`.
  - Route proses pelunasan (`admin/pembayaran/pelunasan/proses/(:any)`) ditempatkan sebelum route umum dan mengarah ke `Pembayaran_controller/prosesPelunasan/$1` dengan pembatasan metode `POST`.
  - Route dokumen transaksi (`admin/pembayaran/dokumen/(:any)`) telah mengarah ke `Pembayaran_controller/dokumenTransaksi/$1`.
  - Route detail pelunasan (`admin/pembayaran/pelunasan/(:any)`) telah mengarah ke `Pembayaran_controller/pelunasanDetail/$1`.
  - Menu **Pelunasan Transaksi** telah terintegrasi pada sidebar admin (`application/views/templates/sidebar.php`) dan mengarah ke URL `admin/pembayaran/pelunasan`, sementara seluruh route P9 tetap berfungsi tanpa benturan.
- **Pengujian Aktual Tahap F (Tampilan dan Proses Pelunasan):**
  1. Halaman daftar pelunasan (`admin/pembayaran/pelunasan`) berhasil menampilkan daftar transaksi yang memiliki sisa kewajiban pembayaran — **Berhasil**
  2. Tautan **Detail / Proses** berhasil mengarahkan ke halaman detail transaksi sesuai kode sewa (`admin/pembayaran/pelunasan/{kode_sewa}`) — **Berhasil**
  3. Informasi transaksi, identitas penyewa, rincian kendaraan beserta tarif *snapshot*, ringkasan pembayaran, dan riwayat pembayaran ditampilkan dengan akurat — **Berhasil**
  4. Formulir pencatatan pelunasan menyediakan pilihan metode `Tunai` dan `Transfer` dengan nominal otomatis sebesar sisa kewajiban — **Berhasil**
  5. Ketika metode `Transfer` dipilih, input unggah bukti transfer (`ft_byr`) muncul secara dinamis dan wajib diisi — **Berhasil**
  6. Pengiriman formulir menggunakan metode `POST` berhasil mencatat pembayaran pelunasan dengan status `valid` dan memperbarui status transaksi menjadi `lunas` — **Berhasil**
  7. Transaksi yang telah berstatus `lunas` tidak lagi menampilkan formulir pencatatan pelunasan kembali dan menampilkan pesan bahwa transaksi sudah memiliki record pelunasan — **Berhasil**
  8. Pesan notifikasi (*flash message*) keberhasilan maupun kegagalan tampil sesuai hasil pemrosesan Controller — **Berhasil**
  9. Seluruh data teks dari basis data ditampilkan dengan aman menggunakan *escaping* `htmlspecialchars()` dan tidak mengganggu fitur pembayaran P9 — **Berhasil**
- **Pengujian Aktual Tahap G (Tampilan dan Cetak Dokumen Transaksi):**
  1. Login sebagai admin berhasil dilakukan — **Berfungsi normal**
  2. Membuka detail transaksi yang telah berstatus `lunas` menampilkan informasi transaksi lengkap — **Berfungsi normal**
  3. Tautan **Lihat / Cetak Dokumen Transaksi** membuka halaman dokumen transaksi pada tab baru — **Berfungsi normal**
  4. Halaman dokumen transaksi (`admin/pembayaran/dokumen/{kode_sewa}`) berhasil ditampilkan — **Berfungsi normal**
  5. Kode transaksi dan status transaksi (`lunas`) ditampilkan sesuai data — **Berfungsi normal**
  6. Identitas penyewa (nama lengkap, username, NIK, nomor telepon, alamat) ditampilkan dengan lengkap dan aman (*escaped*) — **Berfungsi normal**
  7. Seluruh rincian kendaraan (nomor polisi, nama kendaraan, tarif *snapshot*/hari, lama sewa, subtotal) ditampilkan dengan akurat — **Berfungsi normal**
  8. Riwayat pembayaran (pembayaran DP dan pembayaran pelunasan) ditampilkan dengan lengkap — **Berfungsi normal**
  9. Total transaksi, total pembayaran valid, dan sisa kewajiban (`Rp 0`) sesuai dengan data pada basis data — **Berfungsi normal**
  10. Tombol **Cetak / Simpan sebagai PDF** memicu dialog cetak peramban (`window.print()`) — **Berfungsi normal**
  11. Pratinjau cetak (*Print Preview*) tampil bersih dan dokumen dapat disimpan sebagai berkas PDF — **Berfungsi normal**
  12. Tata letak hasil cetak tersusun rapi pada ukuran kertas A4 dengan tombol aksi tersembunyi (`@media print`) sehingga informasi tidak terpotong — **Berfungsi normal**

## 8. Kendala, Proses Debugging, dan Perbaikan
- **Kendala:** Sempat muncul pesan `"View tidak ditemukan."` saat mengakses halaman dokumen transaksi (`admin/pembayaran/dokumen/INV~20261119~01`).
- **Proses Debugging & Perbaikan:** Memeriksa penempatan dan penamaan berkas View di dalam direktori workspace `dpwl-2522500055\application\views\admin\dokumen_transaksi.php` serta memperbaiki *typo* sintaks hasil salin-tempel dari PDF modul sehingga halaman dokumen transaksi dapat dimuat dan dicetak dengan normal.