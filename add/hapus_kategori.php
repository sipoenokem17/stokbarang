<?php

include_once __DIR__ . "/../sambungkan.php";

$id_kategori = $_GET['id'];

$query = mysqli_query($conn, "UPDATE kategori SET

    status = 'nonaktif'

    WHERE id_kategori = '$id_kategori'

");

if ($query) {

    echo "
    <script>
        alert('kategori berhasil dihapus');
        window.location='../index.php?page=kategori';
    </script>
    ";

} else {

    echo "
    <script>
        alert('kategori gagal dihapus');
        window.location='../index.php?page=kategori';
    </script>
    ";

}
?>