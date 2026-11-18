
<?php

class Pembayaran_model
{
  private mysqli $db;

  public function __construct()
  {
    global $db;
    $this->db = $db;
  }

  // Mengambil seluruh pembayaran DP milik penyewa
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

  // Memastikan pembayaran benar-benar milik penyewa
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

  // Memperbarui bukti pembayaran DP yang sudah dibuat saat checkout
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

    $stmt->bind_param(
      'sss',
      $namaFile,
      $kodeBayar,
      $userPlg
    );

    $berhasil = $stmt->execute()
      && $stmt->affected_rows === 1;

    $stmt->close();

    return $berhasil;
  }
}
