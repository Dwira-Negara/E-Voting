<?php
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
$gusmint = mysqli_fetch_array($pengaturan);
$title = $gusmint['lembaga'];


if (isset($_POST['simpan'])) {
	$lembaga = mysqli_real_escape_string($koneksi, $_POST['lembaga']);
	$voting = mysqli_real_escape_string($koneksi, $_POST['voting']);
	$tambahan = mysqli_real_escape_string($koneksi, $_POST['tambahan']);
	$mulai = mysqli_real_escape_string($koneksi, $_POST['mulai']);
	$selesai = mysqli_real_escape_string($koneksi, $_POST['selesai']);

	mysqli_query($koneksi, "UPDATE pengaturan SET lembaga='$lembaga', voting='$voting', tambahan='$tambahan', mulai='$mulai', selesai='$selesai' WHERE id='1'");

	echo "<script>window.alert('Berhasil')
  window.location='index.php?page=pengaturan'</script>";
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array(
		1 =>    'Senin',
		'Selasa',
		'Rabu',
		'Kamis',
		'Jumat',
		'Sabtu',
		'Minggu'
	);

	$bulan = array(
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}
?>

<div id="page-inner">
	<div class="row">
		<div class="col-lg-12">
			<h2><i class="fa fa-calendar text-dark"> Pengaturan</i></h2>

			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Nama Lembaga</label>
					<input type="text" name="lembaga" class="form-control" value="<?php echo $title; ?>">
				</div>
				<div class="form-group">
					<label>Nama Pemilihan</label>
					<input type="text" name="voting" class="form-control" value="<?php echo $gusmint['voting']; ?>">
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<input type="text" name="tambahan" class="form-control" value="<?php echo $gusmint['tambahan']; ?>">
				</div>
				<div class="form-group">
					<label>Tanggal Mulai</label>
					<input type="datetime-local" name="mulai" class="form-control">
				</div>
				<div class="form-group">
					<label>Tanggal Selesai</label>
					<input type="datetime-local" name="selesai" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" name="simpan" value="Update" class="form-control">
				</div>
			</form>
		</div>
	</div>

	<?php
	$hasil = mysqli_query($koneksi, "SELECT * FROM pengaturan");
	while ($gusmint = mysqli_fetch_array($hasil)) {
	?>
		<div class="table-responsiv">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th>Lembaga</th>
					<th>Pemilihan</th>
					<th>Keterangan</th>
					<th>Mulai</th>
					<th>Selesai</th>
				</tr>
				<tr>
					<td><?php echo $gusmint['lembaga']; ?></td>
					<td><?php echo $gusmint['voting']; ?></td>
					<td><?php echo $gusmint['tambahan']; ?></td>
					<td><?php echo $gusmint['mulai']; ?></td>
					<td><?php echo $gusmint['selesai']; ?></td>
				</tr>
			</table>
		</div>
	<?php } ?>
</div>



<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
