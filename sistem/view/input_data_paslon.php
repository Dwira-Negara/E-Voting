<?php
// Mengambil pengaturan dari tabel pengaturan dan menyimpannya dalam variabel $title
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
while ($gusmint = mysqli_fetch_array($pengaturan)) {
    $title = $gusmint['lembaga'];
}

// Jika tombol "simpan" diklik, maka dilakukan pengolahan data yang diunggah
if (isset($_POST['simpan'])) {
    // Mengambil data yang diunggah dari form
    $jenis = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $no_urut = mysqli_real_escape_string($koneksi, $_POST['no_urut']);
    $nm_paslon = mysqli_real_escape_string($koneksi, $_POST['nm_paslon']);

    // Mendefinisikan ekstensi file yang diperbolehkan
    $ekstensi_diperbolehkan = array('png', 'jpg', 'JPG', 'PNG', 'jpeg', 'JPEG');

    // Mengambil informasi file gambar pertama
    $gambar1 = $_FILES['gambar1']['name'];
    $x1 = explode('.', $gambar1);
    $ekstensi1 = strtolower(end($x1));
    $ukuran1 = $_FILES['gambar1']['size'];
    $file_tmp1 = $_FILES['gambar1']['tmp_name'];

    // Mengambil informasi file gambar kedua
    $gambar2 = $_FILES['gambar2']['name'];
    $x2 = explode('.', $gambar2);
    $ekstensi2 = strtolower(end($x2));
    $ukuran2 = $_FILES['gambar2']['size'];
    $file_tmp2 = $_FILES['gambar2']['tmp_name'];

    // Memeriksa apakah ekstensi file diizinkan dan ukuran file tidak terlalu besar
    if (in_array($ekstensi1, $ekstensi_diperbolehkan) === true && in_array($ekstensi2, $ekstensi_diperbolehkan) === true) {
        if ($ukuran1 <= 2000000 && $ukuran2 <= 2000000) {
            // Memindahkan file yang diunggah ke folder 'foto'
            move_uploaded_file($file_tmp1, 'foto/' . $gambar1);
            move_uploaded_file($file_tmp2, 'foto/' . $gambar2);

            // Menyimpan data paslon beserta nama gambar ke dalam tabel 'data_paslon'
            $query = mysqli_query($koneksi, "INSERT INTO data_paslon (jenis, no_urut, nm_paslon, gambar1, gambar2) VALUES ('$jenis', '$no_urut', '$nm_paslon', '$gambar1', '$gambar2')");

            // Jika penyimpanan berhasil, tampilkan pesan sukses
            if ($query) {
                echo "<script>window.alert('Berhasil'); window.location='index.php?page=data-paslon'</script>";
            } else {
                // Jika gagal, tampilkan pesan error
                echo "Error: " . mysqli_error($koneksi);
            }
        } else {
            // Jika ukuran file terlalu besar, tampilkan pesan
            echo "Ukuran file terlalu besar.";
        }
    } else {
        // Jika ekstensi file tidak diperbolehkan, tampilkan pesan
        echo "Ekstensi file tidak diperbolehkan.";
    }
}
?>
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2><i class="fa fa-user"> Input Paslon <?php echo $title; ?></i></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="jenis" value="1" class="form-control">
                </div>
                <div class="form-group">
                    <label>Nomor Urut</label>
                    <input type="text" name="no_urut" required="required" class="form-control">
                </div>
                <div class="form-group">
                    <label>Nama Paslon</label>
                    <input type="text" name="nm_paslon" required="required" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <label>Foto Paslon</label>
                    <input type="file" name="gambar1" required="required" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Visi Misi</label>
                    <input type="file" name="gambar2" required="required" class="form-control-file">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="simpan" value="Kirim" class="form-control">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2> Data Paslon</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th style="text-align:center;">No Urut</th>
                        <th style="text-align:center;">Nama Paslon</th>
                        <th style="text-align:center;">Foto Paslon</th>
                        <th style="text-align:center;">Visi-Misi</th>
                        <th style="text-align:center;">Opsi</th>
                    </tr>
                    <?php
                    $data_paslon = mysqli_query($koneksi, "SELECT * FROM data_paslon ORDER BY no_urut ASC");
                    while ($d = mysqli_fetch_array($data_paslon)) {
                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $d['no_urut']; ?></td>
                            <td><?php echo $d['nm_paslon']; ?></td>
                            <td style="text-align:center;"><img style="max-height: 50px; width:auto;" src="<?php echo "foto/" . $d['gambar1']; ?>"></td>
                            <td style="text-align:center;"><img style="max-height: 50px; width:auto;" src="<?php echo "foto/" . $d['gambar2']; ?>"></td>
                            <td style="text-align:center;"><a class="btn btn-danger btn-circle" onclick="return confirm('Yakin hapus data ini !!!')" href="hapus.php?id=<?php echo $d['id']; ?>">Hapus</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../js/sweetalert.min.js"></script>
<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>