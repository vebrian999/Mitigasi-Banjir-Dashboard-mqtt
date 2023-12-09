<?php
// Konfigurasi koneksi ke database
$host = "localhost"; // Ganti sesuai dengan host database Anda
$username = "root"; // Ganti sesuai dengan username database Anda
$password = ""; // Ganti sesuai dengan password database Anda
$database = "banjir"; // Ganti sesuai dengan nama database Anda

// Membuat koneksi
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil data dari database
$sql = "SELECT * FROM databanjir1"; // Ganti sesuai dengan nama tabel Anda
$result = $koneksi->query($sql);

// Menyimpan data dalam bentuk array
$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Menutup koneksi
$koneksi->close();

// Mengirimkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
