<?php

include_once __DIR__ . "/../sambungkan.php";

$id_barang = $_GET['id'];

$query = mysqli_query($conn, "UPDATE barang SET

    status = 'nonaktif',
    updated_at = NOW()

    WHERE id_barang = '$id_barang'

");

if ($query) {

    echo "
    <script>
        alert('Barang berhasil dihapus');
        window.location='../index.php?page=databrg';
    </script>
    ";

} else {

    echo "
    <script>
        alert('Barang gagal dihapus');
        window.location='../index.php?page=databrg';
    </script>
    ";

}
?>