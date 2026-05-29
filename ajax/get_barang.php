<?php

include_once __DIR__ . "/../sambungkan.php";

$id_barang = $_POST['id_barang'];

$query = mysqli_query($conn,"
    SELECT * FROM barang
    WHERE id_barang='$id_barang'
");

$data = mysqli_fetch_array($query);

echo json_encode($data);

?>