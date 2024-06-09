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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="../icons/favicon.ico">
	<title>Data Suara</title>
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
						<h2><i class="fa fa-user"> Data Suara</i></h2>

						<form action="dpt.php" method="GET">
							<label>Cari Nama :</label>
							<input type="text" name="cari">
							<input type="submit" value="Cari">
						</form>

						<?php
						if (isset($_GET['cari'])) {
							$cari = $_GET['cari'];
							echo "<b>Hasil pencarian : " . $cari . "</b>";
						}
						?>

						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<tr>
									<th style="text-align:center;">No</th>
									<th style="text-align:center;">Username</th>
									<th style="text-align:center;">Nama</th>
									<th style="text-align:center;">Vote</th>
									<th style="text-align:center;">Waktu</th>
									<th style="text-align:center;">Opsi</th>
								</tr>
								<?php
								// Cek apakah terdapat data page pada URL
								$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

								$limit = 100; // Jumlah data per halamannya

								// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
								$limit_start = ($page - 1) * $limit;

								// Buat query untuk menampilkan data dan pencarian
								if (isset($_GET['cari'])) {
									$cari = $_GET['cari'];
									$data_dpt = mysqli_query($koneksi, "SELECT * FROM tbl_paslon where nama_mhs like '%" . $cari . "%' LIMIT " . $limit_start . "," . $limit);
								} else {
									$data_dpt = mysqli_query($koneksi, "SELECT * FROM tbl_paslon ORDER BY jenis LIMIT " . $limit_start . "," . $limit);
								}


								$no = $limit_start + 1; // Untuk penomoran tabel
								while ($d = mysqli_fetch_array($data_dpt)) { // Ambil semua data dari hasil eksekusi $data_dpt
								?>
									<tr>
										<td class="align-middle text-center"><?php echo $no; ?></td>
										<td><?php echo $d['nim']; ?></td>
										<td><?php echo $d['nama_mhs']; ?></td>
										<td style="text-align:center;"><?php echo $d['vote']; ?></td>
										<td style="text-align:center;"><?php echo $d['waktu']; ?></td>
										<td style="text-align:center;"><a class="btn btn-danger btn-circle" onclick="return confirm('Apakah Anda Yakin akan mengHAPUS suara ini ?!')" href="reset_suara.php?id=<?php echo $d['id']; ?>"><i class="fa fa-recycle"></i></a></td>
									</tr>
								<?php
									$no++; // Tambah 1 setiap kali looping
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
									<li><a href="dpt.php?page=1">First</a></li>
									<li><a href="dpt.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
								<?php
								}
								?>

								<!-- LINK NUMBER -->
								<?php
								// Buat query untuk menghitung semua jumlah data
								$sql2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tbl_paslon");
								$get_jumlah = mysqli_fetch_array($sql2);

								$jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
								$jumlah_number = 5; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
								$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
								$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

								for ($i = $start_number; $i <= $end_number; $i++) {
									$link_active = ($page == $i) ? ' class="active"' : '';
								?>
									<li<?php echo $link_active; ?>><a href="dpt.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
										<li><a href="dpt.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
										<li><a href="dpt.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
									<?php
									}
									?>
							</ul>

						</div>
					</div>
					<!-- /. ROW  -->
				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>


		<?php
		include "view/footer.php";
		?>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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