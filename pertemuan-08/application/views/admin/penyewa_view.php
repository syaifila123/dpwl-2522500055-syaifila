<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';

$penyewa = $penyewa ?? [];
$judul = $judul ?? 'Manajemen Data Penyewa';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

  <!-- Judul Halaman -->
  <section class="content-header">
    <h1>
      <?= htmlspecialchars($judul, ENT_QUOTES, 'UTF-8') ?>
      <small>Kelola data penyewa</small>
    </h1>

    <ol class="breadcrumb">
      <li>
        <a href="<?= htmlspecialchars(site_url('admin'), ENT_QUOTES, 'UTF-8') ?>">
          <i class="fa fa-dashboard"></i> Dashboard
        </a>
      </li>
      <li class="active">Manajemen Penyewa</li>
    </ol>
  </section>

  <section class="content">

    <!-- Form Tambah Penyewa -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Form Tambah Data Penyewa</h3>
      </div>

      <form method="POST"
        action="<?= htmlspecialchars(site_url('admin/penyewa/tambah'), ENT_QUOTES, 'UTF-8') ?>"
        enctype="multipart/form-data">

        <div class="box-body">

          <div class="form-group">
            <label>Username Penyewa</label>
            <input type="text"
              name="user_plg"
              class="form-control"
              maxlength="15"
              placeholder="Masukkan username penyewa"
              required>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password"
              name="sandi"
              class="form-control"
              minlength="8"
              placeholder="Masukkan password"
              autocomplete="new-password"
              required>
          </div>

          <div class="form-group">
            <label>NIK</label>
            <input type="text"
              name="nik"
              class="form-control"
              maxlength="16"
              pattern="[0-9]{16}"
              placeholder="Masukkan 16 digit NIK"
              required>
          </div>

          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text"
              name="nm_lngkp"
              class="form-control"
              maxlength="100"
              placeholder="Masukkan nama lengkap"
              required>
          </div>

          <div class="form-group">
            <label>Nomor HP</label>
            <input type="tel"
              name="no_hp"
              class="form-control"
              maxlength="15"
              placeholder="Masukkan nomor HP"
              required>
          </div>

          <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea name="almt_lngkp"
              class="form-control"
              rows="3"
              maxlength="300"
              placeholder="Masukkan alamat lengkap"
              required></textarea>
          </div>

          <div class="form-group">
            <label>Foto KTP</label>
            <input type="file"
              name="ft_ktp"
              class="form-control"
              accept=".jpg,.jpeg,.png,.webp">
            <small class="text-muted">
              Format JPG, JPEG, PNG, atau WEBP.
            </small>
          </div>

          <div class="form-group">
            <label>Foto SIM A</label>
            <input type="file"
              name="ft_sim_a"
              class="form-control"
              accept=".jpg,.jpeg,.png,.webp">
            <small class="text-muted">
              Format JPG, JPEG, PNG, atau WEBP.
            </small>
          </div>

        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan Data
          </button>
        </div>

      </form>
    </div>

    <!-- Tabel Data Penyewa -->
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Daftar Data Penyewa</h3>
      </div>

      <div class="box-body">
        <div class="table-responsive">

          <table class="table table-bordered table-striped js-data-table">

            <thead>
              <tr>
                <th>No</th>
                <th>Username</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Nomor HP</th>
                <th>Alamat Lengkap</th>
                <th>Foto KTP</th>
                <th>Foto SIM A</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>

              <?php if (!empty($penyewa)): ?>

                <?php $no = 1; ?>

                <?php foreach ($penyewa as $p): ?>

                  <tr>
                    <td><?= $no++ ?></td>

                    <td>
                      <?= htmlspecialchars($p['user_plg'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($p['nik'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($p['nm_lngkp'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($p['no_hp'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($p['almt_lngkp'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($p['ft_ktp'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($p['ft_sim_a'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <!-- Tombol Aksi -->
                    <td>
                      <a href="#"
                        class="btn btn-warning btn-sm"
                        title="Edit Data">
                        <i class="fa fa-edit"></i> Edit
                      </a>

                      <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="alert('Fungsi hapus akan diaktifkan pada bagian berikutnya.')">
                        <i class="fa fa-trash"></i> Hapus
                      </button>
                    </td>

                  </tr>

                <?php endforeach; ?>

              <?php else: ?>

                <tr>
                  <td colspan="9" class="text-center">
                    Data penyewa belum tersedia.
                  </td>
                </tr>

              <?php endif; ?>

            </tbody>

          </table>

        </div>
      </div>
    </div>

  </section>
</div>

<?php
require APPPATH . '/views/templates/footer.php';
?>