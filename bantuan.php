<?php
include 'koneksi.php'; // Menghubungkan ke file koneksi database
date_default_timezone_set('Asia/Jakarta'); // Mengatur timezone
$gusmint = date('Y-m-d H:i:s'); // Mendapatkan waktu saat ini
$hasil = mysqli_query($koneksi, "SELECT * FROM pengaturan"); // Melakukan query untuk mengambil semua data dari tabel pengaturan
$tgl = mysqli_fetch_array($hasil); // Mengambil hasil query sebagai array asosiatif
$cendekia = $tgl['mulai']; // Menyimpan nilai 'mulai' dari hasil query ke variabel $cendekia
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan"); // Melakukan query lagi untuk mengambil data dari tabel pengaturan
$judul = mysqli_fetch_array($pengaturan); // Mengambil hasil query sebagai array asosiatif
$title = $judul['lembaga']; // Menyimpan nilai 'lembaga' dari hasil query ke variabel $title

// Proses form jika tombol submit ditekan
if (isset($_POST['submit'])) {
    // Ambil nilai NIM dari form
    $nim = isset($_POST['nomor']) ? $_POST['nomor'] : '';

    // Cari data berdasarkan NIM
    $hasil = mysqli_query($koneksi, "SELECT * FROM registrasi WHERE nim='$nim'");
    if (mysqli_num_rows($hasil) > 0) {
        $data = mysqli_fetch_array($hasil);
        $kode_akses = $data['kode_akses']; // Ambil kode akses jika data ditemukan
    } else {
        $kode_akses = ''; // Set kode akses kosong jika data tidak ditemukan
    }
} else {
    $nim = '';
    $kode_akses = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title> <!-- Menampilkan judul halaman dari variabel $title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta itemprop="description" content="pemungutansuara.online merupakan aplikasi berbasis web online praktis yang digunakan untuk pemilihan calon pemimpin" />
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <span class="login100-form-title">
                    <img src="images/logo-evoting.png" alt="bangka_cendekia" style="max-width:180px; height:auto;"><br>
                    <upper style="text-transform: uppercase;">ITB STIKOM BALI<br>TEKNOLOGI INFORMASI<br>2024</upper>
                </span>
                <p>Fitur Bantuan dibuka mulai tanggal <?php echo $cendekia; ?>.</p> <!-- Menampilkan tanggal mulai fitur bantuan dari variabel $cendekia -->
                <?php
                if ($gusmint >= $cendekia) { // Mengecek apakah waktu saat ini sudah melebihi tanggal mulai fitur bantuan
                    echo "<form method='post' class='login100-form validate-form'>
            <div class='wrap-input100 validate-input'>
                <input type='text' name='nomor' id='teks' class='input100' placeholder='Masukkan NIM' required value='$nim'>
                <span class='focus-input100'></span>
				    <span class='symbol-input100'>
					    <i class='fa fa-user' aria-hidden='true'></i>
			    </span>
			</div>
            <div class='container-login100-form-btn'>
				<button class='login100-form-btn' type='submit' name='submit' id='tombol' >Cari</button>
			</div>
        <br>
        </form>";
                } else { // Jika waktu saat ini belum melebihi tanggal mulai fitur bantuan
                    echo "
	        <div class='login100-form validate-form'>
	        <div class='container-login100-form-btn'>
				<h3 class='btn btn-warning' >Fitur Bantuan Belum dibuka</h3>
			</div>
			<div class='container-login100-form-btn'>
			    <a href='index.php' class='login100-form-btn'>LOGIN</a>
			</div>
			</div>
        <br>
	";
                }

                ?>

                <?php
                if (isset($_REQUEST['submit'])) { // Mengecek apakah form telah disubmit
                    // Tampilkan hasil query jika ada
                    if ($kode_akses !== '') {
                ?>

                        <table class="table table-bordered">
                            <tr>
                                <td>NIM</td>
                                <td><?php echo $nim; ?></td> <!-- Menampilkan NIM yang diinputkan -->
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><strong><?php echo $kode_akses; ?></strong></td> <!-- Menampilkan kode akses dari hasil query -->
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td><?php echo $data['nama_mhs']; ?></td> <!-- Menampilkan nama mahasiswa dari hasil query -->
                            </tr>
                        </table>
                        <div class="alert alert-danger" role="alert" style="text-align:justify;"><strong>
                                <center>
                                    <?php echo "GUNAKAN HAK PILIH ANDA MASING-MASING<br>";    ?>
                                </center>
                            </strong></div><br>
                        <div class='login100-form validate-form'>
                            <div class='container-login100-form-btn'>
                                <a href='index.php' class='login100-form-btn'>LOGIN</a>
                            </div>
                        </div>
                <?php
                    } else { // Jika data yang diinputkan tidak ditemukan
                        echo 'Data yang anda inputkan tidak ditemukan! </br>Silahkan hubungi admin atau petugas administrasi madrasah!<br>';
                        // Tampilkan pesan kesalahan dan minta pengguna menghubungi admin
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk berbagai fungsi tambahan -->
    <script src="js/sweetalert.min.js"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <script src="js/main.js"></script>
</body>

</html>
