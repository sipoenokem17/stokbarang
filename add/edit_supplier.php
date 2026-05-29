<?php

include_once __DIR__ . "/../sambungkan.php";

$id_supplier = $_POST['id_supplier'];
$kode_supplier = $_POST['kode_supplier'];
$nama_supplier = $_POST['nama_supplier'];

$query = mysqli_query($conn, "UPDATE supplier SET

    kode_supplier = '$kode_supplier',
    nama_supplier = '$nama_supplier'

    WHERE id_supplier = '$id_supplier'
");

if ($query) {

    echo "
    <script>
        alert('Data berhasil diupdate');
        window.location='../index.php?page=suplier';
    </script>
    ";

} else {

    echo "
    <script>
        alert('Data gagal diupdate');
        window.location='../index.php?page=suplier';
    </script>
    ";

}
?>