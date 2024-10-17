<?php
session_start();


if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
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

    // Check if the file extension is allowed
    if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
        // Upload file with size less than 1MB
        if ($ukuran < 1048576) {
            move_uploaded_file($file_tmp, 'berkas/' . $nama);

            // Query to save news data into the database
            $hasil = mysqli_query($mysqli, "INSERT INTO berita (waktu_simpan, judul_id, judul_en, isi_id, isi_en, nama_file, dihapus) VALUES (NOW(), '$judul_id', '$judul_en', '$isi_id', '$isi_en', '$nama', 'T')");

            if ($hasil) {
                echo 'Proses Upload File: Berhasil<br>';
                echo '<a href="index.php">Kembali Ke Halaman Berita</a>';
            } else {
                echo 'Proses Upload File: Gagal<br>';
                echo '<a href="index.php">Kembali Ke Halaman Berita</a><br>';
                echo '<a href="tambah_berita.php">Kembali Ke Form Tambah Berita</a>';
            }
        } else {
            echo 'Ukuran File Terlalu Besar';
        }
    } else {
        echo 'Ekstensi file tidak diperbolehkan';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
</head>
<body>
    <center>
        <h1>FORM TAMBAH BERITA</h1>
        <h2>UNIKOM NEWS</h2>
        <hr>
        <form action="tambah_berita.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Judul Berita Bahasa Indonesia</td>
                    <td><input type="text" name="judul_berita_indonesia" size="50" required></td>
                </tr>
                <tr>
                    <td>Judul Berita Bahasa Inggris</td>
                    <td><input type="text" name="judul_berita_inggris" size="50" required></td>
                </tr>
                <tr>
                    <td>Isi Berita Bahasa Indonesia</td>
                    <td><textarea rows="10" cols="50" name="isi_berita_indonesia" maxlength="1000" required></textarea></td>
                </tr>
                <tr>
                    <td>Isi Berita Bahasa Inggris</td>
                    <td><textarea rows="10" cols="50" name="isi_berita_inggris" maxlength="1000" required></textarea></td>
                </tr>
                <tr>
                    <td>File Pendukung</td>
                    <td><input type="file" name="file" required></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Simpan" name="simpan">
            <input type="reset" value="Reset">
        </form>
    </center>
</body>
</html>