
<?php

class Pembayaran_model
{
  private mysqli $db;

  public function __construct()
  {
    global $db;
    $this->db = $db;
  }

  // =========================================
  // FUNGSI PEMBAYARAN PENYEWA (TAHAP 2)
  // =========================================

  public function getByPenyewa(string $userPlg): array
  {
    $sql = "SELECT
              b.kode_bayar,
              b.tgl_wkt_byr,
              b.ft_byr,
              b.mtode_byr,
              b.jns_byr,
              b.nominal,
              b.sttus_byr,
              b.tgl_wkt_ver,
              b.kode_sewa,
              s.tgl_mulai,
              s.tgl_selesai,
              s.wkt_ambil,
              s.status_sewa,
              p.nm_lngkp,
              (
                SELECT COALESCE(SUM(tp.hrg_sewa * tp.n_hari), 0)
                FROM t_pilih tp
                WHERE tp.kode_sewa = b.kode_sewa
              ) AS total_transaksi
            FROM t_bayar b
            INNER JOIN t_sewa s
              ON s.kode_sewa = b.kode_sewa
            INNER JOIN t_penyewa p
              ON p.user_plg = s.user_plg
            WHERE s.user_plg = ?
              AND b.jns_byr = 'dp'
            ORDER BY b.tgl_wkt_byr DESC";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      throw new RuntimeException('Query pembayaran gagal disiapkan.');
    }

    $stmt->bind_param('s', $userPlg);
    $stmt->execute();

