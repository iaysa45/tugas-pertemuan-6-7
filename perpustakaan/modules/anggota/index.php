<?php
include '../../config/koneksi.php';

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$jk = $_GET['jk'] ?? '';

$limit = 10;
$page = $_GET['page'] ?? 1;
$start = ($page - 1) * $limit;

$where = "WHERE 1=1";

if ($search != '') {
    $where .= " AND (
        nama LIKE '%$search%' OR
        email LIKE '%$search%' OR
        telepon LIKE '%$search%'
    )";
}

if ($status != '') {
    $where .= " AND status='$status'";
}

if ($jk != '') {
    $where .= " AND jenis_kelamin='$jk'";
}

$query = mysqli_query(
    $conn,
    "SELECT * FROM anggota
    $where
    ORDER BY id DESC
    LIMIT $start,$limit"
);

$total = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM anggota $where")
);

$pages = ceil($total / $limit);

$totalAnggota = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM anggota")
);

$totalAktif = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM anggota WHERE status='Aktif'")
);

$totalNonaktif = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM anggota WHERE status='Nonaktif'")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Anggota</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Data Anggota</h2>

<div class="row mb-3">
<div class="col">
<div class="card p-3">
Total Anggota: <b><?= $totalAnggota ?></b>
</div>
</div>

<div class="col">
<div class="card p-3">
Aktif: <b><?= $totalAktif ?></b>
</div>
</div>

<div class="col">
<div class="card p-3">
Nonaktif: <b><?= $totalNonaktif ?></b>
</div>
</div>
</div>

<a href="create.php" class="btn btn-primary">
Tambah Anggota
</a>

<a href="export_excel.php" class="btn btn-success">
Export Excel
</a>

<br><br>

<form method="GET">

<div class="row">

<div class="col">
<input type="text"
name="search"
class="form-control"
placeholder="Cari..."
value="<?= $search ?>">
</div>

<div class="col">
<select name="status" class="form-control">
<option value="">Semua Status</option>
<option value="Aktif">Aktif</option>
<option value="Nonaktif">Nonaktif</option>
</select>
</div>

<div class="col">
<select name="jk" class="form-control">
<option value="">Semua JK</option>
<option value="Laki-laki">Laki-laki</option>
<option value="Perempuan">Perempuan</option>
</select>
</div>

<div class="col">
<button class="btn btn-dark">
Filter
</button>
</div>

</div>
</form>

<br>

<table class="table table-bordered">

<tr>
<th>Foto</th>
<th>Kode</th>
<th>Nama</th>
<th>Email</th>
<th>Telepon</th>
<th>JK</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php while($d=mysqli_fetch_assoc($query)) { ?>

<tr>

<td width="90">

<?php if($d['foto']) { ?>

<img src="uploads/<?= $d['foto'] ?>"
width="70">

<?php } else { ?>

-

<?php } ?>

</td>

<td><?= $d['kode_anggota'] ?></td>
<td><?= $d['nama'] ?></td>
<td><?= $d['email'] ?></td>
<td><?= $d['telepon'] ?></td>

<td>

<?php
if($d['jenis_kelamin']=='Laki-laki'){
echo '<span class="badge bg-primary">Laki-laki</span>';
}else{
echo '<span class="badge bg-danger">Perempuan</span>';
}
?>

</td>

<td>

<?php
if($d['status']=='Aktif'){
echo '<span class="badge bg-success">Aktif</span>';
}else{
echo '<span class="badge bg-secondary">Nonaktif</span>';
}
?>

</td>

<td>

<a href="edit.php?id=<?= $d['id'] ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="delete.php?id=<?= $d['id'] ?>"
onclick="return confirm('Hapus data?')"
class="btn btn-danger btn-sm">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

<nav>

<?php for($i=1;$i<=$pages;$i++) { ?>

<a href="?page=<?= $i ?>"
class="btn btn-outline-primary">
<?= $i ?>
</a>

<?php } ?>

</nav>

</body>
</html>