<?php

include_once __DIR__ . "/../sambungkan.php";

$id_supplier = $_GET['id'];

$query = mysqli_query($conn, "UPDATE supplier SET

    status = 'nonaktif'

    WHERE id_supplier = '$id_supplier'

");

if ($query) {

    echo "
    <script>
        alert('supplier berhasil dihapus');
        window.location='../index.php?page=suplier';
    </script>
    ";

} else {

    echo "
    <script>
        alert('supplier gagal dihapus');
        window.location='../index.php?page=suplier';
    </script>
    ";

}
?>