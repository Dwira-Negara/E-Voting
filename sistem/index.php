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

// Ambil pengaturan dari database
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
// Ambil satu baris pengaturan sebagai array asosiatif
$gusmint = mysqli_fetch_array($pengaturan);
// Tentukan judul halaman berdasarkan pengaturan dari database
$title = $gusmint['lembaga'];

// Proses ketika tombol 'simpan' diklik
if (isset($_POST['simpan'])) {
  // Setel zona waktu ke Asia/Jakarta
  date_default_timezone_set('Asia/Jakarta');
  // Ambil waktu saat ini
  $waktu = date('H:i:sa');
  // Ambil NIM dan kode akses dari sesi
  $nim = $_SESSION['nim'];
  $kode_akses = $_SESSION['kode_akses'];
  // Tentukan ekstensi file yang diperbolehkan untuk foto
  $ekstensi_diperbolehkan = array('png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG');
  // Ambil nama file foto yang diunggah
  $foto = $_FILES['foto']['name'];
  // Pisahkan nama file dan ekstensinya
  $x = explode('.', $foto);
  // Ambil ekstensi file (dikonversi ke huruf kecil)
  $ekstensi = strtolower(end($x));
  // Ambil ukuran file foto yang diunggah
  $ukuran = $_FILES['foto']['size'];
  // Ambil nama file sementara foto yang diunggah
  $file_tmp = $_FILES['foto']['tmp_name'];
  // Jika ekstensi file foto ada dalam daftar yang diperbolehkan
  if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
    // Jika ukuran file foto kurang dari atau sama dengan 2MB
    if ($ukuran <= 2000000) {
      // Pindahkan file foto ke direktori 'images/'
      move_uploaded_file($file_tmp, 'images/' . $foto);
      // Masukkan nama file foto ke dalam tabel tbl_dpt
      $query = mysqli_query($koneksi, "INSERT INTO tbl_dpt VALUES(NULL, '$foto')");
      // Update nama file foto ke dalam tabel tbl_dpt berdasarkan NIM
      mysqli_query($koneksi, "UPDATE tbl_dpt set ktm='$foto' WHERE nim='$nim'");
      // Tampilkan pesan bahwa upload berhasil dan arahkan ke halaman index.php
      echo "<script>window.alert('Upload Berhasil')window.location='index.php'</script>";
    } else {
      // Tampilkan pesan bahwa ukuran foto terlalu besar
      echo "<script>window.alert('Ukuran FOTO terlalu besar! Silahkan ulangi lagi')</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../images/icons/favicon.ico">
  <title><?php echo $title; ?></title>
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

</head>

<body>
  <div id="wrapper">
    <?php
    include "view/header.php";
    ?>

    <div id="page-wrapper">

      <?php
      if (isset($_GET['page'])) {
        $page = $_GET['page'];

        switch ($page) {
          case 'home':
            include "view/home.php";
            break;
          case 'data-paslon':
            include "view/input_data_paslon.php";
            break;
          case 'pengaturan':
            include "view/setting.php";
            break;
          default:
            echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
            break;
        }
      } else {
        include "view/home.php";
      }

      ?>
    <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
  </div>

  <?php
  include "view/footer.php";
  ?>

  <!-- /. WRAPPER  -->
  <script src="../js/sweetalert.min.js"></script>
  <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
  <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
  <!-- JQUERY SCRIPTS -->
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- CUSTOM SCRIPTS -->
  <script src="assets/js/custom.js"></script>

</body>

</html>