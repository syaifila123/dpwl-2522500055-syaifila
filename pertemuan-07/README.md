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

### Bagian B: Membuat Model dan Controller Transaksi serta Route Tambah ke Keranjang

#### B.1. Membuat Berkas application\models\Transaksi_model.php
* Telah dibuat berkas `application\models\Transaksi_model.php` sebagai fondasi pengelolaan transaksi.
* Mengimplementasikan metode `ambilKunci()` dan `lepasKunci()` menggunakan fungsi `GET_LOCK` dan `RELEASE_LOCK` dari MySQL untuk mengendalikan akses bersamaan (*concurrency control*).
* Mengimplementasikan metode `kunciDanBuatKodeSewa()` untuk menghasilkan kode transaksi unik dengan format `INV/YYYYMMDD/NN` (nomor urut harian dibatasi hingga 99).

---

#### B.2. Membuat Berkas application\controllers\Transaksi_controller.php
* Telah dibuat berkas `application\controllers\Transaksi_controller.php` untuk menangani permintaan penambahan kendaraan ke keranjang.
* Mengimplementasikan validasi login penyewa via `wajibLoginPenyewa()` dan validasi metode HTTP POST via `wajibMetode()`.
* Mengimplementasikan metode `redirectTambahDenganPesan()` untuk mengarahkan pengguna kembali ke halaman katalog/detail beserta notifikasi *flash message*.
* Mengimplementasikan metode `pesanBisnisAman()` untuk memastikan pesan galat yang ditampilkan ke pengguna bersifat aman tanpa membocorkan detail internal sistem.

**Status Pengujian B.2:**
* Struktur Controller dan penanganan proteksi akses telah siap.
* Pengujian fungsional penuh belum dilakukan di tahap ini karena masih menunggu integrasi Route (B.3) dan formulir pada View Katalog/Detail (Bagian C).


#### B.3. Menambahkan Route Transaksi
* Menambahkan rute baru pada `application\config\routes.php` untuk menghubungkan URL `transaksi/tambah` dengan metode `tambah()` pada `Transaksi_controller`:
  ```php
  $route['transaksi/tambah'] = 'Transaksi_controller/tambah';
  ```

**Status Pengujian Bagian B:**
* Struktur Controller, Model, dan Route telah berhasil dikonfigurasi tanpa adanya galat sintaks PHP.
* Pengujian fungsional penambahan kendaraan belum dilakukan di browser karena masih menunggu penyesuaian formulir pada View Katalog dan Detail Kendaraan di Bagian C

### Bagian C: Mengintegrasikan dan Menyesuaikan Tombol Tambah ke Keranjang pada Halaman Detail Kendaraan dan Halaman Katalog Kendaraan

#### C.1. Mengubah Formulir pada application\views\katalog\detail.php
* Mengintegrasikan formulir penambahan kendaraan ke keranjang pada halaman detail kendaraan
* Menyesuaikan tampilan tombol `Add To Cart` menjadi bentuk kondisional berdasarkan status ketersediaan unit dan status login penyewa[cite: 8, 9]:
  1. **Belum Login:** Menampilkan notifikasi informasi beserta tombol **Login Penyewa** dan **Registrasi**[cite: 9, 10].
  2. **Kendaraan Tidak Tersedia:** Menampilkan notifikasi status `Kendaraan ini tidak dapat ditambahkan ke keranjang karena statusnya tidak tersedia`[cite: 9, 10].
  3. **Sudah Login & Tersedia:** Menampilkan formulir `POST` ke rute `transaksi/tambah` dengan tombol **Tambah ke Keranjang**

### Bagian C: Mengintegrasikan dan Menyesuaikan Tombol Tambah ke Keranjang pada Halaman Detail Kendaraan dan Halaman Katalog Kendaraan

