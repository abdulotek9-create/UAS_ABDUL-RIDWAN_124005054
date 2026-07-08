<?php
include "config.php";

$data = [];
$error = "";

// Validasi ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Gunakan prepared statement untuk SELECT agar aman
    $query = "SELECT * FROM buku WHERE id_buku = ? LIMIT 1";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($hasil);

    if (!$data) {
        die("<div style='font-family:sans-serif; text-align:center; padding:50px;'>
             <h2>❌ Data buku tidak ditemukan!</h2>
             <a href='index.php' style='padding:10px 20px; background:#4f46e5; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Beranda</a>
             </div>");
    }
} else {
    header("Location: index.php");
    exit;
}

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_post = $_POST['id_buku'];
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul_buku'];
    $kategori = $_POST['kategori'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $halaman = $_POST['jumlah_halaman'];
    $stok = $_POST['stok'];

    $update = "UPDATE buku SET isbn=?, judul_buku=?, kategori=?, penulis=?, penerbit=?, tahun_terbit=?, jumlah_halaman=?, stok=? WHERE id_buku=?";
    
    if ($stmt_update = mysqli_prepare($koneksi, $update)) {
        mysqli_stmt_bind_param($stmt_update, "sssssiiii", $isbn, $judul, $kategori, $penulis, $penerbit, $tahun, $halaman, $stok, $id_post);
        
        if (mysqli_stmt_execute($stmt_update)) {
            header("Location: index.php?pesan=ubah");
            exit;
        } else {
            $error = "❌ Gagal memperbarui data: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt_update);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Buku - Sistem Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="header-title">Ubah Data Buku</h1>
            <p class="author-text">Perbarui informasi buku dengan teliti</p>

            <nav>
                <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
                <a href="tambah.php"><i class="fas fa-plus-circle"></i> Tambah Data Buku</a>
            </nav>

            <?php if ($error) echo "<div class='pesan gagal'>$error</div>"; ?>

            <form action="" method="POST">
                <input type="hidden" name="id_buku" value="<?php echo $data['id_buku']; ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nomor ISBN</label>
                        <input type="text" name="isbn" value="<?php echo htmlspecialchars($data['isbn']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Judul Buku</label>
                        <input type="text" name="judul_buku" value="<?php echo htmlspecialchars($data['judul_buku']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" required>
                            <option value="Teknologi" <?php echo ($data['kategori'] == 'Teknologi') ? 'selected' : ''; ?>>Teknologi / Informatika</option>
                            <option value="Sains" <?php echo ($data['kategori'] == 'Sains') ? 'selected' : ''; ?>>Sains</option>
                            <option value="Sastra" <?php echo ($data['kategori'] == 'Sastra') ? 'selected' : ''; ?>>Sastra & Fiksi</option>
                            <option value="Sejarah" <?php echo ($data['kategori'] == 'Sejarah') ? 'selected' : ''; ?>>Sejarah</option>
                            <option value="Umum" <?php echo ($data['kategori'] == 'Umum') ? 'selected' : ''; ?>>Umum</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Penulis Utama</label>
                        <input type="text" name="penulis" value="<?php echo htmlspecialchars($data['penulis']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Penerbit</label>
                        <input type="text" name="penerbit" value="<?php echo htmlspecialchars($data['penerbit']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" min="1900" max="2030" value="<?php echo $data['tahun_terbit']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Halaman</label>
                        <input type="number" name="jumlah_halaman" min="1" value="<?php echo $data['jumlah_halaman']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Stok Tersedia</label>
                        <input type="number" name="stok" min="0" value="<?php echo $data['stok']; ?>" required>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="tombol tombol-kembali"><i class="fas fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="tombol tombol-simpan"><i class="fas fa-sync-alt"></i> Perbarui Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>