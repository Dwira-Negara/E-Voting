<?php
include '../../koneksi.php';

$nim= $_GET['nim'];
$level= ("user");


mysqli_query($koneksi,"UPDATE registrasi set status='verified' WHERE nim='$nim'");
$app = mysqli_query($koneksi,"insert into tbl_dpt (nim='$nim', kode_akses, nama_mhs, jurusan, level='$level') SELECT kode_akses, nama_mhs, jurusan FROM registrasi WHERE nim='$nim'");
if($app){ //jika berhasil
    echo "<script>alert('Berhasil');document.location='../data-registrasi.php'</script>";
}else{  //jika gagal
    echo "<script>alert('Coba ulangi lagi');document.location='../data-registrasi.php'</script>";
}

?>