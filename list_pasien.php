<?php
session_start();

// Koneksi ke database
include_once 'db.php';

// $_SESSION['nm_dokter'] .= $_POST['nm_dokter'];

// Jika no poli belum di pilih
if (!isset($_SESSION['no_poli'])) {

    // Paksa pengguna alihkan ke index.php
    echo "
		<script>
		alert('Anda harus memilih poli!');
		document.location.href='index.php';
		</script>
		";
}

// Lakukan query tabel pasien
$sql = "SELECT * FROM tbl_pasien";
$res = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>List Pasien</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .soap {
            background-color: orangered;
        }

        .soap:hover {
            background-color: red;
        }
    </style>
</head>

<body>

    <!--  Navbar    -->
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <h4 class="ps-3 pe-3 text-white"><i class="bi bi-person-lines-fill"></i> List Pasien</h4>
    </nav>
    <!--  </Akhir navbar  -->

    <!-- Main content -->
    <div id="Maincontent">
        <main>
            <div class="container">
                <div class="card mb-4 border-success justify-content-center mt-5">
                    <div class="card-body bg-success text-white text-center fs-5">Daftar Kunjungan Pasien Rawat Jalan</div>
                    <div class="row">
                        <div class="col">

                            <!-- Hari dan tanggal -->
                            <?php

                            $hari = date("D");

                            switch ($hari) {
                                case 'Sun':
                                    $hari_ini = "Minggu";
                                    break;

                                case 'Mon':
                                    $hari_ini = "Senin";
                                    break;

                                case 'Tue':
                                    $hari_ini = "Selasa";
                                    break;

                                case 'Wed':
                                    $hari_ini = "Rabu";
                                    break;

                                case 'Thu':
                                    $hari_ini = "Kamis";
                                    break;

                                case 'Fri':
                                    $hari_ini = "Jumat";
                                    break;

                                case 'Sat':
                                    $hari_ini = "Sabtu";
                                    break;

                                default:
                                    $hari_ini = "Tidak di ketahui";
                                    break;
                            }

                            function tgl_indo($tanggal)
                            {
                                $bulan = array(
                                    1 =>   'Januari',
                                    'Februari',
                                    'Maret',
                                    'April',
                                    'Mei',
                                    'Juni',
                                    'Juli',
                                    'Agustus',
                                    'September',
                                    'Oktober',
                                    'November',
                                    'Desember'
                                );
                                $pecahkan = explode('-', $tanggal);

                                return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
                            }

                            $date = tgl_indo(date('Y-m-d')); // Tanggal, bulan dan tahun sekarang ini
                            ?>

                            <!-- </Akhir hari dan tanggal -->

                            <div class="ms-3 align-items-center justify-content-between bg-white mt-4">
                                <!-- Tampilkan hari ini -->
                                <p>Hari <span class="ms-4">: <?php echo $hari_ini; ?></span></p>

                                <!-- Tampilkan tanggal hari ini -->
                                <p>Tanggal : <?php echo $date; ?></p>

                                <!-- Cek jika nama dokter sudah di isi, maka munculkan nama dokter -->
                                <p>Dokter <span class="ms-2">: <?php if (isset($_POST['nm_dokter'])) {

                                                                    $nm_dokter = $_POST['nm_dokter'];
                                                                    echo $nm_dokter;
                                                                } ?></span></p>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3 mx-1">
                        <div class="col">

                            <!-- Form -->
                            <form method="post" action="">

                                <!-- Tabel -->
                                <table class="table table-bordered border-dark text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pasien</th>
                                            <th>No. RM</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $i = 1;
                                        while ($row = $res->fetch_assoc()) {
                                            $soap = "<a class='btn soap text-white' href='pemeriksaan_pasien.php?no_dokter=" . $row['no_dokter'] . "'>Soap</a>";
                                            $histori = "<a class='btn btn-success' href='pemeriksaan_pasien.php?no_dokter=" . $row['no_dokter'] . "'>Histori</a>";
                                        ?>
                                            <tr>
                                                <td style="display:none;"><?php echo $row['no_dokter']; ?></td>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $row['nama_pasien']; ?></td>
                                                <td><?php echo $row['norm']; ?></td>
                                                <td class="w-25">
                                                    <div class="d-grid gap-2 d-md-block">
                                                        <?php echo "$histori"; ?>
                                                        <?php echo "$soap"; ?>
                                                        <!-- <button class="btn soap text-white" type="">Soap</button> -->
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>

                                <!-- </Akhir tabel -->

                                <!-- </Akhir form -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- </AKhir main content -->

    <!--  Jquery bs 5   -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jquery 3.6.3   -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

</body>

</html>