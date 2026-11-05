
<?php

class Manajemen_penyewa_controller extends Controller
{
  private Manajemen_penyewa_model $penyewaModel;

  public function __construct()
  {
    require_once APPPATH . 'helpers/auth_helper.php';
    require_once APPPATH . 'models/Manajemen_penyewa_model.php';

    $this->penyewaModel = new Manajemen_penyewa_model();
  }

  // Menampilkan halaman Manajemen Penyewa
  public function index(): void
  {
    require_admin_login();

    $penyewa = $this->penyewaModel->getAll();

    $this->view('admin/penyewa_view', [
      'judul'    => 'Manajemen Data Penyewa',
      'username' => $_SESSION['admin_username'] ?? '',
      'penyewa'  => $penyewa
    ]);
  }

  // Menambahkan data penyewa
  public function tambah(): void
  {
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirectIndex();
    }

    $data = [
      'user_plg'   => trim($_POST['user_plg'] ?? ''),
      'nik'        => trim($_POST['nik'] ?? ''),
      'nm_lngkp'   => trim($_POST['nm_lngkp'] ?? ''),
      'no_hp'      => trim($_POST['no_hp'] ?? ''),
      'almt_lngkp' => trim($_POST['almt_lngkp'] ?? '')
    ];

    $password = $_POST['sandi'] ?? '';

    // Validasi data
    if (
      $data['user_plg'] === '' ||
      $data['nik'] === '' ||
      $data['nm_lngkp'] === '' ||
      $data['no_hp'] === '' ||
      $data['almt_lngkp'] === '' ||
      $password === ''
    ) {
      $this->redirectIndex();
    }

    if (
      strlen($data['user_plg']) > 15 ||
      !preg_match('/^[0-9]{16}$/', $data['nik']) ||
      strlen($data['nm_lngkp']) > 100 ||
      strlen($data['no_hp']) > 15 ||
      strlen($data['almt_lngkp']) > 300 ||
      strlen($password) < 8
    ) {
      $this->redirectIndex();
    }

    // Hash password sebelum disimpan
    $data['sandi'] = password_hash($password, PASSWORD_DEFAULT);

    if ($data['sandi'] !== false) {
      $this->penyewaModel->create($data);
    }

    $this->redirectIndex();
  }

  // Mengubah data penyewa
  public function ubah(string $userPlg): void
  {
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirectIndex();
    }

    $userPlg = trim($userPlg);

    $data = [
      'nik'        => trim($_POST['nik'] ?? ''),
      'nm_lngkp'   => trim($_POST['nm_lngkp'] ?? ''),
      'no_hp'      => trim($_POST['no_hp'] ?? ''),
      'almt_lngkp' => trim($_POST['almt_lngkp'] ?? '')
    ];

    if (
      $this->penyewaModel->findByUserPlg($userPlg) === null ||
      !preg_match('/^[0-9]{16}$/', $data['nik']) ||
      $data['nm_lngkp'] === '' ||
      strlen($data['nm_lngkp']) > 100 ||
      $data['no_hp'] === '' ||
      strlen($data['no_hp']) > 15 ||
      $data['almt_lngkp'] === '' ||
      strlen($data['almt_lngkp']) > 300
    ) {
      $this->redirectIndex();
    }

    $this->penyewaModel->update($userPlg, $data);

    $this->redirectIndex();
  }

  // Menghapus data penyewa
  public function hapus(string $userPlg): void
  {
    require_admin_login();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirectIndex();
    }

    $userPlg = trim($userPlg);

    if ($this->penyewaModel->findByUserPlg($userPlg) !== null) {
      $this->penyewaModel->delete($userPlg);
    }

    $this->redirectIndex();
  }

  // Mengarahkan kembali ke halaman utama
  private function redirectIndex(): void
  {
    header('Location: ' . site_url('admin/penyewa'));
    exit;
  }
}
