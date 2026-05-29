<?php

include_once __DIR__ . "/../sambungkan.php";

// ==========================
// AMBIL DATA FORM
// ==========================
$id_barang   = $_POST['id_barang'];
$qty         = (int) $_POST['qty'];
$tipe_jual   = $_POST['tipe_jual'];
$tanggal     = $_POST['tanggal'];
$keterangan  = $_POST['keterangan'];
$updstok     = $_POST['updstok'];
$harga_pcs  = $_POST['harga_pcs'];
$harga_pack = $_POST['harga_pack'];


// ==========================
// AMBIL DATA BARANG
// ==========================

$getBarang = mysqli_query($conn, "
    SELECT *
    FROM barang
    WHERE id_barang='$id_barang'

");

$barang = mysqli_fetch_assoc($getBarang);
$stok_lama  = $barang['stok'];
$modal_pcs  = $barang['modal'];
$isi_pack   = $barang['isi_perpack'];


// ==========================
// VALIDASI STOK
// ==========================

if ($qty > $stok_lama) {
    echo "
        <script>
            alert('Stok tidak mencukupi!');
            window.location='../index.php?page=formKeluar';
        </script>
    ";
    exit;
}
// ==========================
// LOGIKA HARGA
// ==========================
if ($tipe_jual == 'pcs') {
    $harga = $harga_pcs;
    $modal = $modal_pcs;
    $qtybaru   = $qty;

} else {
    $harga = $harga_pack;
    $modal = $modal_pcs * $isi_pack;
    $qtybaru   = $qty * $isi_pack;
}

// ==========================
// HITUNG
// ==========================
$subtotal = $harga * $qty;
$modals = $modal * $qty;
$profit = ($harga * $qty) - $modals;
// $stok_baru = $stok_lama - $qty;

// ==========================
// UPDATE STOK BARANG
// ==========================
mysqli_query($conn, "
    UPDATE barang
    SET stok='$updstok'
    WHERE id_barang='$id_barang'
");
// mysqli_query($conn, "
//     UPDATE barang
//     SET stok='$stok_baru'
//     WHERE id_barang='$id_barang'
// ");


// ==========================
// CEK KERANJANG
// ==========================
$cekKeranjang = mysqli_query($conn, "
    SELECT *
    FROM keranjang
    WHERE id_barang='$id_barang' AND tipe='$tipe_jual'
");

if (mysqli_num_rows($cekKeranjang) > 0) {
    $dataKeranjang = mysqli_fetch_assoc($cekKeranjang);
    $qty_baru = $dataKeranjang['qty'] + $qtybaru;
    $subtotal_baru = $dataKeranjang['subtotal'] + $subtotal;
    $profit_baru = $dataKeranjang['profit'] + $profit;
    mysqli_query($conn, "
        UPDATE keranjang
        SET
            qty='$qty_baru',
            harga='$harga',
            subtotal='$subtotal_baru',
            modal='$modals',
            profit='$profit_baru'
        WHERE id_barang='$id_barang' AND tipe='$tipe_jual'

    ");

} else {

    mysqli_query($conn, "

        INSERT INTO keranjang (

            id_barang,
            qty,
            stok_sebelum,
            Stok_sesudah,
            harga,
            subtotal,
            modal,
            tipe,
            keterangan,
            profit

        )

        VALUES (

            '$id_barang',
            '$qtybaru',
            '$stok_lama',
            '$updstok',
            '$harga',
            '$subtotal',
            '$modals',
            '$tipe_jual',
            '$keterangan',
            '$profit'

        )

    ");

}


// ==========================
// LOG BARANG KELUAR
// ==========================

// mysqli_query($conn, "

//     INSERT INTO barang_keluar (

//         id_barang,
//         qty,
//         stok_sebelum,
//         stok_sesudah,
//         keterangan,
//         tanggal

//     )

//     VALUES (

//         '$id_barang',
//         '$qty',
//         '$stok_lama',
//         '$updstok',
//         '$keterangan',
//         '$tanggal'

//     )

// ");


// ==========================
// REDIRECT
// ==========================

echo "

    <script>

        alert('Barang berhasil masuk keranjang!');

        window.location='../index.php?page=formKeluar';

    </script>

";

?>