<?php

include("config.php");

// cek apakah tombol daftar sudah diklik atau belum?
if(isset($_POST['daftar']))
{
    // ambil data dari formulir
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['sekolah_asal'];

    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    
    // me-rename nama fotonya dengan menambahkan tanggal dan jam upload
    $fotobaru = date('dmYHis').$foto;
    // menyetel path folder tempat menyimpan fotonya
    $path = "images/".$fotobaru;

    if(move_uploaded_file($tmp, $path))
    {
        // buat query
        $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal, foto) VALUE ('$nama', '$alamat', '$jk', '$agama', '$sekolah', '$fotobaru')";
        $query = mysqli_query($db, $sql);

        // apakah query simpan berhasil?
        if( $query ) 
        {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            header('Location: index.php?status=sukses');
        } 
        else 
        {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            header('Location: index.php?status=gagal');
        }   
    }
} 
else 
{
    die("Akses dilarang...");
}

?>