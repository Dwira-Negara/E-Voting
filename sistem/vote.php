<?php
session_start(); // Memulai sesi untuk menyimpan informasi pengguna yang login
if (!isset($_SESSION["login"])) { // Memeriksa apakah pengguna sudah login
  header("location:../index.php"); // Jika belum login, arahkan ke halaman login
  exit;
}
include '../koneksi.php'; // Menghubungkan ke file koneksi database

// Mengambil pengaturan dari database
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
while ($gusmint = mysqli_fetch_array($pengaturan)) {
  $title = $gusmint['lembaga']; // Menyimpan nama lembaga dalam variabel $title
}

if (isset($_POST['simpan'])) { // Memeriksa apakah tombol 'simpan' telah ditekan
  date_default_timezone_set('Asia/Jakarta'); // Mengatur zona waktu ke Jakarta
  $waktu = date('H:i:sa'); // Mendapatkan waktu saat ini
  $nim = $_SESSION['nim']; // Mengambil NIM pengguna dari sesi
  $nama_mhs = $_SESSION['nama_mhs']; // Mengambil nama pengguna dari sesi
  $jenis = $_POST['jenis']; // Mengambil jenis pilihan dari input form
  $vote = $_POST['vote']; // Mengambil pilihan vote dari input form

  // Memeriksa apakah pengguna sudah melakukan voting
  $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_paslon WHERE nim='$nim' AND jenis='$jenis' "));
  if ($cek > 0) {
    echo "<script>window.alert('Anda tidak bisa melakukan voting lagi');
          window.location='terimakasih.php'</script>"; // Jika sudah voting, tampilkan pesan dan arahkan ke halaman 'terimakasih'
  } else {
    // Menyimpan data vote ke database
    mysqli_query($koneksi, "INSERT INTO tbl_paslon(nim, nama_mhs, jenis, vote, waktu)
            VALUES ('$nim','$nama_mhs','$jenis','$vote','$waktu')");

    echo "<script>window.alert('Voting Berhasil');
          window.location='index.php'</script>"; // Tampilkan pesan sukses dan arahkan ke halaman 'index'
  }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta itemprop="description" content="<?php echo $title; ?>" /> <!-- Menampilkan deskripsi berdasarkan nama lembaga -->
  <link rel="shortcut icon" href="../icons/favicon.ico">
  <title><?php echo $title; ?></title> <!-- Menampilkan judul berdasarkan nama lembaga -->
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
    include "view/header.php"; // Menyertakan file header
    ?>
    <div id="page-wrapper">
      <div id="page-inner">

        <div class="row">
          <div class="col-lg-12 ">
            <div class="alert alert-info">
              <strong>
                <h3><i class="fa fa-desktop"> Kertas Suara Online</i>: <b><?php echo $_SESSION['nama_mhs']; ?></b></h3>
              </strong>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="alert alert-success">
              <div class="row">
                <div class="col-lg-12">
                  <h3 align="center"><b>PEMILIHAN KETUA BEM</b></h3>
                  <form action="" method="post">
                    <input type="hidden" name="jenis" class="form-control" value="1"> <!-- Mengirimkan jenis pemilihan -->
                    <?php
                    // Mengambil data paslon dari database untuk jenis pemilihan 1
                    $data_paslon = mysqli_query($koneksi, "SELECT * FROM data_paslon where jenis='1' order by no_urut ASC");
                    while ($d = mysqli_fetch_array($data_paslon)) {
                    ?>
                      <div class="col-lg-6">
                        <table class="table table-striped table-bordered table-hover">
                          <tr>
                            <td style="background-color: #214761; color: white; font-size: 30px; text-align: center;"><b><?php echo $d['no_urut']; ?></b></td>
                          </tr>
                          <tr>
                            <td><img style="width:100%; height:350px;" src="<?php echo "foto/" . $d['gambar1']; ?>"></td>
                          </tr>
                          <tr>
                            <td style="text-align:center;">
                              <h4><?php echo $d['nm_paslon']; ?></h4> <!-- Menampilkan nama pasangan calon -->
                            </td>
                          </tr>
                          <tr>
                            <td><img style="width:100%; height:350px;" src="<?php echo "foto/" . $d['gambar2']; ?>"></td>
                          </tr>
                          <tr>
                            <td style="text-align: center; padding: 5px; background-color: #1aaf5e;"><input type="radio" style="width:25px;height:25px;background:#000961;" required="required" name="vote" value="<?php echo $d['no_urut']; ?>"></td>
                          </tr>
                        </table>
                      </div>
                    <?php } ?>
                    <center>
                      <?php
                      $gusmint = date('Y-m-d H:i:s'); // Mengambil waktu saat ini
                      $hasil = mysqli_query($koneksi, "SELECT * FROM pengaturan"); // Mengambil pengaturan dari database
                      $tgl = mysqli_fetch_array($hasil);
                      $mulai = $tgl['mulai'];
                      $selesai = $tgl['selesai'];
                      if ($gusmint >= $selesai) {
                        // Jika waktu pemilihan sudah lewat
                        echo "
        <input style='background-color: #1aaf5e; color: white; font-size: 20px; padding: 10px; border-radius: 20px; width: 60%;' type='submit' name='simpan' value='PILIH' onclick=\"return confirm('YAKIN DENGAN PILIHAN ANDA')\" disabled>
        <h3 style='color: red; padding: 5px;'><strong>- waktu pemilihan sudah ditutup -
        </strong></h3>
        ";
                      } elseif ($gusmint >= $mulai) {
                        // Jika waktu pemilihan sedang berlangsung
                        echo "
        <input style='background-color: #1aaf5e; color: white; font-size: 20px; padding: 10px; border-radius: 20px; width: 60%;' type='submit' name='simpan' value='PILIH' onclick=\"return confirm('YAKIN DENGAN PILIHAN ANDA')\">
        ";
                      } else {
                        // Jika waktu pemilihan belum dimulai
                        echo "
        <input style='background-color: #1aaf5e; color: white; font-size: 20px; padding: 10px; border-radius: 20px; width: 60%;' type='submit' name='simpan' value='PILIH' onclick=\"return confirm('YAKIN DENGAN PILIHAN ANDA')\" disabled>
        <h3 style='color: red; padding: 5px;'><strong>- belum saatnya pemilihan -</strong></h3>
        ";
                      }
                      ?>
                    </center>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /. ROW  -->

        <div class="row">
          <div class="col-lg-12 ">
            <div class="alert alert-danger" style="text-align: center;">
              <strong>Voting hanya dapat dilakukan satu kali. </strong> <!-- Pesan peringatan untuk pengguna -->
            </div>
          </div>
        </div>
        <!-- /. ROW  -->
      </div>
      <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
  </div>

  <?php
  include "view/footer.php"; // Menyertakan file footer
  ?>

  <script src="../js/sweetalert.min.js"></script>
  <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
  <!-- JQUERY SCRIPTS -->
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- CUSTOM SCRIPTS -->
  <script src="assets/js/custom.js"></script>

</body>

</html>