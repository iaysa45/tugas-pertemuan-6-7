<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM anggota WHERE id='$id'"
    )
);

$error='';

if(isset($_POST['update'])){

    $kode = $_POST['kode_anggota'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $pekerjaan = $_POST['pekerjaan'];
    $status = $_POST['status'];

    // REQUIRED
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

    // EMAIL
    elseif(!filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )){
        $error = "Email tidak valid!";
    }

    // TELEPON
    elseif(!preg_match(
        '/^08[0-9]{8,11}$/',
        $telepon
    )){
        $error = "Telepon harus 08xxxxxxxxxx";
    }

    // UMUR
    else{

        $umur =
            date('Y')
            -
            date(
                'Y',
                strtotime($tanggal_lahir)
            );

        if($umur < 10){
            $error = "Umur minimal 10 tahun";
        }
    }

    // UNIQUE
    if(!$error){

        $cek = mysqli_query(
            $conn,
            "SELECT *
            FROM anggota
            WHERE
            (
                kode_anggota='$kode'
                OR email='$email'
            )
            AND id!='$id'"
        );

        if(mysqli_num_rows($cek)>0){
            $error =
            "Kode atau email sudah digunakan!";
        }
    }

    // FOTO
    $foto = $data['foto'];

    if(!$error){

        if($_FILES['foto']['name']){

            if(
                $foto &&
                file_exists(
                    "uploads/".$foto
                )
            ){
                unlink(
                    "uploads/".$foto
                );
            }

            $namaFoto =
                time().'_'.
                $_FILES['foto']['name'];

            move_uploaded_file(
                $_FILES['foto']['tmp_name'],
                "uploads/".$namaFoto
            );

            $foto = $namaFoto;
        }

        mysqli_query(
            $conn,
            "UPDATE anggota SET

            kode_anggota='$kode',
            nama='$nama',
            email='$email',
            telepon='$telepon',
            alamat='$alamat',
            tanggal_lahir='$tanggal_lahir',
            jenis_kelamin='$jk',
            pekerjaan='$pekerjaan',
            status='$status',
            foto='$foto'

            WHERE id='$id'"
        );

        header(
            "Location:index.php"
        );
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Anggota</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="container mt-4">

<h2>Edit Anggota</h2>

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
<label>Kode</label>
<input
type="text"
name="kode_anggota"
class="form-control"
value="<?= $data['kode_anggota'] ?>"
required>
</div>

<div class="mb-3">
<label>Nama</label>
<input
type="text"
name="nama"
class="form-control"
value="<?= $data['nama'] ?>"
required>
</div>

<div class="mb-3">
<label>Email</label>
<input
type="email"
name="email"
class="form-control"
value="<?= $data['email'] ?>"
required>
</div>

<div class="mb-3">
<label>Telepon</label>
<input
type="text"
name="telepon"
class="form-control"
value="<?= $data['telepon'] ?>"
required>
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea
name="alamat"
class="form-control"
required><?= $data['alamat'] ?></textarea>
</div>

<div class="mb-3">
<label>Tanggal Lahir</label>
<input
type="date"
name="tanggal_lahir"
class="form-control"
value="<?= $data['tanggal_lahir'] ?>"
required>
</div>

<div class="mb-3">
<label>Jenis Kelamin</label>

<select
name="jenis_kelamin"
class="form-control">

<option
<?= $data['jenis_kelamin']=='Laki-laki' ? 'selected' : '' ?>>
Laki-laki
</option>

<option
<?= $data['jenis_kelamin']=='Perempuan' ? 'selected' : '' ?>>
Perempuan
</option>

</select>

</div>

<div class="mb-3">
<label>Pekerjaan</label>
<input
type="text"
name="pekerjaan"
class="form-control"
value="<?= $data['pekerjaan'] ?>">
</div>

<div class="mb-3">
<label>Status</label>

<select
name="status"
class="form-control">

<option value="Aktif"
<?= $data['status']=='Aktif' ? 'selected':'' ?>>
Aktif
</option>

<option value="Nonaktif"
<?= $data['status']=='Nonaktif' ? 'selected':'' ?>>
Nonaktif
</option>

</select>

</div>

<div class="mb-3">

<label>Foto Lama</label><br>

<?php if($data['foto']){ ?>

<img
src="uploads/<?= $data['foto'] ?>"
width="100">

<?php } else { ?>

Tidak ada foto

<?php } ?>

</div>

<div class="mb-3">
<label>Foto Baru</label>
<input
type="file"
name="foto"
class="form-control">
</div>

<button
name="update"
class="btn btn-warning">

Update

</button>

</form>

</body>
</html>