#### C.1. Mengubah Formulir pada application\views\katalog\detail.php
* Mengintegrasikan formulir penambahan kendaraan ke keranjang pada halaman detail kendaraan[cite: 8].
* Menyesuaikan tampilan tombol `Add To Cart` menjadi bentuk kondisional berdasarkan status ketersediaan unit dan status login penyewa[cite: 8, 9]:
  1. **Belum Login:** Menampilkan notifikasi informasi beserta tombol **Login Penyewa** dan **Registrasi**
  2. **Kendaraan Tidak Tersedia:** Menampilkan notifikasi status `Kendaraan ini tidak dapat ditambahkan ke keranjang karena statusnya tidak tersedia`
  3. **Sudah Login & Tersedia:** Menampilkan formulir `POST` ke rute `transaksi/tambah` dengan tombol **Tambah ke Keranjang**[cite: 9, 11].

#### C.2. Mengubah application\views\katalog\index.php
* Adjust tombol penambahan kendaraan pada kartu katalog di halaman utama (`index.php`)[cite: 11, 12]:
  * Kendaraan berstatus `tersedia` dan penyewa sudah login: Tombol aktif dikirimkan melalui formulir `POST`[cite: 11, 12].
  * Kendaraan berstatus `tersedia` tetapi penyewa belum login: Tombol **Tambah ke Keranjang** ditampilkan dalam kondisi nonaktif (`disabled`)
  * Kendaraan tidak tersedia / sedang disewa: Tombol diganti menjadi tombol nonaktif **Tidak Dapat Disewa**

**Hasil Pengujian Bagian C:**
* Berhasil memverifikasi ketiga kondisi tampilan pada halaman detail kendaraan (Belum Login, Tidak Tersedia, dan Sudah Login)[cite: 10, 11].
* Berhasil memverifikasi tombol kondisional pada daftar kendaraan di halaman katalog[cite: 12, 13].
* Seluruh elemen formulir mengirimkan data `no_plat` dan `return_to` melalui metode `POST` ke rute `transaksi/tambah` tanpa menimbulkan galat

# README – Tahap D 

# D.1: Menampilkan Pesan Notifikasi dan Tautan Keranjang pada Navbar
## 1. Deskripsi
Tahap D.1 merupakan proses penyesuaian navbar pada aplikasi penyewaan kendaraan. Perubahan dilakukan pada file `application/views/katalog/navbar.php` untuk menampilkan pesan notifikasi transaksi dan menambahkan tautan menuju halaman keranjang penyewa.

## 2. File yang Diubah
File yang diperbarui:

```text
application/views/katalog/navbar.php
```

## 3. Perubahan yang Dilakukan

### A. Menambahkan Variabel Jumlah Keranjang
Menambahkan variabel `$jumlahKeranjang` dengan nilai default 0 apabila data belum dikirimkan oleh Controller.

### B. Menambahkan Flash Message Transaksi
Menambahkan variabel `$flashKatalog` untuk mengambil pesan transaksi dari session `flash_transaksi`.

Pesan notifikasi ditampilkan berdasarkan jenis pesan, yaitu:
- `success` untuk pesan berhasil.
- `danger` untuk pesan gagal.

Notifikasi juga dilengkapi tombol untuk menutup pesan.

### C. Mengubah Tautan Ikon Keranjang
Mengubah tautan ikon keranjang yang sebelumnya menggunakan `href="#"` menjadi:

```php
<?= $e(site_url('transaksi/keranjang')) ?>
```

Jumlah kendaraan pada ikon keranjang menggunakan variabel `$jumlahKeranjang`, bukan lagi angka statis.

## 4. Hasil Pengujian

Pengujian dilakukan setelah perubahan navbar selesai.

| No. | Pengujian | Hasil |
|---|---|---|
| 1 | Membuka halaman katalog | Berhasil |
| 2 | Memeriksa tampilan navbar | Berhasil |
| 3 | Memeriksa tautan ikon keranjang | Berhasil diarahkan ke URL `/transaksi/keranjang` |
| 4 | Membuka halaman keranjang | Belum berhasil, menampilkan halaman 404 |
| 5 | Menguji jumlah kendaraan secara dinamis | Belum dilakukan, menunggu integrasi Controller dan Model |

