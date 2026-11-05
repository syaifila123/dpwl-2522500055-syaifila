<?php

class Manajemen_penyewa_controller extends Controller
{
  public function index(): void
  {
    // Memanggil helper autentikasi Admin
    require_once APPPATH . 'helpers/auth_helper.php';

    // Memastikan hanya Admin yang sudah login
    // dapat membuka halaman ini.
    require_admin_login();

    // Menampilkan halaman Manajemen Penyewa
    $this->view('admin/penyewa_view', [
      'username' => $_SESSION['admin_username']
    ]);
  }
}
