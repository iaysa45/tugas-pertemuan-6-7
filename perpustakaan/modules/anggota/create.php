<?php
include '../../config/koneksi.php';

$error = '';

if(isset($_POST['simpan'])){

    $kode = $_POST['kode_anggota'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $pekerjaan = $_POST['pekerjaan'];

    $tanggal_daftar = date('Y-m-d');
    $status = 'Aktif';

    // VALIDASI REQUIRED
    if(
        empty($kode) ||
        empty($nama) ||
        empty($email) ||
        empty($telepon) ||
        empty($alamat) ||
        empty($tanggal_lahir) ||
        empty($jk)
    ){
        $error = "Semua field wajib diisi!";
    }

    // VALIDASI EMAIL
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $error = "Format email tidak valid!";
    }

    // VALIDASI TELEPON
    elseif(!preg_match('/^08[0-9]{8,11}$/',$telepon)){
        $error = "Telepon harus 08xxxxxxxxxx";
    }

    // VALIDASI UMUR
    else{

        $umur = date('Y') - date('Y',strtotime($tanggal_lahir));

        if($umur < 10){
            $error = "Umur minimal 10 tahun!";
        }
    }

    // VALIDASI UNIQUE
    if(!$error){

        $cek = mysqli_query(
            $conn,
            "SELECT * FROM anggota
            WHERE kode_anggota='$kode'
            OR email='$email'"
        );

        if(mysqli_num_rows($cek)>0){
            $error = "Kode atau email sudah ada!";
        }
    }

    // UPLOAD FOTO
    $foto = null;

    if(!$error){

        if($_FILES['foto']['name']){

            $namaFoto =
                time().'_'.
                $_FILES['foto']['name'];

            move_uploaded_file(
                $_FILES['foto']['tmp_name'],
                "uploads/".$namaFoto
            );

            $foto = $namaFoto;
        }

        mysqli_query($conn,"
            INSERT INTO anggota
            (
            kode_anggota,
            nama,
            email,
            telepon,
            alamat,
            tanggal_lahir,
            jenis_kelamin,
            pekerjaan,
            tanggal_daftar,
            status,
            foto
            )
            VALUES
            (
            '$kode',
            '$nama',
            '$email',
            '$telepon',
            '$alamat',
            '$tanggal_lahir',
            '$jk',
            '$pekerjaan',
            '$tanggal_daftar',
            '$status',
            '$foto'
            )
        ");

        header("Location:index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Anggota</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="container mt-4">

<h2>Tambah Anggota</h2>

<a href="index.php"
class="btn btn-secondary mb-3">
Kembali
</a>

<?php if($error){ ?>

<div class="alert alert-danger">
<?= $error ?>
</div>

<?php } ?>

<form method="POST"
enctype="multipart/form-data">

<div class="mb-3">
<label>Kode Anggota</label>
<input type="text"
name="kode_anggota"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Nama</label>
<input type="text"
name="nama"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
name="email"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Telepon</label>
<input type="text"
name="telepon"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea
name="alamat"
class="form-control"
required></textarea>
</div>

<div class="mb-3">
<label>Tanggal Lahir</label>
<input type="date"
name="tanggal_lahir"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Jenis Kelamin</label>

<select
name="jenis_kelamin"
class="form-control"
required>

<option value="">
Pilih
</option>

<option value="Laki-laki">
Laki-laki
</option>

<option value="Perempuan">
Perempuan
</option>

</select>
</div>

<div class="mb-3">
<label>Pekerjaan</label>
<input type="text"
name="pekerjaan"
class="form-control">
</div>

<div class="mb-3">
<label>Foto</label>
<input type="file"
name="foto"
class="form-control">
</div>

<button
name="simpan"
class="btn btn-primary">

Simpan

</button>

</form>

</body>
</html>