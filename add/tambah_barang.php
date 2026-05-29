<?php

include_once __DIR__ . "/../sambungkan.php";

$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$id_kategori = $_POST['id_kategori'];
$id_supplier = $_POST['id_supplier'];
$stok        = $_POST['stok'];
$isi_perpack = $_POST['isi_perpack'];
$harga_pcs   = $_POST['harga_pcs'];
$harga_pack  = $_POST['harga_pack'];
$modalinput  = $_POST['modal'];

$modal = $modalinput / $stok;

$query = mysqli_query($conn, "INSERT INTO barang (
    kode_barang,
    nama_barang,
    id_kategori,
    id_supplier,
    stok,
    isi_perpack,
    harga_pcs,
    harga_pack,
    modal,
    created_at,
    updated_at
) VALUES (
    '$kode_barang',
    '$nama_barang',
    '$id_kategori',
    '$id_supplier',
    '$stok',
    '$isi_perpack',
    '$harga_pcs',
    '$harga_pack',
    '$modal',
    NOW(),
    NOW()
)");


$tanggal = date('Y-m-d');
$id_barang = mysqli_insert_id($conn);
$insertMasuk = mysqli_query($conn, "

    INSERT INTO barang_masuk (

        id_barang,
        qty,
        harga_beli,
        modal_perpcs,
        stok_sebelum,
        stok_sesudah,
        harga_pcs,
        harga_pack,
        isi_perpack,
        keterangan,
        tanggal

    ) VALUES (

        '$id_barang',
        '$stok',
        '$modalinput',
        '$modal',
        '0',
        '$stok',
        '$harga_pcs',
        '$harga_pack',
        '$isi_perpack',
        'Tambah Barang',
        '$tanggal'
    )

");

if ($query) {

    echo "
    <script>
        alert('Data berhasil ditambahkan');
        window.location='../index.php?page=databrg';
    </script>
    ";
} else {

    echo "
    <script>
        alert('Data gagal ditambahkan');
        window.location='../index.php?page=databrg';
    </script>
    ";
}
