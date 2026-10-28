# pertemuan-06
# README P6 — Tahap A: Persiapan Aset Zay Shop

## 1. Tujuan
Tahap A bertujuan memeriksa struktur template Zay Shop, mengidentifikasi komponen halaman yang akan digunakan, menyiapkan aset pada workspace aplikasi DPWL, serta mencatat jalur aset yang perlu disesuaikan saat integrasi ke dalam arsitektur MVC.

Pengembangan P6 melanjutkan aplikasi dari P5. Oleh karena itu, berkas dan fitur P5 yang masih diperlukan tetap dipertahankan.

## 2. Pemeriksaan Struktur Template Zay Shop
Template Zay Shop digunakan sebagai referensi antarmuka untuk pengembangan katalog kendaraan.

Berkas HTML yang diperiksa sebagai sumber template meliputi:

- `index.html` sebagai referensi halaman utama.
- `shop.html` sebagai referensi halaman katalog.
- `shop-single.html` sebagai referensi halaman detail.

Template juga menyediakan `about.html` dan `contact.html`, yang tidak perlu diintegrasikan apabila tidak dibutuhkan dalam ruang lingkup praktikum.

## 3. Identifikasi Komponen Halaman
Komponen template yang menjadi perhatian dalam persiapan integrasi meliputi:

- **Header:** bagian atas halaman dan pemanggilan stylesheet serta ikon.
- **Navigasi:** tautan yang menghubungkan halaman.
- **Konten utama:** banner, gambar, dan susunan kartu produk yang dapat diadaptasi menjadi katalog kendaraan.
- **Footer:** bagian penutup halaman dan informasi pendukung.
- **Aset antarmuka:** CSS, JavaScript, gambar, dan webfonts.

Konten demonstrasi dari template perlu diidentifikasi agar dapat disesuaikan dengan kebutuhan aplikasi rental kendaraan pada tahap integrasi.

## 4. Pemeriksaan Struktur Folder Aset
Berdasarkan pemeriksaan struktur folder pada ZIP proyek, folder `assets/zay/` tersedia dengan susunan berikut:

```text
assets/
└── zay/
    ├── css/
    ├── img/
    ├── js/
    └── webfonts/
```

Fungsi setiap folder:

- `css/`: stylesheet untuk mengatur tampilan halaman.
- `img/`: gambar dan ikon yang digunakan oleh template.
- `js/`: JavaScript untuk komponen interaktif.
- `webfonts/`: berkas font, termasuk font ikon.

Folder aset yang sudah tersedia dipertahankan agar tidak mengganggu aset dan fitur yang telah digunakan pada P5.

## 5. Pemeriksaan dan Pencatatan Jalur Aset
Jalur aset pada HTML asli perlu dibandingkan dengan lokasi file di workspace aplikasi.

Contoh referensi aset pada HTML asli:

| Jenis | Jalur pada HTML asli | Lokasi aset di workspace |
|---|---|---|
| CSS | `assets/css/bootstrap.min.css` | `assets/zay/css/bootstrap.min.css` |
| CSS | `assets/css/templatemo.css` | `assets/zay/css/templatemo.css` |
| CSS | `assets/css/custom.css` | `assets/zay/css/custom.css` |
| Gambar | `assets/img/banner_img_01.jpg` | `assets/zay/img/banner_img_01.jpg` |
| Gambar | `assets/img/category_img_01.jpg` | `assets/zay/img/category_img_01.jpg` |
| JavaScript | `assets/js/templatemo.js` | `assets/zay/js/templatemo.js` |
| JavaScript | `assets/js/custom.js` | `assets/zay/js/custom.js` |

Tabel tersebut menunjukkan lokasi aset yang perlu diperiksa. Ketersediaan setiap file harus dipastikan dengan mencocokkan nama file pada folder terkait.

Penyesuaian URL dilakukan saat integrasi View dengan mengikuti mekanisme URL yang tersedia pada aplikasi DPWL. Struktur direktori tidak perlu diubah hanya untuk mempertahankan jalur relatif bawaan template.

