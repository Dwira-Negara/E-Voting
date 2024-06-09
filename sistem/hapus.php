<?php
include '../koneksi.php';

$id = $_GET['id'];

$pilih = mysqli_query($koneksi, "SELECT * FROM data_paslon WHERE id='$id'");
while ($data = mysqli_fetch_array($pilih)) {
    $gambar1 = $data['gambar1'];
    $gambar2 = $data['gambar2'];


    unlink("foto/" . $gambar1);
    unlink("foto/" . $gambar2);


    $hapus = mysqli_query($koneksi, "DELETE FROM data_paslon WHERE id='$id'");
    if ($hapus) { //jika berhasil
        echo "<script>alert('Data Berhasil Di Hapus');document.location='index.php?page=data-paslon'</script>";
    } else {  //jika gagal
        echo "<script>alert('Data Gagal Di Hapus, Coba ulangi lagi');document.location='index.php?page=data-paslon'</script>";
    }
}
