<?php
include "config.php";

$no = 1;

$query = "SELECT * FROM buku ORDER BY id_buku DESC";
$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("<div style='color:red; padding:20px; font-family:sans-serif;'>" .
        "<b>Gagal mengambil data:</b> " . mysqli_error($koneksi) .
        "</div>");
}

$pesan = $_GET['pesan'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan - Sistem Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="header-title">Sistem Perpustakaan</h1>
            <p class="author-text">Kelola data buku dengan cepat dan rapi</p>

            <nav>
                <a href="index.php" class="active"><i class="fas fa-book"></i> Data Buku</a>
                <a href="tambah.php"><i class="fas fa-plus-circle"></i> Tambah Data Buku</a>
            </nav>

            <?php if ($pesan === 'simpan'): ?>
                <div class="pesan sukses">✅ Data buku berhasil disimpan!</div>
            <?php elseif ($pesan === 'ubah'): ?>
                <div class="pesan sukses">✅ Data buku berhasil diperbarui!</div>
            <?php elseif ($pesan === 'hapus'): ?>
                <div class="pesan sukses">✅ Data buku berhasil dihapus!</div>
            <?php endif; ?>

            <div style="overflow:auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:70px;">No</th>
                            <th>ISBN</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th style="width:160px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><strong><?php echo htmlspecialchars($data['isbn'] ?? '-'); ?></strong></td>
                                <td><?php echo htmlspecialchars($data['judul_buku']); ?></td>
                                <td><span class="badge"><?php echo htmlspecialchars($data['kategori'] ?? 'Umum'); ?></span></td>
                                <td><?php echo htmlspecialchars($data['penulis']); ?></td>
                                <td><?php echo $data['tahun_terbit']; ?></td>
                                <td><?php echo ($data['stok'] ?? 0); ?> unit</td>
                                <td style="text-align:center; white-space: nowrap;">
                                    <a href="edit.php?id=<?php echo $data['id_buku']; ?>" class="tombol tombol-ubah" title="Edit Data"><i class="fas fa-edit"></i></a>
                                    <a href="hapus.php?id=<?php echo $data['id_buku']; ?>" class="tombol tombol-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.')" title="Hapus Data"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if (mysqli_num_rows($result) === 0) { ?>
                            <tr>
                                <td colspan="8" style="text-align:center; padding:20px;">Tidak ada data buku.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>
</html>

