<?php
$pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan");
$gusmint = mysqli_fetch_array($pengaturan);

?>

<!-- /. HEADER  -->
<div class="navbar navbar-fixed-top" style="background-color: #6610f2; height: 11vh;">
    <div class="adjust-nav">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="#" style="color:white; font-weight:bold; font-size:20px;">
                <img src="../images/logo-evoting.png" alt="" style="width:55px; height:45px;"> SELAMAT DATANG DI E-VOTING
            </a>
            <!--
        <img src="../images/logo.png" alt="" style="max-width:70px; height:50px;"> <?php echo $gusmint['lembaga']; ?> </a>
        -->
        </div>
    </div>
</div>


<!-- /. SIDE NAV BAR  -->
<nav class="navbar-default navbar-side" role="navigation" style="background-color: #292929; height: auto;">
    <div class="sidebar-collapse">
        <div class="menu">
            <ul class="nav" id="main-menu">

                <li><a href="index.php?page=home"><i class="fa fa-desktop"></i>Beranda</a></li><br>
                <?php
                if ($_SESSION['level'] == 'admin') {
                ?>
                    <li><a href="index.php?page=data-paslon"><i class="fa fa-user "></i>Input Data Paslon</a></li><br>
                    <li><a href="dpt-upload.php"><i class="fa fa-file"></i>Data Pemilih</a></li><br>
                    <li><a href="dpt.php"><i class="fa fa-th"></i>Data Suara Masuk</a></li><br>

                    <li><a href="hasil_suara.php"><i class="fa fa-chart-bar"></i>Hasil Suara</a></li><br>
                    <li><a href="index.php?page=pengaturan"><i class="fa fa-calendar text-dark"></i>Pengaturan</a></li><br>
                <?php } ?>
                <li><a href="../logout.php"><i class="fa fa-circle-o-notch "></i>Logout</a></li><br>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </ul>
        </div>
    </div>
</nav>