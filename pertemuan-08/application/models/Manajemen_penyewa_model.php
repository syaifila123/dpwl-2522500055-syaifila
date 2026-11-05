
<?php

class Manajemen_penyewa_model
{
  private mysqli $db;

  public function __construct()
  {
    global $db;
    $this->db = $db;
  }

  // Mengambil seluruh data penyewa
  public function getAll(): array
  {
    $sql = "SELECT
                    user_plg,
                    nik,
                    nm_lngkp,
                    no_hp,
                    almt_lngkp,
                    ft_ktp,
                    ft_sim_a
                FROM t_penyewa
                ORDER BY user_plg ASC";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      throw new RuntimeException(
        'Query data penyewa gagal disiapkan.'
      );
    }

    if (!$stmt->execute()) {
      $stmt->close();

      throw new RuntimeException(
        'Data penyewa gagal diambil.'
      );
    }

    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $rows;
  }

  // Mengambil satu data penyewa berdasarkan username
  public function findByUserPlg(string $userPlg): ?array
  {
    $sql = "SELECT
                    user_plg,
                    nik,
                    nm_lngkp,
                    no_hp,
                    almt_lngkp,
                    ft_ktp,
                    ft_sim_a
                FROM t_penyewa
                WHERE user_plg = ?
                LIMIT 1";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      throw new RuntimeException(
        'Query pencarian penyewa gagal disiapkan.'
      );
    }

    $stmt->bind_param('s', $userPlg);

    if (!$stmt->execute()) {
      $stmt->close();

      throw new RuntimeException(
        'Pencarian data penyewa gagal.'
      );
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();

    return $row ?: null;
  }
}
