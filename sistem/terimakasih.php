<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:../index.php");
  exit;
}
include '../koneksi.php';
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
while ($gusmint = mysqli_fetch_array($pengaturan)) {
  $title = $gusmint['lembaga'];
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../icons/favicon.ico">
  <title><?php echo $title; ?></title>
  <!---------------------------------------------------------------------->
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
  <style>
    img {
      width: 100%;
      height: 280px;
      text-align: center;
    }

    img {
      border-radius: 10px;
    }

    tr,
    td {
      border: none;
    }
  </style>
</head>

<body>

  <div id="wrapper">
    <?php
    include "view/header.php";
    ?>


    <div id="page-wrapper">
      <div id="page-inner">

        <div class="row">
          <div class="col-lg-12">
            <div class="alert alert-success">
              <div class="row">
                <div class="col-lg-12">
                  <h2 align="center"><b>TERIMA KASIH ATAS PARTISIPASI ANDA</b></h2>
                  <h3 align="center">~Semoga diberikan hasil terbaik untuk masa depan yang lebih baik~</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
  </div>


  <?php
  include "view/footer.php";
  ?>

  <script src="../js/sweetalert.min.js"></script>
  <!--===============================================================================================-->
  <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
  <!-- JQUERY SCRIPTS -->
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- CUSTOM SCRIPTS -->
  <script src="assets/js/custom.js"></script>




</body>

</html>