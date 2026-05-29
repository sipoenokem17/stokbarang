<?php

include_once __DIR__ . "/../sambungkan.php";

$nama_Kategori = $_POST['nama_Kategori'];

$query = mysqli_query($conn, "INSERT INTO Kategori (
    nama_Kategori
) VALUES (
    '$nama_Kategori'
)");

if ($query) {

    echo "
    <script>
        alert('Data berhasil ditambahkan');
        window.location='../index.php?page=kategori';
    </script>
    ";
} else {

    echo "
    <script>
        alert('Data gagal ditambahkan');
        window.location='../index.php?page=kategori';
    </script>
    ";
}
