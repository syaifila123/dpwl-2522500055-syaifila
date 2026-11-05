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