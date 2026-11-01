<?php
session_start();

if( !isset($_SESSION['session_login']) ){
    header('Location: login.php');
    exit;
}



    require 'function.php';
    // $mahasiswa = query_db("SELECT * FROM mahasiswa");

    // jumlah data yang ditampilkan per halaman
    $jumlahDataPerHalaman = 5;

    // hitung jumlah seluruh data
    $jumlahData = count(query_db("SELECT * FROM mahasiswa"));

    // hitung jumlah halaman
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    // halaman aktif
    $halamanAktif = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;

    // menentukan awal data
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    // ambil data mahasiswa berdasarkan pagination
    $mahasiswa = query_db(
        "SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman"

    );


    if(isset($_POST["cari"])){
        $keyword = $_POST["keyword"];
        $mahasiswa = cari_data($keyword);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-index">

    <div class="container">
        <h2 style="text-align: center">Hallo, selamat datang <?php echo $_SESSION['username']; ?></h2>

        <a href="logout.php">Logout</a>

        <h3 style="text-align: center">Daftar Mahasiswa UPI Purwakarta</h3>

        <div class="top-bar">
            <!-- Searching -->
            <form action="" method="post" class="search-box">
                <input type="text" name="keyword" placeholder="Cari mahasiswa...">
                <button type="submit" name="cari" class="btn btn-cari">Cari</button>
            </form>


            <!-- Tambah Data -->
            <a href="tambah_data.php" class="btn btn-tambah">+ Tambah Data</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Email</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1; ?>
                <?php foreach($mahasiswa as $data): ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $data["id"]; ?></td>
                    <td><?php echo $data["nim"]; ?></td>
                    <td><?php echo $data["nama"]; ?></td>
                    <td><?php echo $data["jurusan"]; ?></td>
                    <td><?php echo $data["email"]; ?></td>
                    <td>
                        <img src="img/<?php echo $data["gambar"]; ?>" alt=""width="90" height="90">
                    </td>
                    <td>
                        <a href="edit_data.php?id=<?php echo $data["id"]; ?>" class="btn btn-edit">Edit</a>
                        <a href="hapus_data.php?id=<?php echo $data["id"]; ?>" class="btn btn-hapus">Hapus</a>
                    </td>
                </tr>
                <?php $nomor++; ?>
                <?php endforeach ?>
            </tbody>
        </table>

        <br>
        <br>


        <!-- ================================== -->
        <!-- ============ PAGINATION ========== -->
        <!-- ================================== -->

        <div class="pagitaton-wrapper">
            <div class="pagination">

                <!-- PREVIOUS -->
                <?php if($halamanAktif > 1): ?>
                    <a href="?halaman=<?php echo $halamanAktif -1; ?>" class="prev">
                        &larr; Prev
                    </a>
                <?php else: ?>
                    <span class="pagination-disabled"> &larr; Prev </span>
                <?php endif; ?>

                <!-- NOMOR HALAMAN -->
                 <?php for($i=1; $i <= $jumlahHalaman; $i++): ?>
                    <?php if($i == $halamanAktif): ?>
                        <a href="?halaman<?php echo $i; ?>" class="active">
                            <?php echo $i; ?>
                        </a>
                    <?php else: ?>
                        <a href="?halaman=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>

                    <?php endif; ?>
                <?php endfor; ?>

                <!-- NEXT -->
                 <?php if($halamanAktif < $jumlahHalaman): ?>
                    <a href="?halaman=<?php echo $halamanAktif + 1; ?>" class="next">
                        Next &rarr; 
                    </a>
                <?php else: ?> 
                    <span class="pagination-disabled">
                        Next &rarr;
                    </span>
                <?php endif; ?>
            </div>
        </div>
            
        
    </div>


</body>
</html>