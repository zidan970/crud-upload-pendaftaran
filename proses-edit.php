<?php

include("config.php");

// cek apakah tombol simpan sudah diklik atau belum?
if(isset($_POST['simpan']))
{
    // ambil data dari formulir
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['sekolah_asal'];

    // ambil data foto yang dipilih dari form
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if(empty($foto))
    {
        // buat query update
        $sql = "UPDATE calon_siswa SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', sekolah_asal='$sekolah' WHERE id=$id";
        $query = mysqli_query($db, $sql);

        // apakah query update berhasil?
        if( $query ) 
        {
            // kalau berhasil alihkan ke halaman list-siswa.php
            header('Location: list-siswa.php');
        } 
        else 
        {
            // kalau gagal tampilkan pesan
            die("Gagal menyimpan perubahan...");
        }
    }
    else
    {
        // me-rename nama fotonya dengan menambahkan tanggal dan jam upload
        $fotobaru = date('dmYHis').$foto;
        // menyetel path folder tempat menyimpan fotonya
        $path = "images/".$fotobaru;

        if(move_uploaded_file($tmp, $path))
        {
            // select query untuk mengambil data dari id 
            $sql = "SELECT foto FROM calon_siswa WHERE id=$id";
            $query = mysqli_query($db, $sql);
            $data = $query->fetch_assoc();
            
            // jika foto ada
            if(is_file("images/".$data['foto'])) 
            unlink("images/".$data['foto']);

            // buat query update
            $sql = "UPDATE calon_siswa SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', sekolah_asal='$sekolah', foto='$fotobaru' WHERE id=$id";
            $query = mysqli_query($db, $sql);

            // apakah query update berhasil?
            if( $query ) 
            {
                // kalau berhasil alihkan ke halaman list-siswa.php
                header('Location: list-siswa.php');
            } 
            else 
            {
                // kalau gagal tampilkan pesan
                die("Gagal menyimpan perubahan...");
            }
        }
    }
} 
else 
{
    die("Akses dilarang...");
}

?>