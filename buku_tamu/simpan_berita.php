<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

include "db.php";

if (isset($_POST['simpan'])) {
    $judul_id = $_POST['judul_berita_indonesia'];
    $judul_en = $_POST['judul_berita_inggris'];
    $isi_id = $_POST['isi_berita_indonesia'];
    $isi_en = $_POST['isi_berita_inggris'];
    $ekstensi_diperbolehkan = array('png', 'jpg', 'pdf', 'zip');
    $nama = $_FILES['file']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    // File extension check
    if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
        if ($ukuran < 1048576) { // File size check
            move_uploaded_file($file_tmp, 'berkas/' . $nama);

            $hasil = mysqli_query($mysqli, "INSERT INTO berita VALUES (NULL, NOW(), '$judul_id', '$judul_en', '$isi_id', '$isi_en', '$nama', 'T')");
            
            if ($hasil) {
                echo 'Proses Upload File : Berhasil<br>';
                echo '<a href="index.php">Kembali Ke Halaman Berita</a>';
            } else {
                echo 'Proses Upload File : Gagal<br>';
                echo '<a href="index.php">Kembali Ke Halaman Berita</a><br>';
                echo '<a href="tambah_berita.html">Kembali Ke Form Tambah Berita</a>';
            }
        } else {
            echo 'Ukuran File Terlalu Besar';
        }
    } else {
        echo 'Ekstensi file tidak diperbolehkan';
    }
}
?>