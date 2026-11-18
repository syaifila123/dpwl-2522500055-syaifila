<?php

require_once __DIR__ . '/../models/Pembayaran_model.php';

class Pembayaran_controller
{
    private Pembayaran_model $pembayaranModel;
    private string $uploadDir;

    public function __construct(mysqli $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->pembayaranModel = new Pembayaran_model($db);$this->uploadDir = __DIR__ . '/../../uploads/bayar/';
    }

    // =========================================================================
    // BAGIAN 1: PEMBAYARAN OLEH PENYEWA
    // =========================================================================

    private function cekAksesPenyewa(): string
    {
        // Admin dilarang mengakses halaman pembayaran penyewa
        if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {$_SESSION['flash_error'] = 'Admin tidak diperbolehkan mengakses halaman pembayaran penyewa.';
            header('Location: ' . BASE_URL . 'admin/verifikasi-pembayaran');
            exit;
        }

        if (empty($_SESSION['id_penyewa'])) {$_SESSION['flash_error'] = 'Silakan login sebagai penyewa terlebih dahulu.';
            header('Location: ' . BASE_URL . 'auth/login_penyewa');
            exit;
        }

        return (string) $_SESSION['id_penyewa'];
    }

    public function index(): void
    {
        $idPenyewa = $this->cekAksesPenyewa();$daftarPembayaran = $this->pembayaranModel->getPembayaranByPenyewa($idPenyewa);

        require __DIR__ . '/../views/penyewa/pembayaran.php';
    }

    public function detail(string $kodeBayar = ''): void
    {
        $idPenyewa =$this->cekAksesPenyewa();
        $kodeBayar = urldecode(trim($kodeBayar));

        $pembayaran = $this->pembayaranModel->getDetailPembayaran($kodeBayar);

        // Tolak jika data tidak ditemukan atau milik penyewa lain
        if (!$pembayaran \vert{}\vert{} (string)$pembayaran['id_penyewa'] !== $idPenyewa) {$_SESSION['flash_error'] = 'Akses ditolak! Data pembayaran tidak ditemukan atau bukan milik Anda.';
            header('Location: ' . BASE_URL . 'pembayaran');
            exit;
        }

        require __DIR__ . '/../views/penyewa/pembayaran_detail.php';
    }

    public function upload(): void
    {
        $idPenyewa =$this->cekAksesPenyewa();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'pembayaran');
            exit;
        }

        $kodeBayar = trim($_POST['kode_bayar'] ?? '');$pembayaran = $this->pembayaranModel->getDetailPembayaran($kodeBayar);

        // Validasi kepemilikan & status pembayaran
        if (!$pembayaran \vert{}\vert{} (string)$pembayaran['id_penyewa'] !== $idPenyewa) {$_SESSION['flash_error'] = 'Akses ditolak! Pembayaran tidak valid.';
            header('Location: ' . BASE_URL . 'pembayaran');
            exit;
        }

        if ($pembayaran['sttus_byr'] !== 'pending') {$_SESSION['flash_error'] = 'Pembayaran ini sudah diverifikasi dan tidak dapat diubah lagi.';
            header('Location: ' . BASE_URL . 'pembayaran/detail/' . urlencode($kodeBayar));
            exit;
        }

        // Validasi keberadaan berkas
        if (!isset($_FILES['bukti_bayar']) || $_FILES['bukti_bayar']['error'] === UPLOAD_ERR_NO_FILE) {$_SESSION['flash_error'] = 'Silakan pilih file gambar bukti transfer terlebih dahulu.';
            header('Location: ' . BASE_URL . 'pembayaran/detail/' . urlencode($kodeBayar));
            exit;
        }

        $file =$_FILES['bukti_bayar'];

        if ($file['error'] !== UPLOAD_ERR_OK) {$_SESSION['flash_error'] = 'Terjadi kesalahan saat mengunggah berkas.';
            header('Location: ' . BASE_URL . 'pembayaran/detail/' . urlencode($kodeBayar));
            exit;
        }

        // Validasi ukuran maksimal 2 MB (2 * 1024 * 1024 bytes)
        $maxSize = 2 * 1024