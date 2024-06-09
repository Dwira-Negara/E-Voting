<?php
session_start(); // Memulai sesi untuk menyimpan informasi login pengguna
if (!isset($_SESSION["login"])) { // Mengecek apakah pengguna sudah login atau belum
  header("location:../index.php"); // Jika belum login, arahkan kembali ke halaman login
  exit;
}
include '../koneksi.php'; // Menghubungkan ke file koneksi database
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan"); // Mengambil data pengaturan dari database
$gusmint = mysqli_fetch_array($pengaturan); // Mengambil hasil query sebagai array asosiatif
$title = $gusmint['lembaga']; // Menyimpan nilai 'lembaga' dari hasil query ke variabel $title
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../images/icons/favicon.ico">
  <title>Hasil Suara</title>
  <link rel="stylesheet" type="text/css" href="../fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <script type="text/javascript" src="assets/chart/chart.js"></script>
  <!-- BOOTSTRAP STYLES-->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONTAWESOME STYLES-->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLES-->
  <link href="assets/css/custom.css" rel="stylesheet" />
  <!-- GOOGLE FONTS-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <script src="assets/js/jquery-1.10.1.min.js"></script>
  <script src="assets/js/highcharts.js"></script>
</head>

<body>
  <div id="wrapper">
    <?php
    include "view/header.php"; // Menyertakan file header
    ?>

    <div id="page-wrapper">
      <div id="page-inner">
        <div id="vote">

          <div id="mygraph2"></div>
          <script>
            var chart2; // Variabel global untuk chart2
            $(document).ready(function() {
              chart2 = new Highcharts.Chart({
                chart: {
                  renderTo: 'mygraph2',
                  type: 'column' // Jenis chart
                },
                title: {
                  text: 'HASIL SUARA <?php echo $gusmint['voting']; ?>' // Judul chart
                },
                xAxis: {
                  categories: ['Nama Paslon'] // Kategori xAxis
                },
                yAxis: {
                  title: {
                    text: 'Jumlah Suara' // Judul yAxis
                  }
                },
                series: [
                  <?php
                  $kandidat = mysqli_query($koneksi, "SELECT * FROM data_paslon where jenis='1'"); // Mengambil data paslon
                  while ($ambil = mysqli_fetch_array($kandidat)) { // Looping untuk setiap paslon
                    $i = $ambil['no_urut'];
                    $hasil = $ambil['nm_paslon'];
                    $paslon = mysqli_query($koneksi, "select * from tbl_paslon where vote='$i' AND jenis='1'"); // Mengambil jumlah suara untuk setiap paslon
                  ?> {
                      name: '<?php echo $hasil; ?>', // Nama paslon
                      data: [<?php echo mysqli_num_rows($paslon); ?>] // Jumlah suara paslon
                    },
                  <?php
                  }
                  ?>
                ]
              });
            });
          </script>

          <div id="mygraph11"></div>
          <script>
            var chart1; // Variabel global untuk chart1
            $(document).ready(function() {
              chart1 = new Highcharts.Chart({
                chart: {
                  renderTo: 'mygraph11',
                  type: 'column' // Jenis chart
                },
                title: {
                  text: 'STATISTIK SUARA' // Judul chart
                },
                xAxis: {
                  categories: ['Statistik'] // Kategori xAxis
                },
                yAxis: {
                  title: {
                    text: 'Jumlah Suara' // Judul yAxis
                  }
                },
                series: [{
                    name: 'Sudah memilih', // Seri untuk jumlah suara yang sudah memilih
                    data: [
                      <?php
                      $suara1 = mysqli_query($koneksi, "select * from tbl_paslon where jenis='1'"); // Mengambil jumlah suara yang sudah memilih
                      echo mysqli_num_rows($suara1);
                      ?>
                    ]
                  },
                  {
                    name: 'Belum memilih', // Seri untuk jumlah suara yang belum memilih
                    data: [
                      <?php
                      $data_dpt = mysqli_query($koneksi, "select * from registrasi where status='verified'"); // Mengambil data pemilih yang sudah diverifikasi
                      $jumlah_dpt = mysqli_num_rows($data_dpt);
                      $suara_masuk = mysqli_num_rows($suara1);
                      echo "$jumlah_dpt - $suara_masuk"; // Menghitung jumlah yang belum memilih
                      ?>
                    ]
                  },
                ]
              });
            });
          </script>
        </div>

      </div>

    </div>

    <?php
    include "view/footer.php"; // Menyertakan file footer
    ?>


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
