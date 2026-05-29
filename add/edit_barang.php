<?php

include_once __DIR__ . "/../sambungkan.php";

$id_barang = $_POST['id_barang'];
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$stok = $_POST['stok'];
$harga_pcs = $_POST['harga_pcs'];
$harga_pack = $_POST['harga_pack'];
$modals = $_POST['modal'];
$id_kategori = $_POST['id_kategori'];
$id_supplier = $_POST['id_supplier'];
$isi_perpack = $_POST['isi_perpack'];

$query = mysqli_query($conn, "UPDATE barang SET

    kode_barang = '$kode_barang',
    nama_barang = '$nama_barang',
    stok = '$stok',
    id_kategori='$id_kategori',
    id_supplier='$id_supplier',
    harga_pcs = '$harga_pcs',
    harga_pack = '$harga_pack',
    isi_perpack = '$isi_perpack',
    modal = '$modals',
    updated_at = NOW()

    WHERE id_barang = '$id_barang'
");

if ($query) {

    echo "
    <script>
        alert('Data berhasil diupdate');
        window.location='../index.php?page=databrg';
    </script>
    ";
} else {

    echo "
    <script>
        alert('Data gagal diupdate');
        window.location='../index.php?page=databrg';
    </script>
    ";
}
