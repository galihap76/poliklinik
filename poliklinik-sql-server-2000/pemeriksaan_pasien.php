<?php

// Koneksi ke database
include_once 'db.php';

// Jika pengguna belum memilih list pasien
if (empty($_GET['norm'])) {

    // Paksa pengguna alihkan ke list_pasien.php
    echo "
    		<script>
     		alert('Anda harus memilih list pasien!');
     		document.location.href='list_pasien.php';
     		</script>
     		";
}

// Ambil get norm
$norm = $_GET['norm'];

/* 
Lakukan query SELECT DISTINCT untuk menampilkan satu data
ketika pada tabel dip ada data yang ganda menggunakan PDO PHP prepare
*/

$query = "SELECT DISTINCT norm, namapasien
FROM dip
WHERE norm = :norm";
$stmt = $conn->prepare($query);
$stmt->bindParam(':norm', $norm);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pemeriksan Pasien</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Html 2 canvas -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <!-- Css -->
    <style>
        /* Cursor tanda panah */
        .paint {
            cursor: crosshair;
        }

        .alert.w-75 {
            width: 75%;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>

<body>

    <!--  Navbar    -->
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <h4 class="ps-3 pe-3 text-white"> <i class="bi bi-person-fill-check"></i> Pemeriksaan Pasien</h4>
    </nav>
    <!--  </Akhir navbar  -->

    <!-- Main content -->
    <div id="Maincontent">
        <main>
            <div class="container">
                <div class="card mb-4 border-success justify-content-center mt-5">

                    <!-- Form pemeriksaan-->
                    <form method="post" action="" id="form_pemeriksaan">

                        <div class="card-body bg-success text-white text-center fs-5">FORM PEMERIKSAAN PASIEN (SOAP)</div>
                        <div class="row">
                            <div class="col">

                                <!-- Hari dan tanggal -->
                                <?php

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

                                <!-- Tampilkan data norm, nama pasien dan tanggal -->
                                <div class="ms-3 align-items-center justify-content-between bg-white mt-4">

                                    <?php foreach ($res as $row) : ?>

                                        <!-- Init norm untuk mengirim data norm ke server -->
                                        <input type="hidden" value="<?php echo $row['norm']; ?>" name="norm" id="norm">
                                        <!-- </Akhir init norm untuk mengirim data norm ke server -->

                                        <p>No.RM
                                            <span class="ms-2">: <?php echo $row['norm']; ?></span>
                                        </p>
                                        <p>Nama : <?php echo $row['namapasien']; ?></p>
                                    <?php endforeach; ?>

                                    <p>Tanggal <span class="ms-2">: <?php echo $date; ?></span></p>
                                </div>
                                <!-- </Akhir tampilkan data norm, nama pasien dan tanggal -->

                            </div>
                        </div>

                        <div class="row mt-3 mx-1">
                            <div class="col">

                                <!-- Informasi simpan pemeriksaan -->
                                <div id="informasi_simpan_pemeriksaan" class="mb-3 alert alert-success w-75 text-center" style="display: none;">
                                    Form pemeriksaan berhasil di simpan pada folder <div class="fw-bold">img.</div>
                                </div>

                                <div id="fail" class="mb-3 alert alert-danger w-75 text-center" style="display: none;">
                                    Folder <div class="fw-bold">img</div> tidak ada.
                                </div>
                                <!-- </Akhir informasi simpan pemeriksaan -->

                                <!-- Tabel canvas-->
                                <div class="table-responsive">
                                    <div class="screenshot_form_pemeriksaan">
                                        <table class="table table-bordered border-dark">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>S : Anamnesa</th>
                                                    <th>O : Pemeriksaan</th>
                                                    <th>A : Asesment</th>
                                                    <th>P : Terapi / Obat</th>
                                                </tr>
                                            </thead>

                                            <!-- Container canvas untuk menulis -->
                                            <tbody id="canvasContainer">
                                                <tr>
                                                    <!-- Canvas -->

                                                    <td>
                                                        <canvas class="paint" width="250px" height="250px"></canvas>
                                                    </td>
                                                    <td> <canvas class="paint" width="250px" height="250px"></canvas></td>
                                                    <td> <canvas class="paint" width="250px" height="250px"></canvas></td>
                                                    <td> <canvas class="paint" width="250px" height="250px"></canvas></td>

                                                    <!-- </Akhir canvas -->
                                                </tr>
                                            </tbody>
                                            <!-- </Akhir container canvas untuk menulis -->
                                        </table>
                                    </div>
                                </div>
                                <!-- </Akhir tabel canvas -->


                                <!-- Tombol simpan dan hapus -->
                                <div class="mb-3 mt-3">
                                    <button type="submit" class="btn btn-primary me-2 mb-3" name="simpan" id="simpan">Simpan</button>

                                    <a class="btn btn-info me-2 mb-3 text-white" href="index.php">Kembali</a>
                                    <button type="button" class="btn btn-danger me-4 mb-3" id="hapus">Hapus</button>

                                    <!-- Ketebalan dan ganti warna-->
                                    <input type="range" id="brush-size" min="1" max="10" value="5" class="form-range w-50">
                                    <input type="color" list id="paintColor" class="mt-3 ms-3">
                                    <!-- </Akhir ketebalan dan ganti warna -->

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- </Akhir form pemeriksaan -->

                </div>
            </div>
        </main>
    </div>
    <!-- </Akhir main content -->

    <!--  Jquery bs 5   -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- jquery 3.6.3   -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!-- Script jquery -->
    <script>
        // ketika dokumen html sudah di load
        $(document).ready(function() {

            // Variabel form pemeriksaan
            let form_pemeriksaan = $('#form_pemeriksaan');

            // Ketika tombol simpan di klik
            $(form_pemeriksaan).on('submit', function(e) {
                e.preventDefault();

                let folder = 'img';
                let informasi_simpan_pemeriksaan = document.querySelector('#informasi_simpan_pemeriksaan');

                // Cek jika folder img ada
                $.get(folder)
                    .done(function() {

                        // Munculkan pesan informasi simpan pemeriksaan
                        informasi_simpan_pemeriksaan.style.display = 'block';

                        // Jika sudah waktu nya 3 detik 
                        setTimeout(function() {

                            // Maka hapus pesan nya
                            informasi_simpan_pemeriksaan.style.display = 'none';
                        }, 3000)
                    })

                // lakukan screenshot form pemeriksaan
                html2canvas($('.screenshot_form_pemeriksaan')[0])
                    .then(canvasData => {
                        canvasData.style.display = 'none'
                        document.body.appendChild(canvasData)
                        return canvasData
                    })
                    .then(canvasData => {
                        const image = canvasData.toDataURL('image/jpeg');
                        let norm = $('#norm').val();

                        // Mengirimkan data untuk simpan form pemeriksaan
                        $.ajax({
                            type: "POST",
                            url: "simpan_form_pemeriksaan.php",
                            data: {
                                norm: norm,
                                image: image
                            }
                        })
                        canvasData.remove()

                    })
            });

            // Mengambil referensi canvas pada class paint
            let canvasList = $(".paint");

            // Iterasi melalui setiap canvas
            canvasList.each(function() {
                let canvas = this;

                // Mendapatkan context dari canvas
                let ctx = canvas.getContext("2d");

                // Variabel untuk menyimpan apakah sedang menggambar atau tidak
                let isDrawing = false;

                // Variabel untuk menyimpan posisi x dan y mouse saat sebelumnya
                let lastX = 0;
                let lastY = 0;

                // Mengambil referensi elemen input warna
                let paintColor = $("#paintColor");

                // Event listener untuk mengubah warna garis
                paintColor.change(function() {
                    // Mengambil nilai warna yang dipilih
                    let color = paintColor.val();

                    // Mengubah warna garis
                    ctx.strokeStyle = color;
                });

                // Event listener untuk memulai menggambar saat mouse ditekan
                $(canvas).mousedown(function(e) {
                    // Menyimpan bahwa sedang menggambar
                    isDrawing = true;

                    // Menyimpan posisi x dan y mouse saat ini
                    lastX = e.pageX - $(canvas).offset().left;
                    lastY = e.pageY - $(canvas).offset().top;
                });

                // Event listener untuk menggambar saat mouse digerakkan
                $(canvas).mousemove(function(e) {
                    // Jika sedang menggambar
                    if (isDrawing) {
                        // Mendapatkan posisi x dan y mouse saat ini
                        let currentX = e.pageX - $(canvas).offset().left;
                        let currentY = e.pageY - $(canvas).offset().top;

                        // Mulai path baru
                        ctx.beginPath();

                        // Pindah ke posisi x dan y saat sebelumnya
                        ctx.moveTo(lastX, lastY);

                        // Gambar garis ke posisi x dan y saat ini
                        ctx.lineTo(currentX, currentY);

                        // Menggambar garis
                        ctx.stroke();

                        // Menyimpan posisi x dan y saat ini sebagai posisi x dan y saat sebelumnya
                        lastX = currentX;
                        lastY = currentY;
                    }
                });

                // Event listener untuk mengakhiri menggambar saat mouse dilepas
                $(canvas).mouseup(function(e) {
                    // Menyimpan bahwa tidak sedang menggambar
                    isDrawing = false;
                });

                $("#brush-size").on("input", function(e) {
                    ctx.lineWidth = $(this).val()
                });

                // Tombol hapus
                $("#hapus").click(function() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });

            });
        });
    </script>
</body>

</html>