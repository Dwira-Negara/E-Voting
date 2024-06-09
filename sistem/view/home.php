<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2><i class="fa fa-desktop"> Beranda</i></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 ">
            <div class="alert alert-info">
                <strong>
                    <h2><b>Selamat Datang 
                        <?php 
                        if (isset($_SESSION['nama_mhs'])) {
                            $nama_mhs = $_SESSION['nama_mhs'];
                        } else {
                            $nama_mhs = "Pengguna";
                        }
                        echo $nama_mhs; 
                        ?>
                    </b></h2>
                </strong>
                <p>di TPS Online - <?php echo $title; ?></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php
            $username = $_SESSION['nim'];

            $bem = mysqli_query($koneksi, "SELECT * FROM tbl_paslon where nim = '$username' AND jenis ='1' ");
            $pilih1 = mysqli_fetch_array($bem);

            $status = ""; // Inisialisasi $status di sini
            $dpt = mysqli_query($koneksi, "SELECT * FROM registrasi where nim = '$username' ");
            $d = mysqli_fetch_array($dpt);
            if ($d) {
                $status = $d['status'];
            }

            if ($status == "baru") {
                echo "Akun Anda belum di-VERIFIKASI Oleh Panitia";
            } else {
            ?>
                <div class='table-responsiv'>
                    <table class='table table-striped table-bordered table-hover'>
                        <tr>
                            <th class="text-center">Pemilihan BEM</th>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <?php 
                                if ($pilih1 !== null && $pilih1['vote'] != "") {
                                    $fotopaslon1 = mysqli_query($koneksi, "SELECT * FROM data_paslon WHERE no_urut='" . $pilih1['vote'] . "' AND jenis ='1' ");
                                    $foto1 = mysqli_fetch_array($fotopaslon1);
                                    echo "<center><p>(Sudah Memilih)</p><img src='foto/" . $foto1["gambar1"] . "' style='max-width: 100px; height: auto; align: center;' class='img-responsive'></center>";
                                } else {
                                    echo "<center>Belum memilih</center>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="success">
                            <th class="text-center"><a class='btn btn-warning btn-circle' href='vote.php'>Pilih</a></th>
                        </tr>
                    </table>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
