<?php
session_start();

if( !isset($_SESSION['session_login']) ){
    header('Location: login.php');
    exit;
}
    require "function.php";

    if(isset($_POST['submit'])){


        if(tambah_data($_POST) > 0){
           echo "<script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'index.php';
                </script>";
        }else{
            echo "<script>
                alert('Data gagal ditambahkan');
                </script>"; 
        };
    }
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Tambah Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>


<body class="page-form">


<div class="container">


    <div class="form-card">


        <h3>Tambah Data Mahasiswa</h3>


        <form action="" method="post" enctype="multipart/form-data">


            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" name="nim" placeholder="Masukkan NIM">
            </div>


            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" placeholder="Masukkan nama mahasiswa">
            </div>


            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Masukkan email">
            </div>


            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input type="text" name="jurusan" placeholder="Masukkan jurusan">
            </div>


            <div class="form-group">
                <label for="gambar">Gambar</label>
                <!-- <input type="text" name="gambar" placeholder="Contoh: mahasiswa1.jpg"> -->
                <input type="file" name="gambar">
            </div>


            <div class="button-group">
                <button type="submit" name="submit" class="btn btn-tambah"> Tambah Data </button>
                <a href="index.php" class="btn btn-kembali"> Kembali </a>
            </div>


        </form>


    </div>


</div>


</body>
</html>
