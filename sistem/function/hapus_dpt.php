<?php
include '../../koneksi.php';

$nim= $_GET['nim'];

//$pilih = mysqli_query($koneksi,"SELECT * FROM tbl_dpt WHERE nim='$nim'");
//while($data = mysqli_fetch_array($pilih)){
//$foto =$data['ktm'];
//unlink("images/".$foto);

//mysqli_query($koneksi,"UPDATE registrasi set status='baru' WHERE nim='$nim'");
$hapus = mysqli_query($koneksi,"DELETE FROM registrasi WHERE nim='$nim'");
if($hapus){ //jika berhasil
    echo "<script>alert('Data Berhasil Di Hapus');document.location='../upload_dpt.php'</script>";
}else{  //jika gagal
    echo "<script>alert('Data Gagal Di Hapus, Coba ulangi lagi');document.location='../upload_dpt.php'</script>";
}
//}
?>