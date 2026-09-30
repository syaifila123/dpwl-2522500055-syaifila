# Tugas pertemuan 01
1. kesinambungan PWD–DPW–DPWL;
# jawaban :
 * Pemrograman Web Dasar (PWD) adalah fondasi antarmuka berfokus pada klien dan elemen dasar interenet yang menggunakan HTML, CSS, dan JavaScript, serta dasar PHP native tanpa struktur data yang rumit
* Desain dan Pemrograman Web (DPW) adalah tahap transisi dan penguatan. Mulai berfokus pada sisi server ,MYSQL ,serta OOP pada PHP. DPW menghubungkan fondasi statis  (PWD) mkenjadi aplikasi dinamis
* ⁠  Desain Pemrograman Web Lanjutan (DPWL) yaittu berfokus dalam membangun web berskala besar yang terstruktur menggunakan WFC dan framework
2. perbedaan PHP terstruktur dan MVC;
# jawaban :
* PHP terstruktur : Kode HTML, logika, PHP dan query database bercampur dalam satu file. menggunakan fungsi prosedural (dari atas bawah). Rawan berantakan, sulit dirawat dan di perbaiki jika aplikasi membesar. namun sangat mudah di pelajari. Untuk membuat website yang kecil atau sederhana
* ⁠PHP MVC :Sebaliknya kode dipisah rapi sesuai fungsinya (data, tampilan, logika).  Menggunakan Pemrograman Berorientasi Objek (OOP). Mudah diperbaiki tanpa merusak bagian lain, tetapi butuh waktu yang lebih lama karena harus paham konseo OOP. Untuk website besar dan kerja tim
3. fungsi Model, View, dan Controller;
# jawaban :
* Fungsi Model : Mengelolah data dan logika bisnis aplikasi yang berhubungan langsung dengan database serta menjalankan proses seperti simpan, ubah, hapus, dan ambil data
* ⁠Fungsi View : Menyajikan informasi dalam bentuk visual atau HTML, Mengatur tampilan antarmuka pengguna, serta menerima data dari controller untuk diperlihatkan ke pengguna
* ⁠Fungsi Controller : Sebagai jembatan antara model dan view untuk mengatur alur kerja program dan memanggil data dari model serta menerima permintaan dan input dari pengguna
4. alur request–response MVC;
# jawaban :
Request (permintaan) - Routing (Pemberian Jalur) - Controller (Pengontrol) - Model - (Data / Logika Bisnis) - View (Tampilan ) - Response (Tanggapan)
5. pemetaan satu atau beberapa bagian/fitur aplikasi DPW ke Model, Controller, dan View disertai alasan; dan
# jawaban : 
* Model : Bertanggung jawab terhadap data, aturan bisnis, dan interaksi dengan database, yang mengandung query SQL untuk mengambil data dari tabel etintas
* ⁠Alasan :tempat olah database. semua operasi yang memanipulasi data databse harus dipisahkan agar tidak tercampur dengan tampilan

* Controller : Sebagai otak yang menerima input dari penggunaan, yang mengatur  alur saat user menekan tombol "Tambah Data" atau "Hapus Data" , memproses nya melalui model dan memutuskan view mana yang akan ditampilkan
* ⁠Alasan : tempat untuk mengantur logika aplikasi, agar alur jerja aplikasi menjadi jelas dan mempermudah proses pencarian kesalahan jika terjadi error pada alur program

* View : Halaman/Komponen yang langsung dilihat dan beringteraksi dengan penggunaan. Yang berisi tabel untuk menampilkan nama dan NIM
* ⁠Alasan : Hanya fokus pada bagaimana data ditampilkan secara visual menggunakan HTML, CSS, atau JavaScript. Komponen ini tidak boleh tau bagaimana data itu diambil dari databse ataupun bagaimana logika di baliknya
6. kesimpulan P1.
# jawaban :
MVC pada aplikasi DPW secara tegas memisahkan antara logika data(Model), logika bisnis/alur kerja(Conbtroller), dan tampilan pengguna (View). Agar sistem organisasi DPW mudah dipelihara, stabilitas tinggi, serta mengurangi resiko kebocoran data
