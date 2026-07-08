
<?php
// config.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan";

// Mengaktifkan mode exception untuk error reporting yang lebih baik (Standar Profesional)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = mysqli_connect($host, $user, $pass, $db);
    mysqli_set_charset($koneksi, "utf8mb4"); // Mendukung karakter modern
} catch (mysqli_sql_exception $e) {
    die("<div style='color:red; padding:20px; font-family:sans-serif;'>
            <b>Koneksi Database Gagal:</b> " . $e->getMessage() . 
        "</div>");
}
?>