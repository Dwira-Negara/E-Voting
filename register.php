<?php
session_start();
include 'koneksi.php';

$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
$gusmint = mysqli_fetch_array($pengaturan);
$title = $gusmint['lembaga'];

if (isset($_POST['kirim'])) {
	$nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
	$kode_akses = mysqli_real_escape_string($koneksi, $_POST['kode_akses']);
	$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
	$jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
	$ceknim = mysqli_query($koneksi, "SELECT * FROM registrasi where nim = '$nim' ");
	$g = mysqli_fetch_array($ceknim);

	if ($g['nim'] == $nim) {
		echo "<script>window.alert('NIM sudah terpakai, silahkan coba NIM lainnya')
        window.location='index.php'</script>";
	} else {
		mysqli_query($koneksi, "INSERT INTO registrasi(nim, kode_akses, nama_mhs, jurusan, no_hp, status)
    VALUES ('$nim','$kode_akses','$nama','$jurusan','$no_hp','baru')");
		echo "<script>window.alert('Registrasi Berhasil')
    window.location='index.php'</script>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title><? echo $title; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta itemprop="description" content="Saatnyamemilih.online merupakan aplikasi pemilihan online berbasis web yang praktis, efisien, nyaman, dan mudah digunakan" />
	<link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form" action="" method="post">
					<span class="login100-form-title">
						<img src="images/KBM_FEB.png" alt="pemira" style="max-width:150px; height:auto;">
						<img src="images/KPM_FEB.jpeg" alt="bangka_cendekia" style="max-width:150px; height:auto;"><br>
						REGISTRASI<br>DAFTAR PEMILIH TETAP<br>
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="nim" id="nim" placeholder="NIM..." required="required">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-sign-in" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="kode_akses" id="kode_akses" placeholder="Password..." required="required">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="nama" id="nama" placeholder="Nama Lengkap..." required="required">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
						<label>Jurusan</label>
						<select name="jurusan" required="required" class="input100">
							<option value="1">Manajemen</option>
							<option value="2">Akuntansi</option>
						</select>

					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="kirim" id="kirim" type="submit">
							KIRIM
						</button>
					</div>
					<div class="container-login100-form-btn">
						<a href="index.php" class="login100-form-btn">LOGIN</a>
					</div>
					<br><br>
					<div class="text-center p-t-12">
						<span class="txt1">
						</span>
						<a class="txt2" href="https://www.youtube.com/channel/UCOAdMyFuPTcmi1TExyynO6w">
							<?php echo $title ?>
							<!--<p><?php echo $title . " " . date('Y') ?></p>-->
						</a>
					</div>


				</form>
			</div>
		</div>
	</div>

	<script src="js/sweetalert.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>