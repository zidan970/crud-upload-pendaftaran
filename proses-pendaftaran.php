<?php

include("config.php");

// if register is successful
if(isset($_POST['daftar'])){

    // ambil data dari formulir
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['sekolah_asal'];

    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    // $foto = isset ($_FILES['foto']['name']) ? $_FILES['foto']['name'];:'';
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    // Rename nama fotonya dengan menambahkan tanggal dan jam upload
    $fotobaru = date('dmYHis').$foto;
    // Set path folder tempat menyimpan fotonya
    $path = "images/".$fotobaru;

    if(move_uploaded_file($tmp, $path)){
        // query to insert new data
        $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal, foto) VALUE ('$nama', '$alamat', '$jk', '$agama', '$sekolah', '$fotobaru')";
        $query = mysqli_query($db, $sql);

        // if success
        if( $query ) {
            //redirect to index.php with status=sukses
            header('Location: index.php?status=sukses');
        } else {
            // if fail, redirect with status gagal
            header('Location: index.php?status=gagal');
        }   
    }


} else {
    die("Akses dilarang...");
}
?>