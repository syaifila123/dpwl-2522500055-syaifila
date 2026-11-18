
<?php

require_once APPPATH . 'models/Pembayaran_model.php';
require_once APPPATH . 'models/Transaksi_model.php';

class Pembayaran_controller extends Controller
{
  private Pembayaran_model $pembayaranModel;
  private Transaksi_model $transaksiModel;
  private string $uploadDir;

  public function __construct()
  {
    $this->pembayaranModel = new Pembayaran_model();
    $this->transaksiModel = new Transaksi_model();

    $this->uploadDir =
      dirname(rtrim(APPPATH, '/\\')) .
      DIRECTORY_SEPARATOR . 'uploads' .
      DIRECTORY_SEPARATOR . 'bayar' .
      DIRECTORY_SEPARATOR;
  }

  // Memeriksa login penyewa
  private function wajibLogin(): string
  {
    $userPlg = trim(
      (string) ($_SESSION['penyewa_user_plg'] ?? '')
    );

    if ($userPlg === '') {
      $_SESSION['flash_penyewa_nav'] =
        'Silakan login terlebih dahulu.';

      header('Location: ' . site_url('auth/login-penyewa'));
      exit;
    }

    return $userPlg;
  }

  // Menampilkan halaman pembayaran
  public function index(): void
  {
    $userPlg = $this->wajibLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      http_response_code(405);
      header('Allow: GET');
      exit('Method Not Allowed');
    }

