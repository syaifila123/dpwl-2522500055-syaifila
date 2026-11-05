
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
      throw new RuntimeException('Query data penyewa gagal disiapkan.');
    }

    if (!$stmt->execute()) {
      $stmt->close();
      throw new RuntimeException('Data penyewa gagal diambil.');
    }

    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $rows;
  }

  // Mencari data penyewa berdasarkan username
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
      throw new RuntimeException('Query pencarian gagal disiapkan.');
    }

    $stmt->bind_param('s', $userPlg);

    if (!$stmt->execute()) {
      $stmt->close();
      throw new RuntimeException('Pencarian data penyewa gagal.');
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();

    return $row ?: null;
  }

  // Menambahkan data penyewa
  // Password harus sudah di-hash oleh Controller
  public function create(array $data): bool
  {
    $sql = "INSERT INTO t_penyewa
                (user_plg, sandi, nik, nm_lngkp, no_hp,
                 almt_lngkp, ft_ktp, ft_sim_a)
                VALUES (?, ?, ?, ?, ?, ?, NULL, NULL)";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      throw new RuntimeException('Query tambah penyewa gagal disiapkan.');
    }

    $stmt->bind_param(
      'ssssss',
      $data['user_plg'],
      $data['sandi'],
      $data['nik'],
      $data['nm_lngkp'],
      $data['no_hp'],
      $data['almt_lngkp']
    );

    $success = $stmt->execute();
    $stmt->close();

    return $success;
  }

  // Mengubah data penyewa
  public function update(string $userPlg, array $data): bool
  {
    $sql = "UPDATE t_penyewa
                SET nik = ?,
                    nm_lngkp = ?,
                    no_hp = ?,
                    almt_lngkp = ?
                WHERE user_plg = ?";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      throw new RuntimeException('Query ubah penyewa gagal disiapkan.');
    }

    $stmt->bind_param(
      'sssss',
      $data['nik'],
      $data['nm_lngkp'],
      $data['no_hp'],
      $data['almt_lngkp'],
      $userPlg
    );

    $success = $stmt->execute();
    $stmt->close();

    return $success;
  }

  // Mengubah password penyewa
  // Password baru harus sudah di-hash oleh Controller
  public function updatePassword(string $userPlg, string $passwordHash): bool
  {
    $sql = "UPDATE t_penyewa
                SET sandi = ?
                WHERE user_plg = ?";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      throw new RuntimeException('Query password gagal disiapkan.');
    }

    $stmt->bind_param('ss', $passwordHash, $userPlg);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
  }

  // Menghapus data penyewa
  public function delete(string $userPlg): bool
  {
    $sql = "DELETE FROM t_penyewa
                WHERE user_plg = ?";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      throw new RuntimeException('Query hapus penyewa gagal disiapkan.');
    }

    $stmt->bind_param('s', $userPlg);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
  }
}
