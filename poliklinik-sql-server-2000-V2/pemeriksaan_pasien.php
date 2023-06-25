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

    <!-- Sweet alert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Html 2 canvas -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <!-- Css -->
    <style>
        /* Cursor tanda panah */
        .paint {
            cursor: crosshair;
        }

        .paint_resep {
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

            <!-- Container -->
            <div class="container">

                <!-- Form pemeriksaan-->
                <form method="post" action="" id="form_pemeriksaan">

                    <!-- Card SOAP -->
                    <div class="card mb-4 border-success justify-content-center mt-5">

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

                                <!-- Tabel canvas-->
                                <div class="table-responsive">
                                    <div class="screenshot_form_soap">
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


                                <!-- Tombol hapus dan ketebalan warna-->
                                <div class="mb-3 mt-3">
                                    <button type="button" class="btn btn-danger me-4 mb-3 float-start" id="hapus_soap">Hapus</button>

                                    <!-- Ketebalan dan ganti warna-->
                                    <input type="color" list id="paintColor" class="mt-2 ms-3 float-start">
                                    <input type="range" id="brush-size" min="1" max="10" value="5" class="form-range mt-2 float-end w-50">
                                    <!-- </Akhir ketebalan dan ganti warna -->

                                </div>
                                <!-- </Akhir tombol hapus dan ketebalan -->
                            </div>
                        </div>
                    </div>
                    <!-- </Akhir card SOAP -->

                    <!-- Card resep online-->
                    <div class="card mb-4 border-success justify-content-center mt-5">

                        <div class="card-body bg-success text-white text-center fs-5">RESEP ONLINE</div>

                        <div class="row mt-3 mx-1">
                            <div class="col">

                                <!-- Tabel canvas-->
                                <div class="table-responsive">
                                    <div class="screenshot_form_resep">
                                        <table class="table table-bordered border-dark">

                                            <!-- Container canvas untuk menulis resep -->
                                            <tbody id="canvasContainer">
                                                <tr>
                                                    <!-- Canvas resep -->

                                                    <td>
                                                        <canvas class="paint_resep" width="1050px" height="250px"></canvas>

                                                    </td>

                                                    <!-- </Akhir canvas resep -->
                                                </tr>
                                            </tbody>
                                            <!-- </Akhir container canvas untuk menulis resep -->
                                        </table>
                                    </div>
                                </div>
                                <!-- </Akhir tabel canvas -->

                                <!-- Tombol hapus dan ketebalan  -->
                                <div class="mb-3 mt-3">
                                    <button type="button" class="btn btn-danger me-4 mb-3 float-start" id="hapus_resep">Hapus</button>

                                    <!-- Ketebalan dan ganti warna-->
                                    <input type="color" list id="paintColor_resep" class="mt-2 ms-3 float-start">
                                    <input type="range" id="brush-size-resep" min="1" max="10" value="5" class="form-range  mt-2 float-end w-50">
                                    <!-- </Akhir ketebalan dan ganti warna -->

                                </div>
                                <!-- </Akhir tombol hapus dan ketebalan  -->

                            </div>
                        </div>
                    </div>
                    <!-- </Akhir card resep online -->

                    <!-- Tombol kembali dan simpan -->
                    <div class="row mt-4 mb-2">
                        <div class="col">
                            <a class="btn btn-info me-2 mb-3 text-white float-start" href="index.php">Kembali</a>
                        </div>

                        <div class="col">
                            <button type="submit" class="btn btn-success float-end" name="simpan" id="simpan">Simpan</button>
                        </div>
                    </div>
                    <!-- </Akhir tombol kembali dan simpan -->

                </form>
                <!-- </Akhir form pemeriksaan -->

            </div>
            <!-- </Akhir container -->

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

            // Folder IMG poliklinik
            let folder = 'img';

            // Variabel untuk ambil nilai norm
            let norm = $('#norm').val();

            // Ketika tombol simpan di klik
            $(form_pemeriksaan).on('submit', function(e) {
                e.preventDefault();

                // Cek jika folder img ada
                $.get(folder)
                    .done(function() {

                        // Berikan pesan
                        Swal.fire(
                            'BERHASIL',
                            'Form pemeriksaan soap dan resep berhasil di simpan pada folder img.',
                            'success'
                        )
                    })

                function screenshotAndSaveForm(element, url) {
                    // Fungsi untuk mengambil tangkapan layar elemen dan menyimpan formulir
                    return html2canvas(element)
                        .then(canvasData => {
                            // Mengubah elemen menjadi data kanvas
                            canvasData.style.display = 'none';
                            document.body.appendChild(canvasData);
                            return canvasData;
                        })
                        .then(canvasData => {
                            // Mengubah data kanvas menjadi URL gambar berformat base64
                            const image = canvasData.toDataURL('image/jpeg');

                            // Mengirimkan data ke URL yang ditentukan menggunakan metode POST
                            return $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                    norm: norm,
                                    image: image
                                }
                            }).done(() => {
                                // Menghapus elemen kanvas dari dokumen
                                canvasData.remove();
                            });
                        });
                }

                // panggil fungsi screenshot untuk form pemeriksaan SOAP
                screenshotAndSaveForm($('.screenshot_form_soap')[0], "simpan_form_pemeriksaan_soap.php");

                // panggil fungsi screenshot untuk form pemeriksaan resep
                screenshotAndSaveForm($('.screenshot_form_resep')[0], "simpan_form_pemeriksaan_resep.php");

            });

            function initializeCanvas(canvas, paintColorSelector, isDrawingVariable, clearButton, brushSizeSelector) {
                // Fungsi ini digunakan untuk menginisialisasi canvas dengan parameter yang diberikan.

                let ctx = canvas.getContext("2d");
                // Mendapatkan konteks (context) dari canvas untuk menggambar di dalamnya.

                let lastX = 0;
                let lastY = 0;
                // Variabel untuk menyimpan posisi x dan y mouse saat sebelumnya.

                let paintColor = $(paintColorSelector);
                // Mendapatkan referensi elemen input warna berdasarkan selector yang diberikan.

                paintColor.change(function() {
                    // Event listener untuk mengubah warna garis saat nilai warna dipilih berubah.
                    let color = paintColor.val();
                    // Mendapatkan nilai warna yang dipilih.
                    ctx.strokeStyle = color;
                    // Mengubah warna garis pada konteks canvas.
                });

                $(canvas).mousedown(function(e) {
                    // Event listener untuk memulai menggambar saat mouse ditekan pada canvas.
                    isDrawingVariable = true;
                    // Menyimpan bahwa sedang dalam proses menggambar.
                    lastX = e.pageX - $(canvas).offset().left;
                    lastY = e.pageY - $(canvas).offset().top;
                    // Menyimpan posisi x dan y mouse saat ini.
                });

                $(canvas).mousemove(function(e) {
                    // Event listener untuk menggambar saat mouse digerakkan di atas canvas.
                    if (isDrawingVariable) {
                        // Jika sedang dalam proses menggambar.
                        let currentX = e.pageX - $(canvas).offset().left;
                        let currentY = e.pageY - $(canvas).offset().top;
                        // Mendapatkan posisi x dan y mouse saat ini.
                        ctx.beginPath();
                        // Memulai path baru untuk menggambar garis.
                        ctx.moveTo(lastX, lastY);
                        // Memindahkan penunjuk ke posisi x dan y sebelumnya.
                        ctx.lineTo(currentX, currentY);
                        // Menggambar garis ke posisi x dan y saat ini.
                        ctx.stroke();
                        // Melakukan penggambaran garis pada canvas.
                        lastX = currentX;
                        lastY = currentY;
                        // Menyimpan posisi x dan y saat ini sebagai posisi sebelumnya.
                    }
                });

                $(canvas).mouseup(function(e) {
                    // Event listener untuk mengakhiri menggambar saat mouse dilepas dari canvas.
                    isDrawingVariable = false;
                    // Menyimpan bahwa tidak dalam proses menggambar.
                });

                $(clearButton).click(function() {
                    // Event listener untuk tombol hapus.
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    // Menghapus semua isi pada canvas dengan membersihkan seluruh area.
                });

                let brushSize = $(brushSizeSelector);
                // Mendapatkan referensi elemen input ukuran garis berdasarkan selector yang diberikan.
                brushSize.on("input", function(e) {
                    // Event listener untuk mengubah ukuran garis saat nilai input berubah.
                    ctx.lineWidth = $(this).val();
                    // Mengatur ukuran garis pada konteks canvas sesuai dengan nilai input yang baru.
                });
            }

            let canvasListSOAP = $(".paint");
            let canvasResep = $(".paint_resep");
            let isDrawing = false;
            let isDrawingResep = false;
            // Variabel-variabel yang digunakan untuk mengontrol proses menggambar pada canvas.

            canvasListSOAP.each(function() {
                // Iterasi melalui setiap elemen canvas pada class "paint".
                let canvas = this;
                let paintColorSelector = "#paintColor";
                let clearButton = "#hapus_soap";
                let brushSizeSelector = "#brush-size";
                // Menyimpan selector untuk elemen-elemen terkait dalam variabel.

                initializeCanvas(canvas, paintColorSelector, isDrawing, clearButton, brushSizeSelector);
                // Memanggil fungsi initializeCanvas untuk menginisialisasi setiap canvas dengan parameter yang diberikan.
            });

            canvasResep.each(function() {
                // Iterasi melalui setiap elemen canvas pada class "paint_resep".
                let canvas = this;
                let paintColorSelector = "#paintColor_resep";
                let clearButton = "#hapus_resep";
                let brushSizeSelector = "#brush-size-resep";
                // Menyimpan selector untuk elemen-elemen terkait dalam variabel.

                initializeCanvas(canvas, paintColorSelector, isDrawingResep, clearButton, brushSizeSelector);
                // Memanggil fungsi initializeCanvas untuk menginisialisasi setiap canvas dengan parameter yang diberikan.
            });

        });
    </script>
</body>

</html>