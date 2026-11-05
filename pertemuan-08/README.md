# TAHAP AWAL – PERSIAPAN PROYEK UTS DPWL P8

## 1. Tujuan
Tahap awal dilakukan untuk mempersiapkan aplikasi penyewaan kendaraan dari bahan UTS P8 DPWL agar dapat digunakan sebagai dasar pengembangan fitur Manajemen Data Penyewa.

## 2. Persiapan Aplikasi

Persiapan yang dilakukan meliputi:

1. Mengunduh dan mengekstrak ZIP bahan UTS P8 DPWL yang telah disediakan oleh dosen.
2. Menempatkan folder aplikasi pada direktori server lokal.
3. Menjalankan server lokal menggunakan localhost.
4. Memastikan aplikasi dapat dibuka melalui browser.
5. Mengimpor basis data menggunakan file SQL yang disediakan dalam ZIP apabila basis data belum tersedia.
6. Memastikan koneksi aplikasi dengan basis data berjalan dengan baik.

# Tahap 1 – Penambahan Menu Manajemen Penyewa

## Tujuan
Menambahkan menu Manajemen Penyewa pada sidebar Admin agar Admin dapat mengakses halaman pengelolaan data penyewa.

## Pekerjaan yang Dilakukan
1. Menambahkan menu **Manajemen Penyewa** pada `application/views/templates/sidebar.php`.
2. Menambahkan route `admin/penyewa` pada `application/config/routes.php`.
3. Membuat controller awal `Manajemen_penyewa_controller.php` pada folder `application/controllers/`.
4. Menguji akses halaman Manajemen Penyewa melalui browser.

## Hasil Pengujian
- Menu Manajemen Penyewa berhasil ditampilkan pada sidebar Admin.
- Route berhasil mengarahkan ke controller.
- Halaman berhasil dibuka melalui URL `admin/penyewa`.
- Tampilan AdminLTE dan informasi username Admin berhasil ditampilkan.

**Status: Berhasil.**

## Kesimpulan
Tahap 1 berhasil dilakukan sebagai dasar pengembangan fitur Manajemen Data Penyewa. Selanjutnya, pengerjaan dilanjutkan dengan pembuatan Model Manajemen Penyewa.

# Tahap 2 – Pembuatan Model Manajemen Penyewa

## Tujuan
Membuat model untuk mengelola dan mengambil data penyewa dari database.

## Pekerjaan yang Dilakukan
1. Membuat file `Manajemen_penyewa_model.php` pada folder `application/models/`.
2. Membuat method `getAll()` untuk mengambil seluruh data penyewa.
3. Membuat method `findByUserPlg()` untuk mencari data penyewa berdasarkan username.
4. Menggunakan MySQLi Prepared Statements untuk menjalankan query database.

## Hasil
Model Manajemen Penyewa berhasil dibuat dan siap digunakan oleh Controller pada tahap berikutnya.

**Status: Selesai.**

# Tahap 3 – Pembuatan Controller Manajemen Penyewa

## Tujuan
Menghubungkan Model Manajemen Penyewa dengan Controller agar data penyewa dapat diambil dari database.

## Pekerjaan yang Dilakukan
1. Memperbarui file `Manajemen_penyewa_controller.php`.
2. Menghubungkan Controller dengan `Manajemen_penyewa_model.php`.
3. Menambahkan pengecekan autentikasi Admin.
4. Mengambil seluruh data penyewa menggunakan method `getAll()`.
5. Mengirim data penyewa ke halaman View.

## Hasil
Controller Manajemen Penyewa berhasil diperbarui dan siap digunakan untuk menampilkan data penyewa.

**Status: Selesai.**

# Tahap 4 – Pembuatan View Manajemen Penyewa

## Tujuan
Membuat halaman Manajemen Penyewa untuk menampilkan formulir dan tabel data penyewa.

## Pekerjaan yang Dilakukan
1. Membuat file `penyewa_view.php` pada folder `application/views/admin/`.
2. Menambahkan formulir input data penyewa.
3. Menambahkan kolom unggah Foto KTP dan Foto SIM A.
4. Membuat tabel untuk menampilkan data penyewa dari database.
5. Menggunakan template AdminLTE yang sudah tersedia.

## Hasil
Halaman Manajemen Penyewa berhasil ditampilkan dan data penyewa dari database berhasil muncul pada tabel.

**Status: Selesai.**

# Tahap 5 – Implementasi CRUD Manajemen Penyewa

## Tujuan
Membuat fungsi pengelolaan data penyewa menggunakan Model dan MySQLi Prepared Statements.

## Pekerjaan yang Dilakukan
1. Menambahkan fungsi `create()` untuk menambah data penyewa.
2. Mempertahankan fungsi `getAll()` untuk mengambil seluruh data penyewa.
3. Menambahkan fungsi `update()` untuk mengubah data penyewa.
4. Menambahkan fungsi `delete()` untuk menghapus data penyewa.
5. Menambahkan fungsi `updatePassword()` untuk mengubah password penyewa.
6. Menambahkan fungsi `findByUserPlg()` untuk mencari data berdasarkan username.

## Hasil
Fungsi CRUD pada Model Manajemen Penyewa berhasil dibuat dan siap dihubungkan dengan Controller.

**Status: Bagian Model selesai, proses CRUD keseluruhan masih berlanjut.**

# Tahap 5 Lanjutan – Implementasi CRUD Controller Manajemen Penyewa

## Tujuan
Menghubungkan Model Manajemen Penyewa dengan Controller untuk memproses pengelolaan data penyewa.

## Pekerjaan yang Dilakukan
1. Menambahkan fungsi `tambah()` untuk memproses penambahan data penyewa.
2. Menambahkan fungsi `ubah()` untuk memproses perubahan data penyewa.
3. Menambahkan fungsi `hapus()` untuk memproses penghapusan data penyewa.
4. Menambahkan validasi input dan hashing password.
5. Menambahkan route untuk proses tambah, ubah, dan hapus data.
6. Menambahkan redirect setelah proses pengolahan data.

## Hasil
Fungsi Controller untuk proses CRUD Manajemen Penyewa berhasil dibuat dan dihubungkan dengan Model serta Routes.

**Status: Selesai.**