    try {
      $pembayaran = $this->pembayaranModel
        ->getByPenyewa($userPlg);

      $flash = $_SESSION['flash_pembayaran'] ?? null;
      unset($_SESSION['flash_pembayaran']);

      $this->view('pembayaran/index', [
        'pembayaran' => $pembayaran,
        'flash' => $flash,
        'jumlahKeranjang' =>
        $this->transaksiModel
          ->getJumlahMobilKeranjang($userPlg)
      ]);
    } catch (Throwable $e) {
      error_log(
        'Halaman pembayaran gagal: ' . $e->getMessage()
      );

      http_response_code(500);
      exit('Halaman pembayaran belum dapat ditampilkan.');
    }
  }

  // Upload bukti transfer
  public function upload(): void
  {
    $userPlg = $this->wajibLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      header('Allow: POST');
      exit('Method Not Allowed');
    }

    $kodeBayar = trim(
      (string) ($_POST['kode_bayar'] ?? '')
    );

    if ($kodeBayar === '') {
      $this->redirectDenganPesan(
        'error',
        'Kode pembayaran tidak ditemukan.'
      );
    }

    $namaFile = null;

    try {
      $pembayaran = $this->pembayaranModel
        ->findByKodeBayar($kodeBayar, $userPlg);

      if ($pembayaran === null) {
        http_response_code(404);
        exit('Pembayaran tidak ditemukan.');
      }

      if (
        $pembayaran['sttus_byr'] !== 'pending' ||
        $pembayaran['mtode_byr'] !== 'transfer' ||
        !empty($pembayaran['ft_byr'])
      ) {
        $this->redirectDenganPesan(
          'error',
          'Pembayaran tidak dapat diunggah kembali.'
        );
      }

      $namaFile = $this->uploadBukti();

      $berhasil = $this->pembayaranModel->updateBukti(
        $kodeBayar,
        $userPlg,
        $namaFile
      );

      if (!$berhasil) {
        throw new RuntimeException(
          'Data pembayaran gagal diperbarui.'
        );
      }

      $_SESSION['flash_pembayaran'] = [
        'jenis' => 'success',
        'pesan' => 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.'
      ];
    } catch (Throwable $e) {

      if ($namaFile !== null) {
        $this->hapusFile($namaFile);
      }

      error_log(
        'Upload bukti pembayaran gagal: ' . $e->getMessage()
      );

      $_SESSION['flash_pembayaran'] = [
        'jenis' => 'danger',
        'pesan' => $e instanceof InvalidArgumentException
          ? $e->getMessage()
          : 'Upload bukti pembayaran gagal. Silakan periksa berkas dan coba kembali.'
      ];
    }

    header('Location: ' . site_url('pembayaran'));
    exit;
  }

  // Menampilkan bukti pembayaran milik penyewa
  public function bukti(): void
  {
    $userPlg = $this->wajibLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      http_response_code(405);
      header('Allow: GET');
      exit('Method Not Allowed');
    }

    // Mengambil kode pembayaran dari query string
    $kodeBayar = trim(
      (string) ($_GET['kode_bayar'] ?? '')
    );

    if ($kodeBayar === '') {
      http_response_code(400);
      exit('Kode pembayaran tidak valid.');
    }

    // Memastikan pembayaran milik penyewa yang login
    $data = $this->pembayaranModel
      ->findByKodeBayar($kodeBayar, $userPlg);

    if ($data === null) {
      http_response_code(404);
      exit('Bukti pembayaran tidak ditemukan.');
    }

    $namaFile = (string) ($data['ft_byr'] ?? '');

    if (
      $namaFile === '' ||
      basename($namaFile) !== $namaFile
    ) {
      http_response_code(404);
      exit('Bukti pembayaran tidak ditemukan.');
    }

    $lokasi = $this->uploadDir . $namaFile;

    if (!is_file($lokasi)) {
      http_response_code(404);
      exit('File bukti pembayaran tidak ditemukan.');
    }

    // Memeriksa format gambar
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($lokasi);

    if (
      !in_array(
        $mime,
        ['image/jpeg', 'image/png', 'image/webp'],
        true
      ) ||
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
  }

  // Validasi dan penyimpanan file
  private function uploadBukti(): string
  {
    if (
      !isset($_FILES['ft_byr']) ||
      $_FILES['ft_byr']['error'] === UPLOAD_ERR_NO_FILE
    ) {
      throw new InvalidArgumentException(
        'Bukti transfer wajib dipilih.'
      );
    }

    $file = $_FILES['ft_byr'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
      throw new InvalidArgumentException(
        'Terjadi kesalahan saat mengunggah berkas.'
      );
    }

    if (
      $file['size'] <= 0 ||
      $file['size'] > 2 * 1024 * 1024
    ) {
      throw new InvalidArgumentException(
        'Ukuran bukti pembayaran maksimal 2 MB.'
      );
    }

    if (!is_uploaded_file($file['tmp_name'])) {
      throw new InvalidArgumentException(
        'Berkas upload tidak valid.'
      );
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $format = [
      'image/jpeg' => 'jpg',
      'image/png' => 'png',
      'image/webp' => 'webp'
    ];

    if (
      !isset($format[$mime]) ||
      @getimagesize($file['tmp_name']) === false
    ) {
      throw new InvalidArgumentException(
        'Bukti pembayaran harus berupa JPG, PNG, atau WEBP.'
      );
    }

    if (!is_dir($this->uploadDir)) {
      if (
        !mkdir($this->uploadDir, 0755, true) &&
        !is_dir($this->uploadDir)
      ) {
        throw new RuntimeException(
          'Folder upload gagal dibuat.'
        );
      }
    }

    if (!is_writable($this->uploadDir)) {
      throw new RuntimeException(
        'Folder upload tidak dapat ditulis.'
      );
    }

    $namaFile = 'bukti_' .
      bin2hex(random_bytes(16)) .
      '.' . $format[$mime];

    $tujuan = $this->uploadDir . $namaFile;

    if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
      throw new RuntimeException(
        'Bukti pembayaran gagal disimpan.'
      );
    }

    return $namaFile;
  }

  // Menghapus file jika proses database gagal
  private function hapusFile(string $namaFile): void
  {
    if (
      $namaFile === '' ||
      basename($namaFile) !== $namaFile
    ) {
      return;
    }

    $lokasi = $this->uploadDir . $namaFile;

    if (is_file($lokasi)) {
      unlink($lokasi);
    }
  }

  // Menampilkan pesan dan kembali ke halaman pembayaran
  private function redirectDenganPesan(
    string $jenis,
    string $pesan
  ): never {

    $_SESSION['flash_pembayaran'] = [
      'jenis' => $jenis,
      'pesan' => $pesan
    ];

    header('Location: ' . site_url('pembayaran'));
    exit;
  }
}