    $hasil = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $hasil;
  }

  public function findByKodeBayar(
    string $kodeBayar,
    string $userPlg
  ): ?array {

    $stmt = $this->db->prepare(
      "SELECT b.*
       FROM t_bayar b
       INNER JOIN t_sewa s
         ON s.kode_sewa = b.kode_sewa
       WHERE b.kode_bayar = ?
         AND s.user_plg = ?
         AND b.jns_byr = 'dp'
       LIMIT 1"
    );

    if (!$stmt) {
      throw new RuntimeException('Pemeriksaan pembayaran gagal.');
    }

    $stmt->bind_param('ss', $kodeBayar, $userPlg);
    $stmt->execute();

    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $data ?: null;
  }

  public function updateBukti(
    string $kodeBayar,
    string $userPlg,
    string $namaFile
  ): bool {

    $stmt = $this->db->prepare(
      "UPDATE t_bayar b
       INNER JOIN t_sewa s
         ON s.kode_sewa = b.kode_sewa
       SET
         b.ft_byr = ?,
         b.tgl_wkt_byr = NOW()
       WHERE b.kode_bayar = ?
         AND s.user_plg = ?
         AND b.jns_byr = 'dp'
         AND b.mtode_byr = 'transfer'
         AND b.sttus_byr = 'pending'
         AND b.ft_byr IS NULL"
    );

    if (!$stmt) {
      throw new RuntimeException('Update bukti pembayaran gagal disiapkan.');
    }

    $stmt->bind_param('sss', $namaFile, $kodeBayar, $userPlg);

    $berhasil = $stmt->execute()
      && $stmt->affected_rows === 1;

    $stmt->close();

    return $berhasil;
  }

  // =========================================
  // FUNGSI VERIFIKASI ADMIN (TAHAP 3)
  // =========================================

  // Mengambil pembayaran DP yang sudah memiliki bukti
  // dan masih menunggu verifikasi.
  public function getMenungguVerifikasi(): array
  {
    $sql = "SELECT
              b.kode_bayar,
              b.kode_sewa,
              b.tgl_wkt_byr,
              b.ft_byr,
              b.mtode_byr,
              b.jns_byr,
              b.nominal,
              b.sttus_byr,
              p.user_plg,
              p.nm_lngkp,
              s.tgl_mulai,
              s.tgl_selesai,
              s.wkt_ambil,
              s.status_sewa
            FROM t_bayar b
            INNER JOIN t_sewa s
              ON s.kode_sewa = b.kode_sewa
            INNER JOIN t_penyewa p
              ON p.user_plg = s.user_plg
            WHERE b.jns_byr = 'dp'
              AND b.mtode_byr = 'transfer'
              AND b.sttus_byr = 'pending'
              AND b.ft_byr IS NOT NULL
              AND b.ft_byr <> ''
            ORDER BY b.tgl_wkt_byr DESC";

    $hasil = $this->db->query($sql);

    if (!$hasil) {
      throw new RuntimeException('Data verifikasi gagal diambil.');
    }

    return $hasil->fetch_all(MYSQLI_ASSOC);
  }

  // Mengambil bukti pembayaran berdasarkan kode pembayaran.
  public function getBuktiByKodeBayar(string $kodeBayar): ?array
  {
    $stmt = $this->db->prepare(
      "SELECT kode_bayar, ft_byr, sttus_byr
       FROM t_bayar
       WHERE kode_bayar = ?
         AND jns_byr = 'dp'
       LIMIT 1"
    );

    if (!$stmt) {
      throw new RuntimeException('Data bukti pembayaran gagal disiapkan.');
    }

    $stmt->bind_param('s', $kodeBayar);
    $stmt->execute();

    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $data ?: null;
  }

  // Memproses penerimaan atau penolakan pembayaran.
  // Seluruh perubahan dilakukan dalam satu transaksi database.
  public function verifikasiPembayaran(
    string $kodeBayar,
    string $keputusan
  ): bool {

    if (!in_array($keputusan, ['terima', 'tolak'], true)) {
      return false;
    }

    $statusBayar = $keputusan === 'terima'
      ? 'valid'
      : 'invalid';

    $statusSewa = $keputusan === 'terima'
      ? 'disetujui'
      : 'ditolak';

    $this->db->begin_transaction();

    try {
      // Kunci record agar tidak diverifikasi bersamaan.
      $stmt = $this->db->prepare(
        "SELECT kode_sewa, ft_byr
         FROM t_bayar
         WHERE kode_bayar = ?
           AND jns_byr = 'dp'
           AND mtode_byr = 'transfer'
           AND sttus_byr = 'pending'
           AND ft_byr IS NOT NULL
           AND ft_byr <> ''
         LIMIT 1
         FOR UPDATE"
      );

      if (!$stmt) {
        throw new RuntimeException('Pemeriksaan verifikasi gagal.');
      }

      $stmt->bind_param('s', $kodeBayar);
      $stmt->execute();

      $data = $stmt->get_result()->fetch_assoc();
      $stmt->close();

      if (!$data) {
        $this->db->rollback();
        return false;
      }

      $kodeSewa = $data['kode_sewa'];

      // Perbarui status pembayaran dan waktu verifikasi.
      $stmtBayar = $this->db->prepare(
        "UPDATE t_bayar
         SET sttus_byr = ?,
             tgl_wkt_ver = NOW()
         WHERE kode_bayar = ?
           AND sttus_byr = 'pending'
           AND ft_byr IS NOT NULL
           AND ft_byr <> ''"
      );

      if (!$stmtBayar) {
        throw new RuntimeException('Update pembayaran gagal disiapkan.');
      }

      $stmtBayar->bind_param('ss', $statusBayar, $kodeBayar);

      if (!$stmtBayar->execute() || $stmtBayar->affected_rows !== 1) {
        $stmtBayar->close();
        throw new RuntimeException('Status pembayaran gagal diperbarui.');
      }

      $stmtBayar->close();

      // Perbarui status transaksi sewa.
      $stmtSewa = $this->db->prepare(
        "UPDATE t_sewa
         SET status_sewa = ?
         WHERE kode_sewa = ?"
      );

      if (!$stmtSewa) {
        throw new RuntimeException('Update transaksi gagal disiapkan.');
      }

      $stmtSewa->bind_param('ss', $statusSewa, $kodeSewa);

      if (!$stmtSewa->execute() || $stmtSewa->affected_rows !== 1) {
        $stmtSewa->close();
        throw new RuntimeException('Status transaksi gagal diperbarui.');
      }

      $stmtSewa->close();

      $this->db->commit();

      return true;
    } catch (Throwable $e) {
      $this->db->rollback();
      throw $e;
    }
  }
}
