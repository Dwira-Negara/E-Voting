<?php

include '../koneksi.php';

$id = $_GET['id'];

$pilih = mysqli_query($koneksi, "SELECT * FROM tbl_paslon WHERE id='$id'");
while ($data = mysqli_fetch_array($pilih)) {

    $hapus = mysqli_query($koneksi, "DELETE FROM tbl_paslon WHERE id='$id'");
    if ($hapus) { //jika berhasil
        echo "<script>alert('Suara Masuk Berhasil Di Hapus');document.location='dpt.php'</script>";
    } else {  //jika gagal
        echo "<script>alert('Suara Masuk Gagal Di Hapus, Coba ulangi lagi');document.location='dpt.php'</script>";
    }
}
