<?php

include("config.php");

if( isset($_GET['id']) )
{
    // ambil id dari query string
    $id = $_GET['id'];

    // select query untuk ambil data dari id 
    $sql = "SELECT foto FROM calon_siswa WHERE id=$id";
    $query = mysqli_query($db, $sql);
    $data = $query->fetch_assoc();
            
    // jika foto ada
    if(is_file("images/".$data['foto'])) 
        unlink("images/".$data['foto']);

    // buat query hapus
    $sql = "DELETE FROM calon_siswa WHERE id=$id";
    $query = mysqli_query($db, $sql);

    // apakah query hapus berhasil?
    if( $query )
    {
        header('Location: list-siswa.php');
    } else 
    {
        die("gagal menghapus...");
    }
} 
else 
{
    die("akses dilarang...");
}

?>