**Catatan:** Munculnya halaman 404 dicatat sebagai hasil pengujian akses halaman tujuan. Pada Tahap D.1, pengujian tautan berfokus pada memastikan ikon keranjang mengarah ke URL yang ditentukan modul. Pengujian jumlah kendaraan dilakukan setelah integrasi Controller dan Model selesai.

## 5. Kesimpulan
Pada Tahap D.1 telah dilakukan perubahan pada navbar dengan menambahkan flash message transaksi, mengubah tautan ikon keranjang, dan menggunakan variabel `$jumlahKeranjang` untuk menampilkan jumlah kendaraan.

Perubahan navbar telah dilakukan sesuai instruksi Modul P7. Integrasi jumlah kendaraan dan pengujian halaman keranjang dilanjutkan sesuai tahapan berikutnya.

# README – Tahap D.2.1 dan D.2.2: Integrasi Jumlah Keranjang pada Model dan Controller Katalog

## 1. Deskripsi
Tahap D.2 merupakan proses integrasi jumlah kendaraan yang terdapat di dalam keranjang penyewa. Jumlah kendaraan dihitung berdasarkan akun penyewa yang sedang login dan ditampilkan pada navbar halaman katalog serta detail kendaraan.

Pada tahap ini dilakukan perubahan pada Model transaksi dan Controller katalog.

## 2. File yang Diubah

File yang diperbarui:

```text
application/
├── models/
│   └── Transaksi_model.php
└── controllers/
    └── Katalog_controller.php
```

## 3. D.2.1 Memperbarui Transaksi_model.php

### A. Penambahan Method getJumlahMobilKeranjang()

Menambahkan method `getJumlahMobilKeranjang()` pada class `Transaksi_model`.

Method ini berfungsi untuk menghitung jumlah kendaraan dalam keranjang berdasarkan akun penyewa yang sedang login.

### B. Proses yang Dilakukan
- Memeriksa dan membersihkan nilai username penyewa.
- Mengembalikan nilai 0 jika username kosong.
- Mengambil jumlah kendaraan menggunakan query SQL.
- Menghubungkan tabel `t_pilih` dengan tabel `t_sewa`.
- Menghitung data berdasarkan `user_plg` dan status penyewaan `keranjang`.
- Mengembalikan hasil perhitungan dalam bentuk integer.

## 4. D.2.2 Memperbarui Katalog_controller.php

### A. Menambahkan Pemanggilan Model Transaksi

Menambahkan pemanggilan file `Transaksi_model.php` menggunakan `require_once` agar Controller dapat menggunakan Model transaksi.

### B. Menambahkan Properti Model Transaksi

Menambahkan properti:

```php
private Transaksi_model $transaksiModel;
```

Properti tersebut digunakan untuk mengakses method yang tersedia pada `Transaksi_model`.

### C. Inisialisasi Model Transaksi

Menambahkan inisialisasi Model transaksi di dalam method `__construct()`:

```php
$this->transaksiModel = new Transaksi_model();
```

### D. Mengirim Jumlah Keranjang pada Method index()

Memperbarui method `index()` agar mengirimkan data `jumlahKeranjang` ke halaman katalog.

Jumlah keranjang dihitung berdasarkan akun penyewa yang sedang login. Jika penyewa belum login, jumlah keranjang bernilai 0.

### E. Mengirim Jumlah Keranjang pada Method detail()

Memperbarui method `detail()` agar mengirimkan data `jumlahKeranjang` bersama informasi kendaraan ke halaman detail kendaraan.

Dengan perubahan ini, jumlah kendaraan dalam keranjang dapat ditampilkan pada navbar halaman katalog dan detail kendaraan.

## 5. Hasil Pengujian

Pengujian dilakukan melalui browser setelah perubahan Model dan Controller selesai.

