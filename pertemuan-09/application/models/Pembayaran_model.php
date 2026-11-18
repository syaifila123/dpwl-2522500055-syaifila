<?php

class Pembayaran_model
{
  private mysqli $db;

  public function __construct(mysqli $db)
  {
    $this->db = $db;
  }

  public function getPembayaranByPenyewa(string $idPenyewa): array
  {
    $sql = "SELECT b.kode_bayar, b.tgl_wkt_byr, b.ft_byr, b.mtode_byr, b.jns_byr, 
                       b.nominal, b.sttus_byr, b.tgl_wkt_ver, b.kode_sewa,
                       s.tgl_sewa, s.total_bayar, s.status_sewa
                FROM t_bayar b
                INNER JOIN t_sewa s ON b.kode_sewa = s.kode_sewa
                WHERE s.id_penyewa = ? AND b.jns_byr = 'dp'
                ORDER BY s.tgl_sewa DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $idPenyewa);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function getDetailPembayaran(string $kodeBayar): ?array
  {
    $sql = "SELECT b.*, s.id_penyewa, s.tgl_sewa, s.total_bayar, s.status_sewa,
                       p.nm_penyewa, p.no_hp, p.email
                FROM t_bayar b
                INNER JOIN t_sewa s ON b.kode_sewa = s.kode_sewa
                INNER JOIN t_penyewa p ON s.id_penyewa = p.id_penyewa
                WHERE b.kode_bayar = ?
                LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $kodeBayar);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    return $row ?: null;
  }

  public function updateBuktiBayar(string $kodeBayar, string $namaFile): bool
  {
    $sql = "UPDATE t_bayar 
                SET ft_byr = ?, tgl_wkt_byr = NOW() 
                WHERE kode_bayar = ? AND sttus_byr = 'pending'";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("ss", $namaFile, $kodeBayar);
    $ok = $stmt->execute();

    return $ok && $stmt->affected_rows > 0;
  }

  public function getAllPembayaranAdmin(): array
  {
    $sql = "SELECT b.kode_bayar, b.tgl_wkt_byr, b.ft_byr, b.mtode_byr, b.jns_byr,
                       b.nominal, b.sttus_byr, b.tgl_wkt_ver, b.kode_sewa,
                       s.tgl_sewa, s.total_bayar, s.status_sewa,
                       p.nm_penyewa
                FROM t_bayar b
                INNER JOIN t_sewa s ON b.kode_sewa = s.kode_sewa
                INNER JOIN t_penyewa p ON s.id_penyewa = p.id_penyewa
                ORDER BY FIELD(b.sttus_byr, 'pending', 'valid', 'invalid'), b.tgl_wkt_byr DESC";

    $result = $this->db->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
  }

  public function verifikasiPembayaran(string $kodeBayar, string $kodeSewa, string $keputusan): bool
  {
    if ($keputusan === 'terima') {
      $statusBayar = 'valid';
      $statusSewa  = 'disetujui';
    } elseif ($keputusan === 'tolak') {
      $statusBayar = 'invalid';
      $statusSewa  = 'ditolak';
    } else {
      return false;
    }

    $this->db->begin_transaction();

    try {
      $sqlBayar = "UPDATE t_bayar 
                         SET sttus_byr = ?, tgl_wkt_ver = NOW() 
                         WHERE kode_bayar = ? AND sttus_byr = 'pending' AND ft_byr IS NOT NULL AND ft_byr != ''";
      $stmtBayar = $this->db->prepare($sqlBayar);
      $stmtBayar->bind_param("ss", $statusBayar, $kodeBayar);
      $stmtBayar->execute();

      if ($stmtBayar->affected_rows === 0) {
        throw new Exception("Data pembayaran tidak valid atau sudah diverifikasi.");
      }

      $sqlSewa = "UPDATE t_sewa SET status_sewa = ? WHERE kode_sewa = ?";
      $stmtSewa = $this->db->prepare($sqlSewa);
      $stmtSewa->bind_param("ss", $statusSewa, $kodeSewa);
      $stmtSewa->execute();

      $this->db->commit();
      return true;
    } catch (Throwable $e) {
      $this->db->rollback();
      return false;
    }
  }
}
