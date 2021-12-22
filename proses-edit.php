<?php

include("config.php");

// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['simpan'])){

    // ambil data dari formulir
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['sekolah_asal'];

    // Ambil data foto yang dipilih dari form
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if(empty($foto)){
        // query update
        $sql = "UPDATE calon_siswa SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', sekolah_asal='$sekolah' WHERE id=$id";
        $query = mysqli_query($db, $sql);

            // if success
        if( $query ) {
            header('Location: list-siswa.php');
        } else {
            // if failed
            die("Gagal menyimpan perubahan...");
        }
    }
    else{
        // Lakukan proses update termasuk mengganti foto sebelumnya
        // Rename nama fotonya dengan menambahkan tanggal dan jam upload
        $fotobaru = date('dmYHis').$foto;
        // Set path folder tempat menyimpan fotonya
        $path = "images/".$fotobaru;

        if(move_uploaded_file($tmp, $path)){
            // // get id from query
            // $ids = $_GET['id'];

            // select query to get data from id 
            $sql = "SELECT foto FROM calon_siswa WHERE id=$id";
            $query = mysqli_query($db, $sql);
            $data = $query->fetch_assoc();
            
            if(is_file("images/".$data['foto'])) // Jika foto ada
            unlink("images/".$data['foto']);

            $sql = "UPDATE calon_siswa SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', sekolah_asal='$sekolah', foto='$fotobaru' WHERE id=$id";
            $query = mysqli_query($db, $sql);

            // if success
            if( $query ) {
                header('Location: list-siswa.php');
            } else {
                // if failed
                die("Gagal menyimpan perubahan...");
            }
        
        }

    }




} else {
    die("Akses dilarang...");
}

?>