## 6. Hasil Pemeriksaan Tahap A
Berdasarkan pemeriksaan struktur proyek ZIP:

1. Folder utama `assets/zay/` tersedia.
2. Subfolder `css/`, `img/`, `js/`, dan `webfonts/` tersedia.
3. Berkas HTML sumber template Zay Shop tersedia pada folder sumber template.
4. Jalur aset pada HTML asli perlu dibandingkan dengan lokasi aset dalam workspace.
5. Ketersediaan setiap file yang dirujuk perlu dicocokkan dan dicatat apabila terdapat file yang tidak ditemukan atau jalur yang berbeda.
6. Keberhasilan pemuatan aset, tampilan, dan navigasi melalui aplikasi MVC belum dinyatakan berhasil sebelum pengujian dilakukan setelah integrasi.

## 7. Kesimpulan
Tahap A berfokus pada pemeriksaan template Zay Shop, identifikasi komponen halaman, pemeriksaan struktur aset, serta pencatatan kebutuhan penyesuaian jalur file.

Struktur folder aset utama pada proyek telah tersedia. Pemeriksaan ketersediaan file yang dirujuk dan pencatatan hasil aktual perlu diselesaikan sebelum melanjutkan ke tahap integrasi berikutnya.


## B. Mengimplementasikan Katalog Kendaraan Berbasis MVC

### 1. Komponen yang Ditambahkan / Diubah
- **Model**: `application/models/Mobil_model.php`
  - Menambahkan method `getKatalog()` untuk mengambil data seluruh kendaraan dari tabel `t_mobil` dengan urutan nama mobil secara *ascending*.
- **Route**: `application/config/routes.php`
  - Menambahkan pemetaan route `$route['katalog'] = 'Katalog_controller/index';`.
- **Controller**: `application/controllers/Katalog_controller.php`
  - Membuat controller baru `Katalog_controller` yang memanggil `Mobil_model` dan mengirimkan data katalog kendaraan ke view.
- **View**:
  - `application/views/katalog/header.php`: Menyimpan komponen `<head>` dan *stylesheet* pendukung.
  - `application/views/katalog/navbar.php`: Menyimpan komponen navigasi antarmuka pengguna.
  - `application/views/katalog/footer.php`: Menyimpan bagian footer dan script JavaScript.
  - `application/views/katalog/index.php`: Menyajikan halaman utama katalog yang menampilkan daftar kendaraan dalam bentuk kartu (*cards*).

---

### 2. Langkah Pengujian
1. Membuka peramban dan mengkases URL: `http://localhost/dpwl-2522500055/index.php/katalog`.
2. Memeriksa ketersediaan dan kesesuaian data kendaraan yang muncul pada katalog (Nama mobil, Jenis, Tahun, Transmisi, Kapasitas, Harga sewa/hari, serta Status ketersediaan unit).
3. Memastikan tampilan tata letak berbasis Bootstrap dan aset CSS/JS termuat dengan baik tanpa ada *broken layout*.

---

### 3. Hasil Pengujian Aktual
- **Akses Halaman**: Halaman katalog berhasil dimuat tanpa galat.
- **Pemuatan Data**: Data kendaraan dari basis data berhasil diambil dan ditampilkan secara dinamis melalui loop `foreach` pada View.
- **Penanganan Status Unit**: Badges status (`Tersedia`, `Sedang disewa`, atau `Tidak tersedia`) dan tombol aksi ditampilkan sesuai dengan kondisi `status_unit` kendaraan di basis data.
- **Masalah & Perbaikan**: 
  - *Masalah*: Sempat terjadi pesan galat *"View tidak ditemukan."* saat mengakses halaman katalog.
  - *Perbaikan*: Menyelaraskan struktur direktori view agar folder `katalog/` beserta berkas `header.php`, `navbar.php`, `footer.php`, dan `index.php` berada tepat di dalam `application/views/`.