| No. | Pengujian | Hasil |
|---|---|---|
| 1 | Membuka halaman katalog kendaraan | Isi sesuai hasil pengujian aktual |
| 2 | Membuka halaman detail kendaraan | Isi sesuai hasil pengujian aktual |
| 3 | Mengakses katalog tanpa login sebagai penyewa | Jumlah keranjang seharusnya 0 |
| 4 | Mengakses detail kendaraan tanpa login sebagai penyewa | Jumlah keranjang seharusnya 0 |
| 5 | Login sebagai penyewa dan membuka katalog | Jumlah keranjang mengikuti isi keranjang akun tersebut |
| 6 | Login sebagai penyewa dan membuka detail kendaraan | Jumlah keranjang mengikuti isi keranjang akun tersebut |

**Catatan:** Pada tahap ini, apabila keranjang penyewa masih kosong, jumlah yang ditampilkan adalah 0. Hal tersebut wajar karena proses penambahan kendaraan ke keranjang belum dibahas pada tahap ini.

Hasil pengujian di atas perlu disesuaikan dengan kondisi aplikasi yang benar-benar telah diuji.

## 6. Kesimpulan

Tahap D.2.1 dan D.2.2 dilakukan untuk mengintegrasikan perhitungan jumlah kendaraan dalam keranjang melalui Model transaksi dan Controller katalog.

Dengan perubahan tersebut, jumlah keranjang dapat dikirimkan ke halaman katalog dan detail kendaraan berdasarkan akun penyewa yang sedang login. Apabila penyewa belum login, jumlah keranjang ditampilkan sebagai 0.

# README – Tahap D.2.3: Mengirim Jumlah Keranjang ke Halaman Profil Penyewa

## 1. Deskripsi

Tahap D.2.3 merupakan proses penyesuaian `Penyewa_controller.php` agar jumlah kendaraan dalam keranjang tetap ditampilkan pada navbar ketika penyewa membuka halaman profil.

Perubahan dilakukan dengan mengintegrasikan `Transaksi_model.php` ke dalam Controller penyewa sehingga jumlah kendaraan dalam keranjang dapat dihitung berdasarkan akun penyewa yang sedang login.

## 2. File yang Diubah

File yang diperbarui:

```text
application/
└── controllers/
    └── Penyewa_controller.php
```

## 3. Perubahan yang Dilakukan

### A. Menambahkan Pemanggilan Model Transaksi

Menambahkan pemanggilan `Transaksi_model.php` pada bagian atas file setelah pemanggilan Model penyewa.

```php
require_once APPPATH . 'models/Transaksi_model.php';
```

### B. Menambahkan Properti Model Transaksi

Menambahkan properti berikut di dalam class `Penyewa_controller` setelah properti Model penyewa.

```php
private Transaksi_model $transaksiModel;
```

### C. Menginisialisasi Model Transaksi

Menambahkan inisialisasi Model transaksi di dalam method `__construct()` tanpa menghapus inisialisasi Model penyewa yang sudah ada.

```php
$this->transaksiModel = new Transaksi_model();
```

### D. Memperbarui Method profil()

Menambahkan pemanggilan method `getJumlahMobilKeranjang($userPlg)` setelah data profil berhasil ditemukan.

Jumlah keranjang kemudian dikirimkan ke View `penyewa/profil` melalui array data menggunakan:

```php
'jumlahKeranjang' => $jumlahKeranjang
```

### E. Memperbarui Tampilan Ketika Validasi Gagal

Pada bagian validasi formulir profil, jumlah keranjang juga dihitung dan dikirimkan ke View `penyewa/profil`.

Dengan demikian, ketika pengguna memasukkan data yang tidak valid dan pesan kesalahan ditampilkan, jumlah kendaraan dalam keranjang tetap muncul pada navbar.

### F. Memperbarui Method renderProfilError()

Menambahkan pengambilan username penyewa dari session dan menghitung jumlah keranjang.

```php
$userPlg = trim((string) ($_SESSION['penyewa_user_plg'] ?? ''));

$jumlahKeranjang = $userPlg === ''
    ? 0
    : $this->transaksiModel->getJumlahMobilKeranjang($userPlg);
```

