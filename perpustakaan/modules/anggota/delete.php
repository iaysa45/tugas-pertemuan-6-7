<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM anggota
        WHERE id='$id'"
    )
);

// Hapus foto
if(
    $data['foto'] &&
    file_exists(
        "uploads/".$data['foto']
    )
){
    unlink(
        "uploads/".$data['foto']
    );
}

// Hapus database
mysqli_query(
    $conn,
    "DELETE FROM anggota
    WHERE id='$id'"
);

header("Location:index.php");
exit;
?>