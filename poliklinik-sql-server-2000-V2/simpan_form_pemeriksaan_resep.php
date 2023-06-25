<?php

// Koneksi ke database
include_once 'db.php';

// Cek jika request nya itu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Mengambil data dari jQuery
    $imageData = $_POST['image'];
    $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);

    // Mengubah data base64 kembali ke format gambar
    $data = base64_decode($imageData);

    // Simpan ke folder img dalam nama gambar form-pemeriksaan-resep dan memberikan ID unik
    $file = 'img/form-pemeriksaan-resep-' . uniqid() . '.jpg';

    // Menyimpan gambar ke dalam folder server
    file_put_contents($file, $data);

    // Variabel untuk menambah data ke tabel soap
    $norm = $_POST['norm'];
    $resep_jpg = $file;

    // Ambil nilai maksimum dari kolom id pada tabel tbl_resep
    $stmt = $conn->prepare("SELECT MAX(id) AS max_id FROM tbl_resep");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $max_id = $result['max_id'];

    // Hitung nilai baru untuk primary key dengan menambahkan 1 pada nilai maksimum
    $new_id = $max_id + 1;

    // set timezone indonesia
    $tz = 'Asia/Jakarta';
    $dt = new DateTime("now", new DateTimeZone($tz));
    $tanggal = $dt->format('Y-m-d H:i:s');

    // lakukan insert
    $query = "INSERT INTO tbl_resep (id, norm, tanggal, file_resep) VALUES (:id, :norm, :tanggal, :file_resep)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $new_id);
    $stmt->bindParam(":norm", $norm);
    $stmt->bindParam(":tanggal", $tanggal);
    $stmt->bindParam(":file_resep", $resep_jpg);
    $stmt->execute();

    // Tutup koneksi database microsoft sql server
    $conn = null;

    // redirect HTTP/1.1 404 Not Found ketika pengguna mencoba mengakses file simpan_form_pemeriksaan.php
} else {
    header("HTTP/1.1 404 Not Found");
}
