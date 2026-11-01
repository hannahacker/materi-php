<?php


// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "upi_siak");


function query_db($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah_data($data){
    global $conn;

     $nim = $data['nim'];
        $nama = $data['nama'];
        $jurusan = $data['jurusan'];
        $email = $data['email'];
        // $gambar= $data['gambar'];

        // upload gambar
        $gambar = upload_gambar($nim, $nama);
        if( !$gambar ){
            return false;
        }


    $query =  "INSERT INTO mahasiswa(nim, nama, jurusan, email, gambar)
               VALUES ('$nim', '$nama', '$jurusan', '$email', '$gambar')
              ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_data($id){
    global $conn;

    $query = "DELETE FROM mahasiswa WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_data($data){
    global $conn;

    $id = $data['id'];
     $nim = $data['nim'];
     $nama = $data['nama'];
     $jurusan = $data['jurusan'];
     $email = $data['email'];
    //  $gambar= $data['gambar'];

    $gambar = upload_gambar($nim, $nama);
        if( !$gambar ){
            return false;
        }

     $query = "UPDATE mahasiswa SET
               nim = '$nim',
               nama = '$nama',
               jurusan = '$jurusan',
               email = '$email',
               gambar = '$gambar'
               WHERE id = $id

               ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// SEARCH
function cari_data($keyword) {
    global $conn;


    $keyword = mysqli_real_escape_string($conn, $keyword);


    $query = "SELECT * FROM mahasiswa
              WHERE
              nim LIKE '%$keyword%' OR
              nama LIKE '%$keyword%' OR
              email LIKE '%$keyword%' OR
              jurusan LIKE '%$keyword%'";


    return query_db($query);
}

// fungsi untuk upload gambar
function upload_gambar($nim, $nama){

    // setting file
    $namaFile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah ada file yang diupload atau tidak oleh si user saat mengisi form
    if( $error === 4 ){
        echo "<script>
            alert('Kamu belum upload file, silahkan upload file terlebih dahulu');
            </script>
        ";
        return false;
    }

    // cek lagi, apakah yang diupload oleh user itu file nya berupa gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
            alert('File yang kamu upload itu bukan jpg/jpegpng!');
            </script>
        ";
        return false;
    }

    // bikin aturan terkait ukuran file
    // cek jika ukuran file yang diinput oleh terlalu besar atau tidak
    // maks --> SMB
    if( $ukuranfile > 5000000 ){
        echo "<script>
            alert('File yang kamu upload terlalu besar ukurannya!');
            </script>
        ";
        return false;
    }

    // setelah melalui beberapa if, file yang diinput oleh user di form siap diupload 
    $namaFileBaru = $nim . "_" . $nama;
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;

}

//  fungsi untuk registrasi
function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi_password = mysqli_real_escape_string($conn, $data["konfirmasi_password"]);

    // cek username apabila sudah ada database atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('Username sudah terdaftar! Gunakan username lainnya!');
                </script>
        ";
        return false;
    }

    // cek konfirmasi password
    if($password !== $konfirmasi_password ){
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
                </script>
        ";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
    return mysqli_affected_rows($conn);
}

?>