Selanjutnya, variabel `$jumlahKeranjang` dikirimkan ke View profil agar navbar tetap menampilkan jumlah kendaraan meskipun terjadi kesalahan pada proses profil.

## 4. Hasil Pengujian

Pengujian dilakukan melalui browser setelah perubahan Controller selesai.

| No. | Pengujian | Hasil |
|---|---|---|
| 1 | Login sebagai penyewa yang memiliki kendaraan dalam keranjang | Sesuaikan hasil pengujian |
| 2 | Membuka halaman profil dan memeriksa jumlah keranjang | Sesuaikan hasil pengujian |
| 3 | Mengubah data profil menggunakan data valid dan menyimpan perubahan | Sesuaikan hasil pengujian |
| 4 | Menguji validasi formulir menggunakan data tidak valid | Sesuaikan hasil pengujian |
| 5 | Memeriksa jumlah keranjang setelah muncul pesan kesalahan | Sesuaikan hasil pengujian |
| 6 | Memeriksa kembali halaman katalog dan detail kendaraan | Sesuaikan hasil pengujian |

## 5. Kesimpulan

Tahap D.2.3 telah melakukan integrasi `Transaksi_model.php` ke dalam `Penyewa_controller.php` agar jumlah kendaraan dalam keranjang tetap dikirimkan ke halaman profil penyewa.

Dengan perubahan ini, navbar dapat menampilkan jumlah kendaraan dalam keranjang pada halaman katalog, detail kendaraan, maupun profil penyewa, termasuk ketika formulir profil menampilkan pesan kesalahan.

# README – Tahap E: Mengintegrasikan Proses Penambahan Kendaraan ke Keranjang

## 1. Deskripsi

Tahap E merupakan proses integrasi penambahan kendaraan ke dalam keranjang penyewa. Tujuannya agar tombol **Tambah ke Keranjang** pada halaman katalog dan detail kendaraan dapat menyimpan data kendaraan ke dalam database.

Penyimpanan transaksi menggunakan pola Header-Detail:
- Tabel `t_sewa` menyimpan informasi utama transaksi penyewaan (Header).
- Tabel `t_pilih` menyimpan daftar kendaraan yang dipilih (Detail).

## 2. File yang Diubah

File yang diperbarui:

```text
application/
└── models/
    └── Transaksi_model.php
```

## 3. E.1 Menambahkan Method tambahKeKeranjang()

Penambahan method `tambahKeKeranjang()` dilakukan pada class `Transaksi_model` untuk mencari keranjang aktif milik penyewa, membuat transaksi baru jika belum tersedia, dan menambahkan kendaraan yang dipilih ke dalam keranjang.

### A. Menambahkan Helper namaKunciKeranjang()

Helper ini digunakan untuk membuat nama kunci berdasarkan identitas penyewa agar tidak terjadi pembuatan keranjang aktif ganda.

### B. Menambahkan Helper kunciKendaraan()

Helper ini digunakan untuk mengambil dan mengunci data kendaraan dari tabel `t_mobil`, sekaligus memastikan kendaraan ditemukan.

### C. Menambahkan Helper hitungHariSewa()

Helper ini digunakan untuk menghitung durasi penyewaan berdasarkan tanggal mulai dan tanggal selesai.

### D. Menambahkan Helper normalisasiWaktu()

Helper ini digunakan untuk memvalidasi dan menyesuaikan format waktu pengambilan kendaraan.

### E. Menambahkan Method tambahKeKeranjang()

Method ini menjalankan proses penambahan kendaraan ke keranjang dengan tahapan:
1. Memeriksa identitas penyewa dan nomor kendaraan.
2. Memastikan kendaraan memiliki status tersedia.
3. Mencari keranjang aktif milik penyewa.
4. Membuat transaksi baru jika keranjang belum tersedia.
5. Memeriksa agar kendaraan yang sama tidak ditambahkan dua kali.
6. Menyimpan detail kendaraan ke tabel `t_pilih`.
7. Menyelesaikan transaksi apabila proses berhasil.

## 4. Hasil Pengujian

