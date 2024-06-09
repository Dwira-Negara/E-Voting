<?php
include '../koneksi.php';

//$pilih = mysqli_query($koneksi,"SELECT * FROM registrasi");
//while($data = mysqli_fetch_array($pilih)){


$hapus = mysqli_query($koneksi, "DELETE FROM registrasi WHERE status='verified'");
if ($hapus) { //jika berhasil
    echo "<script>alert('Data Berhasil Di Hapus');document.location='upload_dpt.php'</script>";
} else {  //jika gagal
    echo "<script>alert('Data Gagal Di Hapus, Coba ulangi lagi');document.location='upload_dpt.php'</script>";
}
//}
