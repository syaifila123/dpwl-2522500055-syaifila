# pertemuan-09
# P9 - Transaksi MVC II: Pembayaran Awal dan Verifikasi Pembayaran

## Tahap 1 - Analisis Source Code P7

### Perubahan
- Memeriksa struktur folder aplikasi DPWL berbasis PHP 8.4 dan Homemade MVC.
- Menganalisis proses checkout dan pembuatan record pembayaran DP.
- Memeriksa Model dan Controller transaksi.
- Memeriksa autentikasi serta hak akses admin dan penyewa.
- Mempelajari mekanisme upload foto yang sudah tersedia.
- Memeriksa route dan navigasi aplikasi.

### Hasil
Aplikasi P7 telah memiliki fitur keranjang dan checkout. Proses checkout menghasilkan record pembayaran DP sebesar 30% dari total transaksi dengan status `pending`.

### Status
Analisis source code selesai. Pengembangan fitur pembayaran dilanjutkan pada Tahap 2.

## Tahap 2.1 – Halaman Pembayaran Penyewa

### Perubahan
- Membuat halaman pembayaran penyewa.
- Menampilkan informasi transaksi dan pembayaran DP.
- Menampilkan nominal DP sebesar 30%.
- Menampilkan status pembayaran.
- Menambahkan akses menu pembayaran pada navbar.

### Hasil
Penyewa dapat melihat informasi pembayaran DP setelah melakukan checkout.

### Status
Halaman pembayaran penyewa berhasil dibuat.

## 2.2. Menampilkan Rincian Transaksi dan Pembayaran DP
- Membuat Model untuk mengambil data transaksi dan pembayaran.
- Menampilkan kode transaksi dan rincian pembayaran.
- Menampilkan nominal pembayaran DP sebesar 30%.
- Menampilkan metode dan status pembayaran.
- Memastikan penyewa hanya dapat melihat pembayaran miliknya sendiri.

## 2.3. Membuat Formulir Upload Bukti Pembayaran
- Membuat formulir upload bukti transfer.
- Menambahkan validasi format file gambar.
- Membatasi ukuran file maksimal 2 MB.
- Menambahkan pesan informasi apabila upload berhasil atau gagal.

## 2.4. Menyimpan Bukti Pembayaran
- Menyimpan bukti pembayaran ke direktori uploads/bayar/.
- Memperbarui kolom ft_byr dan tgl_wkt_byr pada tabel t_bayar.
- Memastikan upload tidak membuat data pembayaran DP baru.
- Mempertahankan status pembayaran pending sampai diverifikasi admin.