<?php
// Mulai sesi untuk mengelola login pengguna
session_start();
// Jika tidak ada sesi login, arahkan ke halaman login dan keluar dari skrip
if (!isset($_SESSION["login"])) {
  header("location:../index.php");
  exit;
}
// Sertakan file koneksi ke database
include '../koneksi.php';

// Proses ketika tombol 'akses' diklik
if (isset($_POST['akses'])) {
  // Ambil NIM dari formulir
  $nim = $_POST['nim'];
  // Fungsi untuk menghasilkan kode akses acak dengan panjang 6 karakter
  function acak($panjang)
  {
    $kode_akses = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
      $pos = rand(0, strlen($kode_akses) - 1);
      $string .= $kode_akses{$pos};
    }
    return $string;
  }
  // Panggil fungsi acak dan simpan hasilnya
  $hasil = acak(6);
}

// Setel laporan error menjadi 0 (untuk menyembunyikan pesan kesalahan)
error_reporting(0);

// Proses ketika tombol 'simpan' diklik
if (isset($_POST['simpan'])) {
  // Ambil dan bersihkan NIM dan kode akses dari formulir
  $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
  $kode_akses = mysqli_real_escape_string($koneksi, $_POST['kode_akses']);

  // Periksa apakah NIM sudah ada dalam database
  $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_akses WHERE nim='$nim'"));
  if ($cek > 0) {
    // Jika NIM sudah ada, tampilkan pesan kesalahan dan arahkan kembali ke halaman buat_akses.php
    echo "<script>window.alert('Maaf Anda sudah terdaftar sebelumnya')
    window.location='buat_akses.php'</script>";
  } else {
    // Jika NIM belum ada, masukkan NIM dan kode akses ke dalam database
    mysqli_query($koneksi, "INSERT INTO tbl_akses(nim, kode_akses)
    VALUES ('$nim','$kode_akses')");

    // Tampilkan pesan bahwa kode akses telah aktif dan arahkan kembali ke halaman buat_akses.php
    echo "<script>window.alert('Kode akses telah aktif')
    window.location='buat_akses.php'</script>";
  }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/icon.png">
  <title>E-PEMILWA</title>
  <link rel="stylesheet" type="text/css" href="../fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <!-- BOOTSTRAP STYLES-->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONTAWESOME STYLES-->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLES-->
  <link href="assets/css/custom.css" rel="stylesheet" />
  <!-- GOOGLE FONTS-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <style type="text/css">
    img {
      width: 100%;
      height: 500px;
      text-align: center;
    }

    img {
      border-radius: 10px;
    }
  </style>
</head>

<body>

  <div id="wrapper">
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="adjust-nav">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
            <!--  <img src="assets/img/logo.png" /> -->
            <h4 style="color: white;">Aplikasi E-PEMILWA</h4>
          </a>

        </div>
        <!--
                <span class="logout-spn" >
                  <a href="../logout.php" style="color:#fff;"><i class="fa fa-circle-o-notch"> Logout</i></a>  
                </span>
			-->
      </div>
    </div>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
      <div class="sidebar-collapse">
        <div class="menu">
          <ul class="nav" id="main-menu">

            <li>
              <a href="index.php"><i class="fa fa-desktop"></i>Beranda</a>
            </li>
            <?php
            $level = $_SESSION['level'] == 'admin';
            if ($level) {
            ?>

              <li>
                <a href="vote2.php"><i class="fa fa-desktop"></i>Pemilihan Kedua</a>
              </li>
              <li>
                <a href="input_data_paslon.php"><i class="fa fa-user"></i>Input Data Paslon 1</a>
              </li>
              <li>
                <a href="input_data_paslon2.php"><i class="fa fa-user"></i>Input Data Paslon 2</a>
              </li>
              <li>
                <a href="upload_dpt.php"><i class="fa fa-file"></i>Upload DPT</a>
              </li>
              <li>
                <a href="buat_akses.php"><i class="fa fa-lightbulb-o"></i>Buat Akses</a>
              </li>
              <li>
                <a href="hasil_suara.php"><i class="fa fa-chart-bar"></i>Hasil Suara</a>
              </li>

            <?php } ?>
            <li>
              <a href="../logout.php"><i class="fa fa-circle-o-notch "></i>Logout</a>
            </li>

          </ul>
        </div>
      </div>

    </nav>
    <!-- /. NAV SIDE  -->


    <div id="page-wrapper">
      <div id="page-inner">
        <div class="row">
          <div class="col-lg-12">
            <h2><i class="fa fa-lightbulb-o"> Buat Akses</i></h2>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <form action="" method="post">
              <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" required="required" placeholder="Masukan NIM..." class="form-control" autocomplete="off">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary" name="akses" value="Filter" class="form-control">
              </div>
            </form>

            <form action="" method="post">
              <div class="form-group">
                <input type="text" style="background-color: yellow; font-size: 22px;" name="nim" placeholder="nim" required="required" class="form-control" value="<?php echo $nim; ?>">
              </div>
              <div class="form-group">
                <input type="text" style="background-color: yellow; font-size: 22px;" name="kode_akses" required="required" placeholder="Kode akses" class="form-control" autocomplete="off" value="<?php echo $hasil; ?>">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-success" name="simpan" value="Aktifkan" class="form-control">
              </div>
            </form>
          </div>
        </div>

        <!-- /. ROW  -->
      </div>
      <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
  </div>


  <div class="footer">
    <div class="row">
      <div class="col-lg-12">
        <a href="#" style="color:#fff;" target="_blank">
          &copy; E-VOTING <?php echo date('Y') ?></a>
      </div>
    </div>
  </div>


  <!-- /. WRAPPER  -->
  <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
  <!-- JQUERY SCRIPTS -->
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- CUSTOM SCRIPTS -->
  <script src="assets/js/custom.js"></script>




</body>

</html>