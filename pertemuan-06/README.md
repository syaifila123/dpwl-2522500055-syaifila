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

# Dokumentasi Pengembangan P6 - Tahap D: Registrasi Akun Penyewa

## 1. Deskripsi Tahap
Pada tahap ini, dilakukan implementasi fitur registrasi akun penyewa (pelanggan). Fitur ini memungkinkan pengguna baru untuk mendaftarkan akun penyewa dengan mengisikan data identitas diri yang diperlukan ke dalam tabel `t_penyewa`, sebelum dapat melakukan pemesanan rental kendaraan.

---

## 2. Berkas dan Komponen yang Ditambahkan / Diubah
- **`application/config/routes.php`** (Diubah): Menambahkan route untuk halaman registrasi penyewa.
- **`application/models/Penyewa_model.php`** (Ditambahkan): Membuat Model baru untuk menangani query basis data terkait data penyewa (pengecekan username duplikat dan penyimpanan data registrasi).
- **`application/controllers/Auth.php`** (Diubah): Menambahkan method `register()` untuk menangani proses validasi input, hashing password, dan pemrosesan pendaftaran akun penyewa.
- **`application/views/auth/register.php`** (Ditambahkan): Membuat tampilan formulir registrasi akun penyewa.

---

## 3. Rincian Perubahan dan Fitur yang Diimplementasikan
1. **Routing Registrasi (`routes.php`)**:
   - Menambahkan rute `$route['auth/register'] = 'Auth/register';`.
2. **Model Penyewa (`Penyewa_model.php`)**:
   - Method `findByUserPlg($userPlg)`: Memeriksa ketersediaan username di basis data.
   - Method `create($data)`: Menyimpan data penyewa baru ke tabel `t_penyewa` menggunakan *prepared statement*.
3. **Controller Autentikasi (`Auth.php`)**:
   - Menangani *request* `GET` untuk menampilkan formulir registrasi dan *request* `POST` untuk memproses pendaftaran.
   - Melakukan validasi input di Sisi Server (*Server-Side Validation*):
     - Format username (1-15 karakter: huruf, angka, `.`, `_`, `-`).
     - Keamanan password (minimal 8 karakter) dan konfirmasi password.
     - Validasi NIK (tepat 16 digit angka).
     - Validasi nama lengkap, nomor HP, dan alamat lengkap.
   - Melakukan eksekusi *hashing* password menggunakan `password_hash()` demi keamanan basis data.
   - Menyiapkan pesan notifikasi (*flash message*) saat registrasi berhasil atau pesan galat saat data tidak valid/duplikat.
4. **View Registrasi (`application/views/auth/register.php`)**:
   - Membuat formulir registrasi responsif dengan komponen antarmuka yang terintegrasi dengan layout Zay Shop.
   - Menjaga data yang sudah diisi sebelumnya (`old input`) agar tidak hilang saat terjadi kesalahan validasi.

---

## 4. Langkah Pengujian
1. Membuka halaman registrasi melalui navigasi menu atau URL: `http://localhost/dpwl-[NIM]/index.php/auth/register`.
2. **Pengujian Input Tidak Valid**: Mengisikan password kurang dari 8 karakter, NIK bukan 16 digit, atau konfirmasi password yang tidak cocok untuk memastikan pesan galat muncul.
3. **Pengujian Registrasi Berhasil**: Mengisi seluruh formulir sesuai ketentuan, lalu menekan tombol **Daftar**.
4. **Pengujian Akun Duplikat**: Mencoba mendaftar kembali menggunakan username yang sudah terdaftar sebelumnya untuk memastikan sistem menolak username duplikat.

---

## 5. Hasil Aktual Pengujian & Status Fitur
- **Validasi Input**: Berhasil menolak format input yang tidak memenuhi syarat dan menampilkan pesan kesalahan yang sesuai.
- **Penyimpanan Data**: Berhasil menyimpan data akun penyewa baru ke dalam database `t_penyewa` dengan password yang tersimpan dalam bentuk hash terenkripsi.
- **Pencegahan Duplikasi**: Berhasil mendeteksi username yang telah terdaftar dan menampilkan pesan galat "Username sudah digunakan."
- **Status Fitur**: **BERHASIL DIUJI (SUCCESS)**.

# Dokumentasi Pengembangan P6 - Tahap E: Login, Sesi, dan Logout Penyewa

## 1. Deskripsi Tahap
Pada tahap ini, dilakukan implementasi fitur login, pengelolaan sesi, dan logout untuk akun penyewa (pelanggan). Fitur ini memungkinkan penyewa yang telah terdaftar untuk masuk ke sistem, menyimpan status autentikasi dalam sesi peramban, dan keluar dari akun secara aman.

