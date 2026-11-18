
<?php

require_once APPPATH . 'helpers/auth_helper.php';
require_once APPPATH . 'models/Pembayaran_model.php';

class Verifikasi_pembayaran_controller extends Controller
{
  private Pembayaran_model $pembayaranModel;
  private string $uploadDir;

  public function __construct()
  {
    $this->pembayaranModel = new Pembayaran_model();

    $this->uploadDir =
      dirname(rtrim(APPPATH, '/\\')) .
      DIRECTORY_SEPARATOR . 'uploads' .
      DIRECTORY_SEPARATOR . 'bayar' .
      DIRECTORY_SEPARATOR;
  }

  // TAHAP 3.1: HALAMAN DAFTAR VERIFIKASI
  public function index(): void
  {
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      http_response_code(405);
      header('Allow: GET');
      exit('Method Not Allowed');
    }

    try {
      $pembayaran = $this->pembayaranModel
        ->getMenungguVerifikasi();

      $flash = $_SESSION['flash_verifikasi'] ?? null;
      unset($_SESSION['flash_verifikasi']);

      $this->view('admin/verifikasi_pembayaran_view', [
        'judul' => 'Verifikasi Pembayaran',
        'username' => $_SESSION['admin_username'] ?? '',
        'pembayaran' => $pembayaran,
        'flash' => $flash
      ]);
    } catch (Throwable $e) {
      error_log('Halaman verifikasi gagal: ' . $e->getMessage());

      http_response_code(500);
      exit('Halaman verifikasi pembayaran belum dapat ditampilkan.');
    }
  }

  // TAHAP 3.2: PROSES TERIMA / TOLAK
  public function proses(): void
  {
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      header('Allow: POST');
      exit('Method Not Allowed');
    }

    $kodeBayar = trim((string) ($_POST['kode_bayar'] ?? ''));
    $keputusan = trim((string) ($_POST['keputusan'] ?? ''));

    if (
      $kodeBayar === '' ||
      !in_array($keputusan, ['terima', 'tolak'], true)
    ) {
      $this->redirectDenganPesan(
        'danger',
        'Data verifikasi tidak valid.'
      );
    }

    try {
      $berhasil = $this->pembayaranModel
        ->verifikasiPembayaran($kodeBayar, $keputusan);

      if (!$berhasil) {
        $this->redirectDenganPesan(
          'warning',
          'Pembayaran tidak dapat diverifikasi. Pastikan bukti tersedia dan status masih pending.'
        );
      }

      $pesan = $keputusan === 'terima'
        ? 'Pembayaran berhasil diterima. Status transaksi menjadi disetujui.'
        : 'Pembayaran berhasil ditolak. Status transaksi menjadi ditolak.';

      $this->redirectDenganPesan('success', $pesan);
    } catch (Throwable $e) {
      error_log('Proses verifikasi gagal: ' . $e->getMessage());

      $this->redirectDenganPesan(
        'danger',
        'Terjadi kesalahan saat memproses verifikasi pembayaran.'
      );
    }
  }

  // TAHAP 3.3: MENAMPILKAN BUKTI TRANSFER
  public function bukti(): void
  {
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      http_response_code(405);
      header('Allow: GET');
      exit('Method Not Allowed');
    }

    $kodeBayar = trim((string) ($_GET['kode_bayar'] ?? ''));

    if ($kodeBayar === '') {
      http_response_code(404);
      exit('Kode pembayaran tidak ditemukan.');
    }

    try {
      $data = $this->pembayaranModel
        ->getBuktiByKodeBayar($kodeBayar);

      if (!$data) {
        http_response_code(404);
        exit('Bukti pembayaran tidak ditemukan.');
      }

      $namaFile = (string) ($data['ft_byr'] ?? '');

      if (
        $namaFile === '' ||
        basename($namaFile) !== $namaFile
      ) {
        http_response_code(404);
        exit('Nama file bukti pembayaran tidak valid.');
      }

      $lokasi = $this->uploadDir . $namaFile;

      if (!is_file($lokasi)) {
        http_response_code(404);
        exit('File bukti pembayaran tidak ditemukan di folder uploads/bayar/.');
      }

      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $mime = $finfo->file($lokasi);

      if (
        !in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true) ||
        @getimagesize($lokasi) === false
      ) {
        http_response_code(404);
        exit('Format bukti pembayaran tidak valid.');
      }

      header('Content-Type: ' . $mime);
      header('Content-Length: ' . filesize($lokasi));
      header('Cache-Control: private, no-store');
      header('X-Content-Type-Options: nosniff');

      readfile($lokasi);
      exit;
    } catch (Throwable $e) {
      error_log('Tampilan bukti pembayaran gagal: ' . $e->getMessage());

      http_response_code(500);
      exit('Bukti pembayaran belum dapat ditampilkan.');
    }
  }

  // PESAN DAN PENGALIHAN HALAMAN
  private function redirectDenganPesan(
    string $jenis,
    string $pesan
  ): never {
    $_SESSION['flash_verifikasi'] = [
      'jenis' => $jenis,
      'pesan' => $pesan
    ];

    header('Location: ' . site_url('admin/verifikasi'));
    exit;
  }
}
