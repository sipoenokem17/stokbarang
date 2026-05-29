<?php

include_once __DIR__ . "/../sambungkan.php";
// ==========================
// AMBIL DATA FORM
// ==========================

$id_keranjang = $_POST['id_keranjang'];
$qty_baru     = $_POST['qty'];
$keterangan   = $_POST['keterangan'];

// ==========================
// AMBIL DATA KERANJANG
// ==========================

$getKeranjang = mysqli_query($conn, "
    SELECT *
    FROM keranjang
    WHERE id_keranjang = '$id_keranjang'
");

$dataKeranjang = mysqli_fetch_assoc($getKeranjang);
$id_barang    = $dataKeranjang['id_barang'];
$qty_lama     = $dataKeranjang['qty'];
$tipe_jual    = $dataKeranjang['tipe'];
$harga_jual   = $dataKeranjang['harga'];


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
$modal_pcs     = $barang['modal'];


// ==========================
// KONVERSI QTY REAL
// ==========================

// if ($tipe_jual == 'pack') {
//     $qty_real_lama = $qty_lama * $isi_pack;
//     $qty_real_baru = $qty_baru * $isi_pack;
// } else {
//     $qty_real_lama = $qty_lama;
//     $qty_real_baru = $qty_baru;
// }
    $qty_real_lama = $qty_lama;
    $qty_real_baru = $qty_baru;

// ==========================
// BALIKIN STOK LAMA
// ==========================

$stok_dikembalikan = $stok_sekarang + $qty_real_lama;

// ==========================
// VALIDASI STOK
// ==========================

if ($qty_real_baru > $stok_dikembalikan) {
    echo "
        <script>
            alert('Stok tidak mencukupi!');
            window.location='../index.php?page=keranjang';
        </script>
    ";
    exit;
}
// ==========================
// HITUNG ULANG
// ==========================
$stok_baru = $stok_dikembalikan - $qty_real_baru;
$subtotal = $qty_baru * $harga_jual;

if ($tipe_jual == 'pack') {

    $modal_total = ($modal_pcs * $isi_pack) * $qty_baru;
} else {
    $modal_total = $modal_pcs * $qty_baru;
}
$profit = $subtotal - $modal_total;

// ==========================
// UPDATE BARANG
// ==========================

mysqli_query($conn, "
    UPDATE barang
    SET stok = '$stok_baru'
    WHERE id_barang = '$id_barang'
");

// ==========================
// UPDATE KERANJANG
// ==========================
mysqli_query($conn, "
    UPDATE keranjang
    SET
        qty            = '$qty_baru',
        subtotal       = '$subtotal',
        modal          = '$modal_total',
        profit         = '$profit',
        stok_sebelum   = '$stok_dikembalikan',
        stok_sesudah   = '$stok_baru',
        keterangan     = '$keterangan'
    WHERE id_keranjang = '$id_keranjang'
");

// ==========================
// REDIRECT
// ==========================
echo "
    <script>
        alert('Keranjang berhasil diupdate!');
        window.location='../index.php?page=keranjang';
    </script>
";

?>