<?php
include 'koneksi.php';
if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $lokasi = $_POST['lokasi'];
    $kategori = $_POST['kategori'];

    $query = "INSERT INTO aduan (nama, nohp, alamat, tanggal, jam, lokasi, kategori) VALUES 
    ('$nama', '$nohp', '$alamat', '$tanggal', '$jam', '$lokasi', '$kategori')";
    echo "Data berhasil ditambahkan.";
    mysqli_query($koneksi, $query);
    }
    ?>
    
    