---

## 2. Berkas dan Komponen yang Ditambahkan / Diubah
- **`application/config/routes.php`** (Diubah): Menambahkan route untuk URL login (`auth/login-penyewa`) dan logout (`auth/logout-penyewa`).
- **`application/models/Penyewa_model.php`** (Diubah): Menambahkan method `findForLogin($userPlg)` untuk mengambil data kredensial penyewa dari basis data.
- **`application/controllers/Auth.php`** (Diubah): Menambahkan method `loginPenyewa()` untuk menangani otentikasi & pembuatan sesi penyewa, serta `logoutPenyewa()` untuk menghapus sesi.
- **`application/views/auth/login_penyewa.php`** (Ditambahkan): Membuat tampilan formulir login akun penyewa.
- **`application/views/katalog/navbar.php`** (Diubah): Menyesuaikan tampilan navigasi header agar menampilkan tombol Logout dan Ikon Profil jika penyewa dalam keadaan login.

---

## 3. Rincian Perubahan dan Fitur yang Diimplementasikan
1. **Routing Login & Logout (`routes.php`)**:
   - Menambahkan rute `$route['auth/login-penyewa'] = 'Auth/loginPenyewa';`.
   - Menambahkan rute `$route['auth/logout-penyewa'] = 'Auth/logoutPenyewa';`.
2. **Model Penyewa (`Penyewa_model.php`)**:
   - Method `findForLogin($userPlg)`: Memeriksa dan mengambil kolom `user_plg`, `sandi`, dan `nm_lngkp` pada tabel `t_penyewa` berdasarkan username.
3. **Controller Autentikasi (`Auth.php`)**:
   - Method `loginPenyewa()`:
     - Mengvalidasi input username dan password dari *form*.
     - Verifikasi kata sandi terenkripsi menggunakan `password_verify()`.
     - Mengamankan ID sesi menggunakan `session_regenerate_id(true)`.
     - Menyimpan identitas penyewa pada `$_SESSION['penyewa_user_plg']` dan menyiapkan *flash message* ucapan selamat datang.
   - Method `logoutPenyewa()`:
     - Menghapus variabel sesi penyewa (`unset($_SESSION['penyewa_user_plg'])`).
     - Menggenerasi ulang ID sesi demi keamanan dan me-redirect pengguna kembali ke halaman katalog dengan notifikasi logout.
4. **View Login (`application/views/auth/login_penyewa.php`)**:
   - Formulir login responsif berbasis layout Zay Shop dengan *input sanitization* demi keamanan.

---

## 4. Langkah Pengujian
1. Membuka halaman login penyewa melalui menu navigasi atau URL: `http://localhost/dpwl-[NIM]/index.php/auth/login-penyewa`.
2. **Pengujian Login Gagal**: Mengisikan kombinasi username atau password yang salah, lalu memastikan muncul pesan kesalahan "Username atau password tidak sesuai."
3. **Pengujian Login Berhasil**: Mengisikan username dan password akun penyewa yang telah terdaftar pada Tahap D.
4. **Pengujian Sesi & Navigasi**: Memastikan pengguna di-redirect ke halaman katalog, notifikasi ucapan selamat datang muncul, dan menu navigasi berubah (menampilkan tombol **Logout** & **Ikon Profil**).
5. **Pengujian Logout**: Mengklik tombol **Logout** pada navbar dan memastikan sesi telah dihapus serta navigasi kembali ke status belum login.

---

## 5. Hasil Aktual Pengujian & Status Fitur
- **Proses Autentikasi**: Berhasil memverifikasi kredensial akun penyewa menggunakan hash `password_verify()`.
- **Manajemen Sesi**: Sesi penyewa tersimpan dengan aman pada `$_SESSION['penyewa_user_plg']` dan navigasi berubah secara dinamis sesuai status autentikasi.
- **Proses Logout**: Berhasil menghapus sesi penyewa dan mengembalikan tampilan navigasi utama ke kondisi semula.
- **Status Fitur**: **BERHASIL DIUJI (SUCCESS)**.

# Dokumentasi Pengembangan P6 - Tahap F: Profil dan Pembaruan Data Penyewa

## 1. Deskripsi Tahap
Pada tahap ini, dilakukan implementasi fitur kelola profil dan pembaruan data penyewa[cite: 2]. Fitur ini memungkinkan penyewa yang sedang login untuk melihat data identitas diri, memperbarui informasi profil (NIK, Nama Lengkap, No HP, Alamat), mengganti kata sandi/password, serta mengunggah foto KTP dan SIM A[cite: 36, 40, 47].

---

