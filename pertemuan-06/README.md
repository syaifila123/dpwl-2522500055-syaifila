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
