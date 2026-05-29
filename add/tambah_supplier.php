<?php

include_once __DIR__ . "/../sambungkan.php";

$kode_supplier = $_POST['kode_supplier'];
$nama_supplier = $_POST['nama_supplier'];

$query = mysqli_query($conn, "INSERT INTO supplier (
    kode_supplier,
    nama_supplier
) VALUES (
    '$kode_supplier',
    '$nama_supplier'
)");

if ($query) {

    echo "
    <script>
        alert('Data berhasil ditambahkan');
        window.location='../index.php?page=suplier';
    </script>
    ";
} else {

    echo "
    <script>
        alert('Data gagal ditambahkan');
        window.location='../index.php?page=suplier';
    </script>
    ";
}
