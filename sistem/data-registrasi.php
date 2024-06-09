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
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $kode_akses = $_POST['kode_akses'];
    $nama_mhs = $_POST['nama_mhs'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($koneksi, "update registrasi set status='verified' where id='$id'");
    $app =  mysqli_query($koneksi, "insert into tbl_dpt (nim, kode_akses, nama_mhs, jurusan, level) VALUES ('$nim','$kode_akses','$nama_mhs','$jurusan','user')");

    if ($app) { //jika berhasil
        echo "<script>alert('Berhasil');document.location='data-registrasi.php'</script>";
    } else {  //jika gagal
        echo "<script>alert('Coba ulangi lagi');document.location='data-registrasi.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../images/icons/favicon.ico">
    <title>Data Registrasi</title>
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
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <h2><i class="fa fa-user"> DATA REGISTRASI PEMILIH</i></h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th class="align-middle text-center">No</th>
                                    <th class="align-middle text-center">NIM</th>
                                    <th class="align-middle text-center">KodeAkses</th>
                                    <th class="align-middle text-center">Nama</th>
                                    <th class="align-middle text-center">Jurusan</th>
                                    <!--<th class="align-middle text-center">Kampus</th>-->
                                    <th class="align-middle text-center">Opsi</th>
                                </tr>
                                <?php
                                // Cek apakah terdapat data page pada URL
                                $page = (isset($_GET['page'])) ? $_GET['page'] : 1;

                                $limit = 100; // Jumlah data per halamannya

                                // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
                                $limit_start = ($page - 1) * $limit;

                                // Buat query untuk menampilkan data translate sesuai limit yang ditentukan
                                $data_dpt = mysqli_query($koneksi, "SELECT * FROM registrasi where status='baru' order by id asc LIMIT " . $limit_start . "," . $limit);
                                $no = $limit_start + 1; // Untuk penomoran tabel
                                while ($d = mysqli_fetch_array($data_dpt)) { // Ambil semua data dari hasil eksekusi $data_dpt
                                ?>
                                    <tr>
                                        <td class="align-middle text-center"><?php echo $no; ?></td>
                                        <td><?php echo $d['nim']; ?></td>
                                        <td><?php echo $d['kode_akses']; ?></td>
                                        <td style="text-transform: capitalize;"><?php echo $d['nama_mhs']; ?></td>
                                        <td><?php
                                            if ($d['jurusan'] == '1') {
                                                echo "Manajemen";
                                            } else {
                                                echo "Akuntansi";
                                            }
                                            ?></td>
                                        <td class="align-middle text-center">
                                            <!-- membuat tombol dengan ukuran small berwarna biru  -->
                                            <!-- data-target setiap modal harus berbeda, karena akan menampilkan data yang berbeda pula
        caranya membedakannya, gunakan id_barang sebagai pembeda data-target di setiap modal -->
                                            <a href="" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal<?php echo $d['id']; ?>">Verifikasi</a>

                                            <!-- untuk melihat bentuk-bentuk modal kalian bisa mengunjungi laman bootstrap dan cari modal di kotak pencariannya -->
                                            <!-- id setiap modal juga harus berbeda, cara membedakannya dengan menggunakan id_barang -->
                                            <div class="modal fade" id="modal<?php echo $d['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pemilih</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" class="form-control" value="<?php echo $d['id']; ?>">
                                                                    <label for="nomorsurat">NIM</label>
                                                                    <input type="text" name="nim" class="form-control" value="<?php echo $d['nim']; ?>">
                                                                </div>
                                                                <!--    <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" name="tanggal" class="form-control" value="<?php echo $d['tanggal']; ?>">
                            </div>
                        -->
                                                                <div class="form-group">
                                                                    <label for="keperluan">Password</label>
                                                                    <input type="text" name="kode_akses" class="form-control" value="<?php echo $d['kode_akses']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="keperluan">Nama Lengkap</label>
                                                                    <input type="text" name="nama_mhs" class="form-control" value="<?php echo $d['nama_mhs']; ?>">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="jurusan">Jurusan</label>
                                                                    <input type="text" name="jurusan" class="form-control" value="<?php echo $d['jurusan']; ?>">
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="edit" class="btn btn-primary"><i class="fa fa-check"> Verifikasi</i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $no++; // Tambah 1 setiap kali looping <img src="images/delete.png" style="width:15px; height:auto;">
                                }
                                ?>
                            </table>
                            <ul class="pagination">
                                <!-- LINK FIRST AND PREV -->
                                <?php
                                if ($page == 1) { // Jika page adalah page ke 1, maka disable link PREV
                                ?>
                                    <li class="disabled"><a href="#">First</a></li>
                                    <li class="disabled"><a href="#">&laquo;</a></li>
                                <?php
                                } else { // Jika page bukan page ke 1
                                    $link_prev = ($page > 1) ? $page - 1 : 1;
                                ?>
                                    <li><a href="data-registrasi.php?page=1">First</a></li>
                                    <li><a href="data-registrasi.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                                <?php
                                }
                                ?>

                                <!-- LINK NUMBER -->
                                <?php
                                // Buat query untuk menghitung semua jumlah data
                                $sql2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM registrasi where status='baru'");
                                $get_jumlah = mysqli_fetch_array($sql2);

                                $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
                                $jumlah_number = 5; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                                $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
                                $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

                                for ($i = $start_number; $i <= $end_number; $i++) {
                                    $link_active = ($page == $i) ? ' class="active"' : '';
                                ?>
                                    <li<?php echo $link_active; ?>><a href="data-registrasi.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php
                                }
                                    ?>

                                    <!-- LINK NEXT AND LAST -->
                                    <?php
                                    // Jika page sama dengan jumlah page, maka disable link NEXT nya
                                    // Artinya page tersebut adalah page terakhir 
                                    if ($page == $jumlah_page) { // Jika page terakhir
                                    ?>
                                        <li class="disabled"><a href="#">&raquo;</a></li>
                                        <li class="disabled"><a href="#">Last</a></li>
                                    <?php
                                    } else { // Jika Bukan page terakhir
                                        $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                                    ?>
                                        <li><a href="data-registrasi.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                                        <li><a href="data-registrasi.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
                                    <?php
                                    }
                                    ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "view/footer.php";
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