
<?php

class Manajemen_penyewa_controller extends Controller
{
  private Manajemen_penyewa_model $penyewaModel;

  public function __construct()
  {
    // Memanggil helper autentikasi Admin
    require_once APPPATH . 'helpers/auth_helper.php';

    // Memanggil Model Manajemen Penyewa
    require_once APPPATH . 'models/Manajemen_penyewa_model.php';

    // Membuat objek Model
    $this->penyewaModel = new Manajemen_penyewa_model();
  }

  public function index(): void
  {
    // Memastikan hanya Admin yang sudah login
    // dapat membuka halaman ini.
    require_admin_login();

    // Mengambil seluruh data penyewa
    $penyewa = $this->penyewaModel->getAll();

    // Menampilkan halaman Manajemen Penyewa
    $this->view('admin/penyewa_view', [
      'judul'    => 'Manajemen Data Penyewa',
      'username' => $_SESSION['admin_username'] ?? '',
      'penyewa'  => $penyewa
    ]);
  }
}
