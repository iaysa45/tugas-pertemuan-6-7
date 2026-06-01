<?php
include '../../config/koneksi.php';

header(
"Content-type: application/vnd-ms-excel"
);

header(
"Content-Disposition: attachment; filename=data_anggota.xls"
);
?>

<table border="1">

<tr>
<th>No</th>
<th>Kode</th>
<th>Nama</th>
<th>Email</th>
<th>Telepon</th>
<th>JK</th>
<th>Status</th>
<th>Pekerjaan</th>
</tr>

<?php

$no = 1;

$data = mysqli_query(
    $conn,
    "SELECT * FROM anggota"
);

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td><?= $no++ ?></td>
<td><?= $d['kode_anggota'] ?></td>
<td><?= $d['nama'] ?></td>
<td><?= $d['email'] ?></td>
<td><?= $d['telepon'] ?></td>
<td><?= $d['jenis_kelamin'] ?></td>
<td><?= $d['status'] ?></td>
<td><?= $d['pekerjaan'] ?></td>

</tr>

<?php } ?>

</table>