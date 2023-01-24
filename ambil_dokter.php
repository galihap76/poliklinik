<?php

// koneksi database
include_once 'db.php';

// cek jika pengguna memilih no poli tertentu
if (isset($_GET['no_poli'])) {

    // set parameter
    $no_poli = $_GET['no_poli'];

    // lakukan query inner join tabel untuk menentukan nama dokter sesuai poli masing masing
    $stmt = $db->prepare("SELECT tbl_dokter.nm_dokter FROM tbl_dokter
                              INNER JOIN tbl_poliklinik ON tbl_dokter.no_poli = tbl_poliklinik.no_poli
                              WHERE tbl_poliklinik.no_poli = ?");

    // lakukan bind param
    $stmt->bind_param("i", $no_poli);

    // execute query
    $stmt->execute();

    // dapatkan hasil
    $result = $stmt->get_result();

    // cek jika hasilnya ada dalam tabel
    if ($result->num_rows > 0) {

        // init output options
        $options = "";

        // looping data untuk mendapatkan nama dokter
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['nm_dokter'] . "'>" . $row['nm_dokter'] . "</option>";
        }

        // tampilkan 
        echo $options;
    } else {

        // untuk cek jika nama dokter tidak ada
        echo "<option>Tidak ada dokter yang tersedia</option>";
    }

    // tutup koneksi mysql
    $stmt->close();
}
