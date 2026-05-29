<?php

include_once __DIR__ . "/../sambungkan.php";

// ==========================
// AMBIL ID
// ==========================

$id_keranjang = $_GET['id'];

// ==========================
// AMBIL DATA KERANJANG
// ==========================

$getKeranjang = mysqli_query($conn, "

    SELECT *

    FROM keranjang

    WHERE id_keranjang = '$id_keranjang'

");

$data = mysqli_fetch_assoc($getKeranjang);

$id_barang = $data['id_barang'];
$qty       = $data['qty'];
$tipe_jual = $data['tipe'];

// ==========================
// AMBIL DATA BARANG
// ==========================

$getBarang = mysqli_query($conn, "

    SELECT *

    FROM barang

    WHERE id_barang = '$id_barang'

");

$barang = mysqli_fetch_assoc($getBarang);

$stok_sekarang = $barang['stok'];
$isi_pack      = $barang['isi_perpack'];

// ==========================
// HITUNG BALIK STOK
// ==========================

// if ($tipe_jual == 'pack') {

//     $qty_real = $qty * $isi_pack;
// } else {

//     $qty_real = $qty;
// }
$qty_real = $qty;

$stok_baru = $stok_sekarang + $qty_real;

// ==========================
// UPDATE STOK BARANG
// ==========================

mysqli_query($conn, "

    UPDATE barang

    SET stok = '$stok_baru'

    WHERE id_barang = '$id_barang'

");

// ==========================
// HAPUS KERANJANG
// ==========================

mysqli_query($conn, "

    DELETE FROM keranjang

    WHERE id_keranjang = '$id_keranjang'

");

// ==========================
// REDIRECT
// ==========================

echo "

    <script>

        alert('Data keranjang berhasil dihapus!');

        window.location='../index.php?page=keranjang';

    </script>

";
