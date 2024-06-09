<?php
session_start(); // Memulai sesi untuk menyimpan informasi pengguna yang login
if (!isset($_SESSION["login"])) { // Memeriksa apakah pengguna sudah login
    header("location:../index.php"); // Jika belum login, arahkan ke halaman login
    exit;
}

include '../koneksi.php'; // Menghubungkan ke file koneksi database

if (isset($_POST['upload'])) { // Memeriksa apakah tombol 'upload' telah ditekan
    $nim = $_POST['nim']; // Mengambil nilai NIM dari form
    $kode_akses = $_POST['kode_akses']; // Mengambil nilai kode akses dari form
    $nama_mhs = $_POST['nama_mhs']; // Mengambil nama mahasiswa dari form

    // Membuat query untuk memasukkan data ke tabel registrasi
    $sql = "INSERT INTO registrasi (nim, kode_akses, nama_mhs, status) VALUES ('$nim', '$kode_akses', '$nama_mhs', 'verified')";

    if (mysqli_query($koneksi, $sql)) { // Menjalankan query dan memeriksa apakah berhasil
        header("location:dpt-upload.php?berhasil=Data berhasil ditambahkan"); // Jika berhasil, arahkan ke halaman 'dpt-upload' dengan pesan sukses
        exit;
    } else {
        // Jika query gagal, tampilkan pesan error
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }

    mysqli_close($koneksi); // Menutup koneksi database
}
?>
