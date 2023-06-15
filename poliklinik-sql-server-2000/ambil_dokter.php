<?php

// koneksi database
include_once 'db.php';

// cek jika pengguna memilih no poli tertentu
if (isset($_GET['KDJABATAN'])) {

    // set parameter
    $KDJABATAN = $_GET['KDJABATAN'];

    // lakukan query inner join tabel untuk menentukan nama pemeriksa sesuai poli atau kdjabatan masing masing
    $stmt = $conn->prepare("SELECT pemeriksa.NAMAPEMERIKSA FROM pemeriksa
                            INNER JOIN jabpemeriksa ON pemeriksa.KDJABATAN = jabpemeriksa.KDJABATAN
                            WHERE jabpemeriksa.KDJABATAN = :KDJABATAN");

    // lakukan bind param
    $stmt->bindParam(":KDJABATAN", $KDJABATAN, PDO::PARAM_INT);

    // execute query
    $stmt->execute();

    // dapatkan hasil
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // cek jika hasilnya ada dalam tabel
    if (count($result) > 0) {

        // init output options
        $options = "";

        // looping data untuk mendapatkan nama dokter
        foreach ($result as $row) {
            $options .= "<option value='" . $row['NAMAPEMERIKSA'] . "'>" . $row['NAMAPEMERIKSA'] . "</option>";
        }

        // tampilkan 
        echo $options;
    } else {

        // untuk cek jika nama dokter tidak ada
        echo "<option>Tidak ada dokter yang tersedia</option>";
    }

    // tutup koneksi database microsoft sql server
    $conn = null;
}
