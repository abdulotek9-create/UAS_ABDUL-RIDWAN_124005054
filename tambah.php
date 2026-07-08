<?php
include "config.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul_buku'];
    $kategori = $_POST['kategori'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $halaman = $_POST['jumlah_halaman'];
    $stok = $_POST['stok'];

    // Menggunakan Prepared Statement (Standar Keamanan Profesional)
    $query = "INSERT INTO buku (isbn, judul_buku, kategori, penulis, penerbit, tahun_terbit, jumlah_halaman, stok) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        mysqli_stmt_bind_param($stmt, "sssssiii", $isbn, $judul, $kategori, $penulis, $penerbit, $tahun, $halaman, $stok);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?pesan=simpan");
            exit;
        } else {
            $error = "❌ Gagal menyimpan data: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "❌ Kesalahan sistem (Query Error).";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Sistem Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="header-title">Form Tambah Buku</h1>
            <p class="author-text">Lengkapi detail buku di bawah ini</p>

            <nav>
                <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
                <a href="tambah.php" class="active"><i class="fas fa-plus-circle"></i> Tambah Data Buku</a>
            </nav>

            <?php if ($error) echo "<div class='pesan gagal'>$error</div>"; ?>

            <form action="" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nomor ISBN</label>
                        <input type="text" name="isbn" placeholder="Contoh: 978-602-..." required>
                    </div>
                    <div class="form-group">
                        <label>Judul Buku</label>
                        <input type="text" name="judul_buku" placeholder="Masukkan judul lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Teknologi">Teknologi / Informatika</option>
                            <option value="Sains">Sains</option>
                            <option value="Sastra">Sastra & Fiksi</option>
                            <option value="Sejarah">Sejarah</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Penulis Utama</label>
                        <input type="text" name="penulis" placeholder="Nama Penulis" required>
                    </div>
                    <div class="form-group">
                        <label>Penerbit</label>
                        <input type="text" name="penerbit" placeholder="Nama Penerbit" required>
                    </div>
                    <div class="form-group">
                        <label>Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" min="1900" max="2030" placeholder="YYYY" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Halaman</label>
                        <input type="number" name="jumlah_halaman" min="1" placeholder="Contoh: 250" required>
                    </div>
                    <div class="form-group">
                        <label>Stok Tersedia</label>
                        <input type="number" name="stok" min="0" placeholder="Jumlah fisik buku" required>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" class="tombol tombol-kembali"><i class="fas fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="tombol tombol-simpan"><i class="fas fa-save"></i> Simpan Data Buku</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>