## 2. Berkas dan Komponen yang Ditambahkan / Diubah
- **`application/config/routes.php`** (Diubah): Menambahkan route untuk halaman profil penyewa (`penyewa/profil`)[cite: 2, 39].
- **`application/models/Penyewa_model.php`** (Diubah): Menambahkan method `getProfil()`, `verifikasiPassword()`, dan `updateProfil()` untuk penanganan kueri profil dan kata sandi[cite: 2, 28, 29, 43, 44].
- **`application/controllers/Penyewa_controller.php`** (Ditambahkan): Membuat Controller baru untuk menangani otorisasi sesi, validasi input profil/password, dan pemrosesan unggah berkas foto KTP & SIM A[cite: 2, 37].
- **`application/views/penyewa/profil.php`** (Ditambahkan): Membuat tampilan formulir profil penyewa beserta preview foto KTP dan SIM A[cite: 2, 44].

---

## 3. Rincian Perubahan dan Fitur yang Diimplementasikan
1. **Routing & Pembatasan Akses (`routes.php` & `Penyewa_controller.php`)**:
   - Menambahkan rute `$route['penyewa/profil'] = 'Penyewa_controller/profil';`[cite: 39].
   - Menambahkan verifikasi autentikasi sesi (`$_SESSION['penyewa_user_plg']`)[cite: 37, 40]. Jika pengguna belum login, akses ditolak dan dialihkan ke halaman login[cite: 37, 40].
2. **Model Penyewa (`Penyewa_model.php`)**:
   - Method `getProfil($userPlg)`: Mengambil data identitas lengkap penyewa berdasarkan username[cite: 28].
   - Method `verifikasiPassword($userPlg, $passwordSaatIni)`: Memeriksa kebenaran password lama sebelum memproses ganti password[cite: 28, 29].
   - Method `updateProfil(...)`: Memperbarui data profil, referensi berkas foto, dan hash password baru jika diisi[cite: 43, 44].
3. **Validasi & Unggah Berkas (`Penyewa_controller.php`)**:
   - Validasi ketat input NIK (16 digit), Nama Lengkap (maks. 100 karakter), No HP, dan Alamat[cite: 40, 41].
   - Penanganan ganti password opsional dengan verifikasi password saat ini dan konfirmasi password baru[cite: 41].
   - Validasi berkas foto KTP & SIM A: ekstensi gambar (`.jpg`, `.jpeg`, `.png`, `.webp`), MIME type, serta pembatasan ukuran maksimal 5 MB[cite: 41, 42]. Foto disimpan otomatis ke direktori `uploads/penyewa/`[cite: 42, 43].
4. **View Profil (`application/views/penyewa/profil.php`)**:
   - Formulir terintegrasi layout Zay Shop dengan *field* username *readonly*[cite: 48, 49].
   - Menampilkan *preview* gambar KTP dan SIM A yang tersimpan di server[cite: 50, 51].

---

## 4. Langkah Pengujian
1. **Pengujian Pembatasan Akses**: Mengakses URL `http://localhost/dpwl-[NIM]/index.php/penyewa/profil` langsung tanpa login, memastikan sistem me-redirect ke halaman login penyewa[cite: 40, 52].
2. **Pengujian Akses Profil**: Login dengan akun penyewa, lalu mengklik ikon profil pada navbar untuk masuk ke halaman profil[cite: 52].
3. **Pengujian Pembaruan Data & Unggah Foto**:
   - Mengubah Nama, Nomor HP, dan Alamat[cite: 40, 41].
   - Mengunggah berkas foto KTP dan SIM A (format PNG/JPG, < 5 MB)[cite: 41, 42, 51].
   - Menekan tombol **Simpan Perubahan** dan memastikan pesan sukses muncul serta foto preview tampil[cite: 43, 48, 51, 52].
4. **Pengujian Validasi Ganti Password**:
   - Mengisi password baru tanpa mengisi password saat ini untuk menguji respon kesalahan[cite: 41].
   - Mengisi password saat ini dengan benar untuk memastikan password berhasil diperbarui[cite: 41, 43].

---

## 5. Hasil Aktual Pengujian & Status Fitur
- **Keamanan Akses**: Berhasil membatasi halaman profil hanya untuk penyewa terautentikasi[cite: 40].
- **Pembaruan Data & Unggah Berkas**: Data profil berhasil diperbarui pada database `t_penyewa`, serta berkas foto KTP dan SIM A tersimpan rapi di direktori `uploads/penyewa/`[cite: 42, 43].
- **Fitur Ganti Password**: Berhasil memverifikasi password lama dan meng-hash password baru menggunakan `password_hash()`[cite: 41, 43].
- **Status Fitur**: **BERHASIL DIUJI (SUCCESS)**.
