<?php

include_once __DIR__ . "/../sambungkan.php";

$id_barang      = $_POST['id_barang'];
$qty            = $_POST['qty'];
$stok_baru      = $_POST['stok_baru'];
$isi_perpack    = $_POST['isi_pack'];
$harga_beli     = $_POST['modal_total'];
$harga_pcs      = $_POST['harga_pcs'];
$harga_pack     = $_POST['harga_pack'];
$keterangan     = $_POST['keterangan'];
$tanggal        = $_POST['tanggal'];


// AMBIL DATA BARANG LAMA
$getBarang = mysqli_query($conn, "
    SELECT *
    FROM barang
    WHERE id_barang='$id_barang'
");

$barang = mysqli_fetch_assoc($getBarang);

$stok_sebelum = $barang['stok'];

$stok_sesudah = $stok_baru;


// HITUNG MODAL PERPCS
$modal_perpcs = 0;

if ($qty > 0) {

    $modal_perpcs = round($harga_beli / $qty);

}


// UPDATE TABEL BARANG
$update = mysqli_query($conn, "
    UPDATE barang
    SET
        stok='$stok_sesudah',
        isi_perpack='$isi_perpack',
        harga_pcs='$harga_pcs',
        harga_pack='$harga_pack',
        modal='$modal_perpcs'
    WHERE id_barang='$id_barang'
");


// INSERT LOG BARANG MASUK
$insert = mysqli_query($conn, "
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
        '$qty',
        '$harga_beli',
        '$modal_perpcs',
        '$stok_sebelum',
        '$stok_sesudah',
        '$harga_pcs',
        '$harga_pack',
        '$isi_perpack',
        '$keterangan',
        '$tanggal'
    )
");


// VALIDASI
if ($update && $insert) {
    echo "
    <script>
        alert('Stok berhasil ditambahkan');
        window.location='../index.php?page=formMasuk';
    </script>
    ";

} else {
    echo "
    <script>
        alert('Gagal menambahkan barang masuk');
        window.history.back();
    </script>
    ";
}