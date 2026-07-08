<?php
include "config.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Delete dengan prepared statement
    $query = "DELETE FROM buku WHERE id_buku = ?";
    
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?pesan=hapus");
            exit;
        } else {
            die("❌ Gagal menghapus data: " . mysqli_error($koneksi));
        }
    }
} else {
    header("Location: index.php");
    exit;
}
?>