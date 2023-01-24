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

    // Simpan ke folder img dalam nama gambar form-pemeriksaan dan memberikan ID unik
    $file = 'img/form-pemeriksaan-' . uniqid() . '.jpg';

    // Menyimpan gambar ke dalam folder server
    file_put_contents($file, $data);

    // Variabel untuk menambah data ke tabel soap
    $norm = $_POST['norm'];
    $dir_jpg = $file;

    // set timezone indonesia
    $tz = 'Asia/Jakarta';
    $dt = new DateTime("now", new DateTimeZone($tz));
    $tanggal = $dt->format('Y-m-d H:i:s');

    // lakukan insert
    $query = "INSERT INTO tbl_soap (norm, tanggal, dir_jpg) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sss", $norm, $tanggal, $dir_jpg);
    $stmt->execute();

    // tutup koneksi mysql
    $stmt->close();

    // redirect HTTP/1.1 404 Not Found ketika pengguna mencoba mengakses file simpan_form_pemeriksaan.php
} else {
    header("HTTP/1.1 404 Not Found");
}
