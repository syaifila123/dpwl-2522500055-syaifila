<?php

require_once APPPATH . 'models/SerahTerima_model.php';
require_once APPPATH . 'helpers/auth_helper.php';

class SerahTerima_controller extends Controller
{
    private SerahTerima_model $model;

    public function __construct()
    {
        $this->model = new SerahTerima_model();
    }

    /**
     * Menampilkan daftar transaksi yang siap diserahterimakan.
     */
    public function index(): void
    {
        require_admin_login();
        $this->wajibMetode('GET');

        try {
            $daftarSerahTerima =$this->model
                ->getDaftarSerahTerima();

            $flash =$_SESSION['flash_serah_terima'] ?? null;
            unset($_SESSION['flash_serah_terima']);

            $this->view('admin/serah_terima', [
                'username' => $_SESSION['admin_username'],
                'daftarSerahTerima' => $daftarSerahTerima,
                'flash' => $flash
            ]);
        } catch (Throwable $e) {
            error_log(
                'Daftar serah terima gagal ditampilkan: '
                . $e->getMessage()
            );
            http_response_code(500);
            exit('Daftar serah terima belum dapat ditampilkan. '
                . 'Silakan coba kembali.');
        }
    }

    /**
     * Menampilkan detail transaksi yang akan diserahterimakan.
     */
    public function detail(string $kodeSewa = ''): void
    {
        require_admin_login();
        $this->wajibMetode('GET');

        $kodeSewa = trim(str_replace('~', '/',$kodeSewa));
        if ($kodeSewa === '') {
            http_response_code(400);
            exit('Kode transaksi sewa wajib tersedia.');
        }

        try {
            $detail =$this->model
                ->getDetailSerahTerima($kodeSewa);

            if ($detail === null) {
                http_response_code(404);
                exit('Data transaksi tidak ditemukan.');
            }

            $flash =$_SESSION['flash_serah_terima'] ?? null;
            unset($_SESSION['flash_serah_terima']);

            $this->view('admin/serah_terima_detail', [
                'username' => $_SESSION['admin_username'],
                'detail' => $detail,
                'daftarKendaraan' => $detail['daftar_kendaraan'],
                'flash' => $flash
            ]);
        } catch (Throwable $e) {
            error_log(
                'Detail serah terima gagal ditampilkan: '
                . $e->getMessage()
            );
            http_response_code(500);
            exit('Detail serah terima belum dapat ditampilkan. '
                . 'Silakan coba kembali.');
        }
    }

    /**
     * Memproses serah terima seluruh kendaraan dalam satu transaksi.
     * KTP dan SIM A wajib tersedia sebelum proses dilanjutkan.
     */
    public function proses(string $kodeSewa = ''): void
    {
        require_admin_login();
        $this->wajibMetode('POST');

        $kodeSewa = trim(str_replace('~', '/',$kodeSewa));
        if ($kodeSewa === '') {
            http_response_code(400);
            exit('Kode transaksi sewa wajib tersedia.');
        }

        $detailUrl = 'admin/serah-terima/detail/'
            . str_replace('/', '~', $kodeSewa);

        $detailSebelum = null;
        $fileBaru = [];

        try {
            $detailSebelum =$this->model
                ->getDetailSerahTerima($kodeSewa);

            if ($detailSebelum === null) {
                throw new DomainException(
                    'Data transaksi tidak ditemukan.'
                );
            }

            $uploadKtp =$this->uploadDokumenPenyewa('ft_ktp');
            if (!$uploadKtp['success']) {
                $this->redirectDenganPesan($detailUrl,
                    'error',
                    $uploadKtp['error']
                );
            }
            if ($uploadKtp['filename'] !== null) {
                $fileBaru['ft_ktp'] =$uploadKtp['filename'];
            }

            $uploadSim =$this->uploadDokumenPenyewa('ft_sim_a');
            if (!$uploadSim['success']) {
                $this->hapusFileBaru($fileBaru);
                $this->redirectDenganPesan($detailUrl,
                    'error',
                    $uploadSim['error']
                );
            }
            if ($uploadSim['filename'] !== null) {
                $fileBaru['ft_sim_a'] =$uploadSim['filename'];
            }

            $waktuAktual = (new DateTimeImmutable(
                'now',
                new DateTimeZone('Asia/Jakarta')
            ))->format('H:i:s');

            $this->model->prosesSerahTerima($kodeSewa,
                $waktuAktual,$fileBaru['ft_ktp'] ?? null,
                $fileBaru['ft_sim_a'] ?? null
            );

            $fileLama = [];
            foreach (['ft_ktp', 'ft_sim_a'] as $field) {$namaBaru = $fileBaru[$field] ?? null;
                $namaLama = $detailSebelum[$field] ?? null;

                if (
                    $namaBaru !== null &&
                    is_string($namaLama) &&$namaLama !== '' &&
                    $namaLama !==$namaBaru
                ) {
                    $fileLama[$field] =$namaLama;
                }
            }

            $this->hapusFileLama($fileLama);

            $this->redirectDenganPesan(
                'admin/serah-terima',
                'success',
                "Serah terima transaksi $kodeSewa "
                . 'berhasil dicatat. Status transaksi menjadi aktif.'
            );
        } catch (Throwable $e) {
            error_log(
                "Proses serah terima gagal untuk $kodeSewa: "
                . $e->getMessage()
            );
            $this->hapusFileBaru($fileBaru);

            $pesan =$e instanceof DomainException
                ? $e->getMessage()
                : 'Serah terima gagal diproses. '
                . 'Periksa kembali persyaratan transaksi dan coba lagi.';

            $this->redirectDenganPesan($detailUrl,
                'error',
                $pesan
            );
        }
    }

    private function wajibMetode(string $metodeDiizinkan): void
    {
        $metodeAktif = strtoupper(
            (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET')
        );

        if ($metodeAktif !==$metodeDiizinkan) {
            http_response_code(405);
            header('Allow: ' .