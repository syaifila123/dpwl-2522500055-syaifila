<?php
require APPPATH . 'views/templates/header.php';
require APPPATH . 'views/templates/sidebar.php';

$pembayaran = $pembayaran ?? [];
$flash = $flash ?? null;

function amanVerifikasi($nilai): string
{
  return htmlspecialchars(
    (string) ($nilai ?? ''),
    ENT_QUOTES,
    'UTF-8'
  );
}

function rupiahVerifikasi($nilai): string
{
  return 'Rp ' . number_format(
    (float) $nilai,
    0,
    ',',
    '.'
  );
}
?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Verifikasi Pembayaran
      <small>Kelola pembayaran awal penyewa</small>
    </h1>

    <ol class="breadcrumb">
      <li>
        <a href="<?= htmlspecialchars(site_url('admin'), ENT_QUOTES, 'UTF-8') ?>">
          <i class="fa fa-dashboard"></i> Dashboard
        </a>
      </li>
      <li class="active">Verifikasi Pembayaran</li>
    </ol>
  </section>

  <section class="content">

    <?php if (!empty($flash)): ?>
      <div class="alert alert-<?= amanVerifikasi($flash['jenis'] ?? 'info') ?> alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">
          &times;
        </button>

        <?= amanVerifikasi($flash['pesan'] ?? '') ?>
      </div>
    <?php endif; ?>

    <div class="box box-primary">

      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Pembayaran Menunggu Verifikasi
        </h3>
      </div>

      <div class="box-body table-responsive">

        <?php if (empty($pembayaran)): ?>

          <div class="alert alert-info">
            Belum ada pembayaran yang menunggu verifikasi.
          </div>

        <?php else: ?>

          <table class="table table-bordered table-striped">

            <thead>
              <tr>
                <th>No.</th>
                <th>Kode Pembayaran</th>
                <th>Data Penyewa</th>
                <th>Kode Sewa</th>
                <th>Periode Sewa</th>
                <th>Nominal DP</th>
                <th>Tanggal Upload</th>
                <th>Bukti Transfer</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>

              <?php foreach ($pembayaran as $i => $item): ?>

                <?php
                $kodeBayar = (string) ($item['kode_bayar'] ?? '');

                $urlBukti = site_url('admin/verifikasi/bukti')
                  . '?kode_bayar='
                  . rawurlencode($kodeBayar);
                ?>

                <tr>
                  <td><?= $i + 1 ?></td>

                  <td>
                    <?= amanVerifikasi($kodeBayar) ?>
                  </td>

                  <td>
                    <strong>
                      <?= amanVerifikasi($item['nm_lngkp'] ?? '') ?>
                    </strong>
                    <br>
                    <small>
                      Username:
                      <?= amanVerifikasi($item['user_plg'] ?? '') ?>
                    </small>
                  </td>

                  <td>
                    <?= amanVerifikasi($item['kode_sewa'] ?? '') ?>
                  </td>

                  <td>
                    <?= amanVerifikasi($item['tgl_mulai'] ?? '') ?>
                    sampai
                    <?= amanVerifikasi($item['tgl_selesai'] ?? '') ?>
                    <br>
                    <small>
                      Jam ambil:
                      <?= amanVerifikasi($item['wkt_ambil'] ?? '') ?>
                    </small>
                  </td>

                  <td>
                    <strong>
                      <?= rupiahVerifikasi($item['nominal'] ?? 0) ?>
                    </strong>
                  </td>

                  <td>
                    <?= amanVerifikasi($item['tgl_wkt_byr'] ?? '') ?>
                  </td>

                  <td>
                    <?php if (!empty($item['ft_byr'])): ?>

                      <a
                        href="<?= amanVerifikasi($urlBukti) ?>"
                        target="_blank"
                        class="btn btn-info btn-sm">
                        <i class="fa fa-image"></i>
                        Lihat Bukti
                      </a>

                    <?php else: ?>

                      <span class="text-muted">
                        Belum ada bukti
                      </span>

                    <?php endif; ?>
                  </td>

                  <td>
                    <span class="label label-warning">
                      Menunggu Verifikasi
                    </span>
                  </td>

                  <td style="min-width: 150px;">

                    <form
                      action="<?= htmlspecialchars(site_url('admin/verifikasi/proses'), ENT_QUOTES, 'UTF-8') ?>"
                      method="POST"
                      style="margin-bottom: 5px;"
                      onsubmit="return confirm('Yakin ingin menerima pembayaran ini?');">

                      <input
                        type="hidden"
                        name="kode_bayar"
                        value="<?= amanVerifikasi($kodeBayar) ?>">

                      <input
                        type="hidden"
                        name="keputusan"
                        value="terima">

                      <button
                        type="submit"
                        class="btn btn-success btn-sm btn-block">
                        <i class="fa fa-check"></i>
                        Terima
                      </button>

                    </form>

                    <form
                      action="<?= htmlspecialchars(site_url('admin/verifikasi/proses'), ENT_QUOTES, 'UTF-8') ?>"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menolak pembayaran ini?');">

                      <input
                        type="hidden"
                        name="kode_bayar"
                        value="<?= amanVerifikasi($kodeBayar) ?>">

                      <input
                        type="hidden"
                        name="keputusan"
                        value="tolak">

                      <button
                        type="submit"
                        class="btn btn-danger btn-sm btn-block">
                        <i class="fa fa-times"></i>
                        Tolak
                      </button>

                    </form>

                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>

          </table>

        <?php endif; ?>

      </div>

    </div>

  </section>

</div>

<?php require APPPATH . 'views/templates/footer.php'; ?>