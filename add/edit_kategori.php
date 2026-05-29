<?php

include_once __DIR__ . "/../sambungkan.php";

$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['nama_kategori'];

$query = mysqli_query($conn, "UPDATE kategori SET

    nama_kategori = '$nama_kategori'

    WHERE id_kategori = '$id_kategori'
");

if ($query) {

    echo "
    <script>
        alert('Data berhasil diupdate');
        window.location='../index.php?page=kategori';
    </script>
    ";

} else {

    echo "
    <script>
        alert('Data gagal diupdate');
        window.location='../index.php?page=kategori';
    </script>
    ";

}
?>