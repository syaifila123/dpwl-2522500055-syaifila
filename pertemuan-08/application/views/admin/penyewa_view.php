<?php
require APPPATH . 'views/templates/header.php';
require APPPATH . 'views/templates/sidebar.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

  <!-- Judul Halaman -->
  <section class="content-header">
    <h1>
      Manajemen Penyewa
      <small>Kelola data penyewa</small>
    </h1>

    <ol class="breadcrumb">
      <li>
        <a href="<?= htmlspecialchars(
                    site_url('admin'),
                    ENT_QUOTES,
                    'UTF-8'
                  ) ?>">
          <i class="fa fa-dashboard"></i> Dashboard
        </a>
      </li>

      <li class="active">
        Manajemen Penyewa
      </li>
    </ol>
  </section>

  <!-- Isi Halaman -->
  <section class="content">

    <div class="box box-primary">

      <div class="box-header with-border">
        <h3 class="box-title">
          Data Penyewa
        </h3>
      </div>

      <div class="box-body">

        <div class="alert alert-info">
          <i class="fa fa-info-circle"></i>

          Halaman Manajemen Penyewa berhasil dibuka.
          Pengelolaan data penyewa akan dibuat
          pada tahap berikutnya.
        </div>

      </div>

    </div>

  </section>

</div>

<?php
require APPPATH . 'views/templates/footer.php';
?>