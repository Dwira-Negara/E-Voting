<?php

include '../koneksi.php';

$nim = $_GET['nim'];

$pilih = mysqli_query($koneksi, "SELECT * FROM tbl_paslon WHERE nim='$nim' AND jenis='3'");
while ($data = mysqli_fetch_array($pilih)) {

    $hapus = mysqli_query($koneksi, "DELETE FROM tbl_paslon WHERE nim='$nim' AND jenis='3'");
    if ($hapus) { //jika berhasil
        echo "<script>alert('Suara Masuk Berhasil Di Hapus');document.location='dpt.php'</script>";
    } else {  //jika gagal
        echo "<script>alert('Suara Masuk Gagal Di Hapus, Coba ulangi lagi');document.location='dpt.php'</script>";
    }
}