---

### 4. Status Fitur
- [x] Method `getKatalog()` pada `Mobil_model.php`
- [x] Route `/katalog`
- [x] `Katalog_controller.php`
- [x] View Katalog (`header.php`, `navbar.php`, `footer.php`, `index.php`)
- [x] Pengujian Navigasi dan Tampilan Katalog

# Dokumentasi Pengembangan P6 - Tahap C: Detail Kendaraan Berbasis MVC

## 1. Deskripsi Tahap
Pada tahap ini, dilakukan implementasi fitur detail kendaraan berbasis MVC (Model-View-Controller). Fitur ini memungkinkan pengguna untuk melihat informasi lengkap spesifikasi kendaraan, foto utama beserta galeri thumbnail (foto depan, belakang, dan interior), catatan unit/deskripsi, serta status ketersediaan unit.

---

## 2. Berkas dan Komponen yang Ditambahkan / Diubah
- **`application/config/routes.php`** (Diubah): Menambahkan route URL dinamis untuk detail kendaraan.
- **`application/controllers/Katalog_controller.php`** (Diubah): Menambahkan method `detail(string $noPlat)` untuk menangani permintaan detail kendaraan berdasarkan nomor plat.
- **`application/views/katalog/detail.php`** (Ditambahkan): Membuat tampilan halaman detail kendaraan beserta skrip interaktif galeri foto/thumbnail.

---

## 3. Rincian Perubahan dan Fitur yang Diimplementasikan
1. **Routing Detail Kendaraan (`routes.php`)**:
   - Menambahkan rute `$route['katalog/detail/(:any)'] = 'Katalog_controller/detail/$1';` untuk memetakan URL ke method `detail()`.
2. **Controller (`Katalog_controller.php`)**:
   - Memanggil method `findByNoPlat($noPlat)` pada `Mobil_model`.
   - Mengembalikan respon HTTP 404 (`Kendaraan tidak ditemukan.`) jika data kendaraan tidak ditemukan pada database.
   - Mengirimkan data `$mobil` ke view `katalog/detail.php`.
3. **View Detail (`application/views/katalog/detail.php`)**:
   - Menampilkan detail informasi kendaraan: Nama, Harga/hari, Jenis, Tahun, Transmisi, Kapasitas (kursi & bagasi), Status ketersediaan, dan Deskripsi (`cttn_unit`).
   - Menampilkan galeri foto interaktif (`ft_depan`, `ft_blkg`, `ft_interior`) dengan navigasi panah (sebelumnya/berikutnya) dan thumbnail menggunakan JavaScript client-side.

---

## 4. Langkah Pengujian
1. Membuka halaman katalog kendaraan melalui URL: `http://localhost/dpwl-[NIM]/index.php/katalog`.
2. Memilih salah satu kendaraan lalu mengklik foto atau judul kendaraan untuk menuju ke detail (misal: `http://localhost/dpwl-[NIM]/index.php/katalog/detail/B%201173%20HFF`).
3. Menguji navigasi galeri foto dengan mengklik thumbnail serta tombol panah kiri dan kanan.
4. Menguji akses URL dengan nomor plat yang tidak terdaftar di database (misal: `http://localhost/dpwl-[NIM]/index.php/katalog/detail/PLATNEKAT`) untuk memastikan penanganan galat 404 berjalan dengan benar.

---

## 5. Hasil Aktual Pengujian & Status Fitur
- **Tampilan Detail Kendaraan**: Berhasil menampilkan seluruh informasi kendaraan secara akurat sesuai data di basis data.
- **Galeri Foto**: Berhasil memuat foto utama dan berganti secara interaktif saat thumbnail atau tombol navigasi foto diklik.
- **Penanganan Galat (404)**: Berhasil menampilkan pesan galat 404 saat nomor plat tidak ditemukan pada sistem.
- **Status Fitur**: **BERHASIL DIUJI (SUCCESS)**.