Pengujian dilakukan melalui browser dan phpMyAdmin setelah method `tambahKeKeranjang()` selesai ditambahkan.

| No. | Pengujian | Hasil |
|---|---|---|
| 1 | Login sebagai penyewa | Berhasil |
| 2 | Membuka halaman katalog kendaraan | Berhasil |
| 3 | Menambahkan kendaraan berstatus tersedia ke keranjang | Berhasil |
| 4 | Memastikan aplikasi kembali ke halaman katalog dan menampilkan pesan hasil proses | Sesuaikan hasil aktual |
| 5 | Memeriksa data transaksi pada tabel `t_sewa` | Sesuaikan hasil aktual |
| 6 | Memeriksa data kendaraan pada tabel `t_pilih` dengan kode transaksi yang sama | Sesuaikan hasil aktual |
| 7 | Menambahkan kendaraan lain ke keranjang aktif yang sama | Belum diverifikasi |
| 8 | Mencoba menambahkan kendaraan yang sama untuk kedua kalinya | Belum diverifikasi |

## 5. Kesimpulan

Pada Tahap E telah dilakukan integrasi proses penambahan kendaraan ke keranjang melalui method `tambahKeKeranjang()` pada `Transaksi_model.php`.

Proses ini memungkinkan sistem mencari keranjang aktif milik penyewa, membuat transaksi baru apabila belum tersedia, serta menyimpan kendaraan yang dipilih ke dalam tabel `t_pilih`.

Berdasarkan pengujian awal, proses penambahan kendaraan ke keranjang telah berhasil dilakukan.

# README – Tahap F: Mengimplementasikan Halaman Keranjang dan Checkout Transaksi

## 1. Deskripsi

Tahap F merupakan proses pengembangan halaman keranjang dan checkout transaksi pada aplikasi penyewaan kendaraan.

Pada tahap ini, penyewa dapat melihat kendaraan yang telah dimasukkan ke keranjang, memperbarui periode dan waktu pengambilan, menghapus kendaraan, serta melanjutkan proses checkout untuk mengajukan transaksi kepada admin.

Sistem juga melakukan perhitungan total biaya sewa dan uang muka (DP) sebesar 30% dari total biaya sewa.

## 3. F.1 Membuat Halaman Isi Keranjang

Membuat file `application/views/transaksi/keranjang.php`.

Halaman ini digunakan untuk menampilkan informasi keranjang milik penyewa.

Informasi yang ditampilkan meliputi:
- Kode transaksi.
- Periode penyewaan.
- Waktu pengambilan kendaraan.
- Daftar kendaraan yang dipilih.
- Harga sewa per hari.
- Durasi penyewaan.
- Subtotal setiap kendaraan.
- Total biaya sewa.

Halaman keranjang juga menyediakan beberapa fitur:

1. Memperbarui periode dan waktu pengambilan.
2. Menghapus kendaraan dari keranjang.
3. Melanjutkan proses checkout.

Tampilan menggunakan header, navbar, dan footer yang sudah tersedia pada aplikasi.

## 4. F.2 Menambahkan Method pada Transaksi_controller.php

Memperbarui `Transaksi_controller.php` dengan menambahkan beberapa method untuk mengelola halaman keranjang dan proses transaksi.

### A. Method keranjang()

Digunakan untuk menampilkan isi keranjang milik penyewa yang sedang login.

Method ini memeriksa keranjang aktif dan mengambil data keranjang berdasarkan kode transaksi serta identitas penyewa.

### B. Method perbaruiPeriode()

Digunakan untuk memperbarui tanggal mulai, tanggal selesai, dan waktu pengambilan kendaraan.

### C. Method hapus()

Digunakan untuk menghapus kendaraan tertentu dari keranjang penyewa.

### D. Method checkout()

Digunakan untuk menampilkan halaman konfirmasi transaksi dan memproses pengajuan checkout.

### E. Method redirectDenganPesan()

Digunakan untuk menyimpan pesan notifikasi transaksi ke session sebelum mengarahkan pengguna ke halaman tujuan.