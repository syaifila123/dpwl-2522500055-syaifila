<?php
require APPPATH . 'views/katalog/header.php';

$e = static function ($nilai): string {
  return htmlspecialchars(
    (string) ($nilai ?? ''),
    ENT_QUOTES,
    'UTF-8'
  );
};

$rupiah = static function ($nilai): string {
  return 'Rp ' . number_format(
    (float) $nilai,
    0,
    ',',
    '.'
  );
};

require APPPATH . 'views/katalog/navbar.php';

$pembayaran = $pembayaran ?? [];
?>

<section class="bg-success py-4">
  <div class="container">
    <h1 class="h2 text-white mt-3">Pembayaran Penyewaan</h1>
    <p class="text-white mb-0">
      Informasi pembayaran uang muka dan bukti transfer.
    </p>
  </div>
</section>

<section class="container py-5">

  <?php if (!empty($flash)): ?>
    <div class="alert alert-<?= $e($flash['jenis'] ?? 'info') ?>">
      <?= $e($flash['pesan'] ?? '') ?>
    </div>
  <?php endif; ?>

  <h3 class="mb-4">Daftar Pembayaran DP</h3>

  <?php if (empty($pembayaran)): ?>

    <div class="alert alert-info">
      Belum ada data pembayaran.
      Silakan lakukan checkout terlebih dahulu.
    </div>

  <?php else: ?>

    <?php foreach ($pembayaran as $bayar): ?>

      <div class="card shadow-sm mb-4">
        <div class="card-body">

          <div class="d-flex justify-content-between flex-wrap">
            <div>
              <h5>
                <?= $e($bayar['kode_bayar']) ?>
              </h5>

              <small class="text-muted">
                Transaksi: <?= $e($bayar['kode_sewa']) ?>
              </small>
            </div>

            <?php
            $status = $bayar['sttus_byr'];

            $warna = [
              'pending' => 'warning',
              'valid' => 'success',
              'invalid' => 'danger'
            ];
            ?>

            <span class="badge bg-<?= $warna[$status] ?? 'secondary' ?>">
              <?= strtoupper($e($status)) ?>
            </span>
          </div>

          <hr>

          <div class="row">

            <div class="col-md-6">
              <p>
                <strong>Nama Penyewa:</strong><br>
                <?= $e($bayar['nm_lngkp']) ?>
              </p>

              <p>
                <strong>Tanggal Mulai:</strong><br>
                <?= $e($bayar['tgl_mulai']) ?>
              </p>

              <p>
                <strong>Tanggal Selesai:</strong><br>
                <?= $e($bayar['tgl_selesai']) ?>
              </p>

              <p>
                <strong>Total Transaksi:</strong><br>
                <?= $rupiah($bayar['total_transaksi']) ?>
              </p>
            </div>

            <div class="col-md-6">
              <p>
                <strong>Jenis Pembayaran:</strong><br>
                Uang Muka (DP)
              </p>

              <p>
                <strong>Metode Pembayaran:</strong><br>
                <?= ucfirst($e($bayar['mtode_byr'])) ?>
              </p>

              <p>
                <strong>Nominal DP:</strong><br>
                <span class="text-success fw-bold">
                  <?= $rupiah($bayar['nominal']) ?>
                </span>
              </p>

              <p>
                <strong>Waktu Pembayaran:</strong><br>
                <?= $e($bayar['tgl_wkt_byr']) ?>
              </p>
            </div>

          </div>

          <hr>

          <?php if (!empty($bayar['ft_byr'])): ?>

            <p class="fw-bold">Bukti Transfer:</p>

            <a
              href="<?= $e(site_url(
                      'pembayaran/bukti/' .
                        rawurlencode($bayar['kode_bayar'])
                    )) ?>"
              target="_blank"
              rel="noopener">
              Lihat Bukti Pembayaran
            </a>

            <?php if ($status === 'pending'): ?>
              <div class="alert alert-warning mt-3 mb-0">
                Bukti berhasil dikirim.
                Silakan menunggu verifikasi admin.
              </div>
            <?php endif; ?>

          <?php elseif ($status === 'pending'): ?>

            <div class="alert alert-info">
              Silakan transfer sesuai nominal DP dan unggah
              bukti pembayaran.
            </div>

            <form
              action="<?= $e(site_url('pembayaran/upload')) ?>"
              method="post"
              enctype="multipart/form-data">

              <input
                type="hidden"
                name="kode_bayar"
                value="<?= $e($bayar['kode_bayar']) ?>">

              <div class="mb-3">
                <label class="form-label">
                  Upload Bukti Transfer
                </label>

                <input
                  type="file"
                  name="ft_byr"
                  class="form-control"
                  accept=".jpg,.jpeg,.png,.webp"
                  required>

                <small class="text-muted">
                  Format JPG, PNG, WEBP. Maksimal 2 MB.
                </small>
              </div>

              <button
                type="submit"
                class="btn btn-success">
                Upload Bukti Pembayaran
              </button>

            </form>

          <?php elseif ($status === 'valid'): ?>

            <div class="alert alert-success mb-0">
              Pembayaran telah diterima dan diverifikasi admin.
            </div>

          <?php else: ?>

            <div class="alert alert-danger mb-0">
              Pembayaran ditolak oleh admin.
            </div>

          <?php endif; ?>

        </div>
      </div>

    <?php endforeach; ?>

  <?php endif; ?>

  <a
    href="<?= $e(site_url('katalog')) ?>"
    class="btn btn-secondary">
    Kembali ke Katalog
  </a>

</section>

<?php require APPPATH . 'views/katalog/footer.php'; ?>