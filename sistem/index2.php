<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location:../index2.php");
    exit;
}
include '../koneksi.php';

$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
$gusmint = mysqli_fetch_array($pengaturan);
$title = $gusmint['lembaga'];
if (isset($_POST['simpan'])) {
    date_default_timezone_set('Asia/jakarta');
    $waktu = date('H:i:sa');
    $nim = $_SESSION['nim'];
    $kode_akses = $_SESSION['kode_akses'];
    $ekstensi_diperbolehkan = array('png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG');
    $foto = $_FILES['foto']['name'];
    $x = explode('.', $foto);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['foto']['size'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if ($ukuran <= 2000000) {
            move_uploaded_file($file_tmp, 'images/' . $foto);
            $query = mysqli_query($koneksi, "INSERT INTO tbl_dpt VALUES(NULL, '$foto')");
            mysqli_query($koneksi, "UPDATE tbl_dpt set ktm='$foto' WHERE nim='$nim'");
            echo "<script>window.alert('Upload Berhasil')window.location='index.php'</script>";
        } else {
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
        include "view/header2.php";
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
    include "view/footer2.php";
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